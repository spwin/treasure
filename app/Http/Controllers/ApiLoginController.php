<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ApiLoginController extends Controller
{
    const REFRESH_TOKEN = 'refreshToken';

    public function login(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $attempt = $this->attemptLogin($email, $password, $request);

        return $attempt;
    }

    public function refresh(Request $request){
        //$refreshToken = $request->cookie(self::REFRESH_TOKEN);
        $refreshToken = $request->get('refresh_token');
        //return json_encode(['token' => $refreshToken]);
        return $this->proxy('refresh_token', [
            'refresh_token' => $refreshToken
        ], $request);
    }

    public function logout(){
        $accessToken = Auth::user()->token();

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        DB::table('users')
            ->where('id', Auth::user()->id)
            ->update([
                'remember_token' => Str::random(60)
            ]);

        $accessToken->revoke();

        cookie()->queue(cookie()->forget(self::REFRESH_TOKEN));
        return response(null, 204);
    }

    public function register(Request $request){
        $data = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'password_confirmation' => $request->get('password_confirmation')
        ];

        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return json_encode(['error' => $validator->errors()->first()]);
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        if($user){
            return json_encode(['response' => 'success']);
        }

        return json_encode(['error' => 'Failed to create new User.']);
    }


    public function attemptLogin($email, $password, $request)
    {

        $user = User::where('email', $email)->first();

        if (!is_null($user)) {
            return $this->proxy('password', [
                'username' => $email,
                'password' => $password
            ], $request);
        }

        return json_encode(['error' => 'There is no such user']);
    }

    public function proxy($grantType, array $data = [], $request)
    {
        $data = array_merge($data, [
            'client_id'     => env('PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSWORD_CLIENT_SECRET'),
            'grant_type'    => $grantType
        ]);

        $user_data = $data;

        $http = new Client(['http_errors' => false]);

        try {
            $response = $http->request('POST', url()->to('/').'/oauth/token', [
                'form_params' => $data,
            ]);

            if($response){
                $data = json_decode((string) $response->getBody());
                $status = $response->getStatusCode();
                if($status == 200) {
                    if ($data->refresh_token) {
                        $cookie = cookie(
                            self::REFRESH_TOKEN,
                            $data->refresh_token,
                            864000, // 10 days
                            null,
                            null,
                            false,
                            true // HttpOnly
                        );

                        if($user = Auth::guard('api')->user()){
                            $data->user_name = $user->name;
                        }elseif(array_key_exists('username', $user_data)){
                            if($user = User::where(['email' => $user_data['username']])->first()){
                                $data->user_name = $user->name;
                            }
                        } else {
                            $data->user_name = '';
                        }

                        $response = response()->json($data);
                        $response->headers->setCookie($cookie);

                        return $response;
                    }
                } else {
                    return json_encode(['error' => 'code: '.$status]);
                }
            }
        } catch (BadResponseException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }

        return json_encode(['error' => 'no response']);
    }
}
