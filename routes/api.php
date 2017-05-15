<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'v1'], function() {
    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::get('/points/remove', 'ApiPointsController@gatheredResource');

        Route::get('/points/get', 'ApiPointsController@getPoints');
        Route::post('/logout', 'ApiLoginController@logout');
    });


    Route::post('/login', 'ApiLoginController@login');
    Route::post('/login/refresh', 'ApiLoginController@refresh');

    Route::post('/register', 'ApiLoginController@register');
});


// Ale is good