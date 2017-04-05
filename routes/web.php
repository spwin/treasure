<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;
use Illuminate\Http\Response;

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();


Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => 3,
        'redirect_uri' => 'http://treasure.dev/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://treasure.dev/oauth/authorize?'.$query);
});


Route::get('/callback', function () {
    $http = new GuzzleHttp\Client;

    $response = $http->request('POST', 'http://treasure.dev/oauth/token', [
        'form_params' => [
            'grant_type' => 'password',
            'client_id' => 4,
            'client_secret' => 'igWyrWoFYiZ3EQu5Dg6wiuL6MxyDh4f5febHXWTv',
            'username' => 'spwinprp@gmail.com',
            'password' => 'spwin0411',
            'scope' => 'location',
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});

Route::get('/test', function() {
    $http = new GuzzleHttp\Client;

    $response = $http->request('POST', 'http://treasure.dev/api/user', [
        'headers' => [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImI3NzI3NzJhZTQ1NjU3OWMwMTNiYzI0ZDkwNTZlMTRlNDBkNjQ5MGVlNjNlMDcyMmY1YjRmYmJiOWY4ODg4NTUwYzU2YTBhOGFkNzQwNmQ3In0.eyJhdWQiOiI0IiwianRpIjoiYjc3Mjc3MmFlNDU2NTc5YzAxM2JjMjRkOTA1NmUxNGU0MGQ2NDkwZWU2M2UwNzIyZjViNGZiYmI5Zjg4ODg1NTBjNTZhMGE4YWQ3NDA2ZDciLCJpYXQiOjE0OTE0MDQwMjgsIm5iZiI6MTQ5MTQwNDAyOCwiZXhwIjoxNTIyOTQwMDI4LCJzdWIiOiIxIiwic2NvcGVzIjpbImxvY2F0aW9uIl19.AvG0qMAI9foLz-MQuGENh9xRPnj9j5dunyW62bOHValCJOib191gUnfjhsSyGb6y9H7H9BTNOyZ6ZhZFMdOpfJsdKE4anuViwQ9bexcOmnqjPa3CA6sdfUYCNLVeEIaY5HyxMkTqK5-xjpH2UJVeundD9E9C7Xhtip5vjv5b8DFwpXwIfn2GgNI0DA2j5ZfhH9L-nRhWv5TbGvX3T-TRu60afu7xGdABjR32uk9uCvg6sd5DdEwSupDJACxzAgrMYDbnB20wChrCITsZoBOAUS5x5o_aOrYFQLbia62WseVDL8_tw73Aqo1UavOxkpnHtKCdq6y76XWkhaL0Q8qWBxw7IOjSqcKSyxHkzWU3FiXnRI-exacbPjWS4SznBOUWogUSQb6pYVZ635a0O8Jm6d-w4FcRNUPTYsFaZT6t9bm5fyRqXBE9MShI-Ic1PLxyqtgFyM7YnVvIYsOCPk56lJQJWj0PJh901XzeqYnX4qkbozkV9_8XyLD6iI43xGtO7NO96STN4guHWIYnrqWpzMvh0yHF5Hq13aBCQcE3hIj4im1dEI__C6iQ2nL96wV2a5xWgpi1VYz8QrXxs-IFMJNEHPDSQ3_EVtajn52AyrKmKfIZL6PDHuYX2ZkhLM7UjtLvw9MCquigP7q8rvjn3kBLuxxi_Uu7mM0uq2IXAWU',
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});

Route::get('/home', 'HomeController@index');
