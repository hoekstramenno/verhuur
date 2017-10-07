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
Route::get('magazijn/materiaal', 'Magazijn\MaterialsController@index');
Route::get('magazijn/materiaal/create', 'Magazijn\MaterialsController@create');
Route::get('magazijn/materiaal/{material}', 'Magazijn\MaterialsController@show');
Route::post('magazijn/materiaal/{material}/remarks', 'Magazijn\RemarksController@store');
Route::post('magazijn/materiaal', 'Magazijn\MaterialsController@store');

Auth::routes();

//Route::get('{path}', function () {
//    return view('index');
//})->where('path', '(.*)');

Route::prefix('admin')->group(function () {
    Route::get('home', 'Admin\HomeController@index');
    Route::get('dates', 'Admin\DatesController@index')->name('admin.dates.index');
    Route::get('dates/{date}', 'Admin\DatesController@edit')->name('admin.dates.edit');
    Route::patch('dates/{date}', 'Admin\DatesController@update')->name('admin.dates.update');
    Route::get('api', 'Admin\HomeController@api');
});

