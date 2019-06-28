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

  // Guest Section
  Route::get('/', 'HotelController@index');

  Route::get('/room-types', 'RoomTypesController@index');
  Route::get('/room-types/paginated', 'RoomTypesController@paginate');
  Route::get('/room-types/{room_type}', 'RoomTypesController@show');

  Route::get('/rooms', 'RoomsController@index');
  Route::get('/rooms/{room}', 'RoomsController@show');


  // Auth Section
  Route::middleware('auth:api')->group(function () {

    // Room Types
    Route::post('/room-types', 'RoomTypesController@store');
    Route::put('/room-types/{room_type}', 'RoomTypesController@update');
    Route::delete('/room-types/{room_type}', 'RoomTypesController@destroy');

    // Rooms
    Route::post('/rooms', 'RoomsController@store');
    Route::put('/rooms/{room}', 'RoomsController@update');
    Route::delete('/rooms/{room}', 'RoomsController@destroy');

  });

});