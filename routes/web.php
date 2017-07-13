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

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => 5,
        'redirect_uri' => 'http://verhuur.dev/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://verhuur.dev/oauth/authorize?'.$query);
});

Route::get('/callback', function (\Illuminate\Http\Request $request) {
    $http = new GuzzleHttp\Client;


    $response = $http->post('http://verhuur.dev/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => '5',
            'client_secret' => '4PW54vEqFr1oF06DMxrdrMrBtQwFuaihYcCPex7f',
            'redirect_uri' => 'http://verhuur.dev/callback',
            'code' => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});