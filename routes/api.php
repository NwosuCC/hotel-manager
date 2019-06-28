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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


// Auth Routes :: for Admin
Route::namespace('Api\Auth')->group(function () {

  Route::post('/login', 'LoginController@login');
  Route::post('/logout', 'LoginController@logout');

});


Route::namespace('Api')->group(function () {

  Route::get('/', 'HotelController@index');

  Route::get('/room-types', 'RoomTypesController@index');

  Route::get('/rooms', 'RoomsController@index');

  Route::middleware('auth:api')->group(function () {

    Route::post('/room-types', 'RoomTypesController@store');
    Route::get('/room-types/{room_type}', 'RoomTypesController@show');
    Route::put('/room-types/{room_type}', 'RoomTypesController@update');
    Route::delete('/room-types/{room_type}', 'RoomTypesController@destroy');

  });

});