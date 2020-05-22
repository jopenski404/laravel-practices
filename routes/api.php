<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Auth::routes();
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// For Users
Route::post('login', 'Auth\LoginController@login');
Route::post('get-all-users', 'API\UserController@getAllUsers');
Route::post('register', 'API\UserController@register');
Route::group(['middleware' => 'auth:api'], function(){
Route::post('details', 'API\UserController@details');
});

Route::post('update-details', 'API\UserController@updateDetails');




// For Cities
Route::post('list-cities','API\CitiesController@list');
Route::post('get-city','API\CitiesController@getCity');
Route::post('add-city','API\CitiesController@addCity');