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

Auth::routes();

Route::get('{path}', function () {
    return view('index');
})->where('path', '(.*)');

Route::prefix('admin')->group(function () {
    Route::get('home', 'Admin\HomeController@index');
    Route::get('dates', 'Admin\DatesController@index');
    Route::get('api', 'Admin\HomeController@api');
});