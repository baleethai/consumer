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

Route::get('/', function () {

    $query = http_build_query([
		'client_id'     => '3',
		'redirect_uri'  => 'http://consumer.app/callback',
		'response_type' => 'code',
		'scope'         => '',
    ]);

    return redirect('http://oauth.app/oauth/authorize?'.$query);
});

Route::get('/callback', function (Request $request) {

    $http = new GuzzleHttp\Client;

    $response = $http->post('http://oauth.app/oauth/token', [
        'form_params' => [
			'grant_type'    => 'authorization_code',
			'client_id'     => '3',
			'client_secret' => 'RHiYGEsbPpWKzkMbse2UDMsORxcDpFa44nqCWZGN',
			'redirect_uri'  => 'http://consumer.app/callback',
			'code'          => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});
