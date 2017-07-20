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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('login', 'Api\Auth\LoginController@login');
Route::post('refresh', 'Api\Auth\LoginController@refresh');


    Route::get('dates', 'Api\DatesController@index');
    Route::get('dates/{id}', 'Api\DatesController@show');
    Route::delete('dates/{id}', 'Api\DatesController@destroy');
    Route::get('dates/{id}/options', 'Api\DatesOptionsController@create');
    Route::post('dates/{id}/options', 'Api\DatesOptionsController@store');
    Route::post('options/{id}/bookings', 'Api\OptionsBookingsController@store');
    Route::post('logout', 'Api\Auth\LoginController@logout');


//Route::middleware(['auth:api'])->group(function () {
//    Route::get('dates', 'Api\DatesController@index');
//    Route::get('dates/{id}', 'Api\DatesController@show');
//    Route::get('dates/{id}/options', 'Api\DatesOptionsController@create');
//    Route::post('dates/{id}/options', 'Api\DatesOptionsController@store');
//    Route::post('options/{id}/bookings', 'Api\OptionsBookingsController@store');
//    Route::post('logout', 'Api\Auth\LoginController@logout');
//});
