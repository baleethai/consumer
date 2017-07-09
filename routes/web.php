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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/redirect', function () {

    $query = http_build_query([
		'client_id'     => '3',
		'redirect_uri'  => 'https://web.leovel.com/callback',
		'response_type' => 'code',
		'scope'         => '',
    ]);

    return redirect('https://passport.leovel.com/oauth/authorize?'.$query);
});

Route::get('/callback', function (Request $request) {

    $http = new GuzzleHttp\Client;

    $response = $http->post('https://passport.leovel.com/oauth/token', [
        'form_params' => [
			'grant_type'    => 'authorization_code',
			'client_id'     => '3',
			'client_secret' => 'Z5v5G3pJea7XoL3toX452NPb7qOT7u5OQ8f3D9wC',
			'redirect_uri'  => 'https://web.leovel.com/callback',
			'code'          => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});
