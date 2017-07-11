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
Log::useFiles('php://stderr');
Route::get('dates', 'DatesController@index');
Route::get('dates/{id}', 'DatesController@show');
Route::get('dates/{id}/options', 'DatesOptionsController@create');
Route::post('dates/{id}/options', 'DatesOptionsController@store');
Route::post('options/{id}/bookings', 'OptionsBookingsController@store');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Auth::routes();

Route::get('/home', 'HomeController@index');
