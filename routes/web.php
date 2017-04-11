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

Route::get('/home', 'HomeController@index');
Route::get('/test', 'HomeController@test');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/points', 'PointsController@index');
    Route::get('/points/add', 'PointsController@add');
    Route::post('/points/save', 'PointsController@save');
    Route::get('/points/delete', 'PointsController@delete');
});