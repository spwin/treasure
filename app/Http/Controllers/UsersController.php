<?php

namespace App\Http\Controllers;

use App\Coordinates;
use App\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index(){
        $users = User::all();
        foreach($users as $user){
            if(!$user->getCoordinates){
                $coordinates = new Coordinates();
                $coordinates->fill([
                    'lat' => 0,
                    'lon' => 0
                ]);
                $coordinates->save();
                $user->coordinates_id = $coordinates->id;
                $user->save();
            }
        }
        $user = Auth::user();
        $user->ip = request()->ip();
        $user->save();
        return view('users.list')->with([
            'users' => $users
        ]);
    }
}
