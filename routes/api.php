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

  Route::get('/demo', 'LoginController@demo');
  Route::post('/login', 'LoginController@login');
  Route::post('/logout', 'LoginController@logout');

});


Route::namespace('Api')->group(function () {

  /* ================================================================
   | Everyone can access
   * ------------------------------------------------------------*/

  // Home
  Route::get('/', 'HotelController@index');

  // Room Types
  Route::get('/room-types', 'RoomTypesController@index');
  Route::get('/room-types/paginated', 'RoomTypesController@paginate');
  Route::get('/room-types/{room_type}', 'RoomTypesController@show');

  // Rooms
  Route::get('/rooms', 'RoomsController@index');
  Route::get('/rooms/paginated', 'RoomsController@paginate');
  Route::get('/rooms/{room}', 'RoomsController@show');


  /* ================================================================
   | Only Auth Users can access
   * ------------------------------------------------------------*/
  Route::middleware('auth:api')->group(function () {

    // Bookings :: User can view own, Admin can view all
    Route::get('/bookings', 'BookingsController@index');
    Route::get('/bookings/paginated', 'BookingsController@paginate');
    Route::get('/bookings/{booking}', 'BookingsController@show');
    Route::post('/bookings', 'BookingsController@store');
    Route::put('/bookings/{booking}', 'BookingsController@update');
    Route::delete('/bookings/{booking}', 'BookingsController@destroy');

    /* ================================================================
     | Only Admin can access
     * ------------------------------------------------------------*/
    Route::middleware('admin')->group(function () {
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

});