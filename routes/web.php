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

    dd(json_decode((string) $response->getBody(), true));

});

Route::get('/user', function (Request $request) {
    
    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjQ2ODg4YzU1YTcwYzZkYTA1MGM5ZDY3ZjZkYzcyYTQ4ZTRhZGU2N2QxYTdlMWJkZDFmOGZkODk2MjVjZTMwMmE1ZjRlOGMzMGMwOWU0OTkyIn0.eyJhdWQiOiIzIiwianRpIjoiNDY4ODhjNTVhNzBjNmRhMDUwYzlkNjdmNmRjNzJhNDhlNGFkZTY3ZDFhN2UxYmRkMWY4ZmQ4OTYyNWNlMzAyYTVmNGU4YzMwYzA5ZTQ5OTIiLCJpYXQiOjE0OTk1NzA3NDMsIm5iZiI6MTQ5OTU3MDc0MywiZXhwIjoxNTAwODY2NzQzLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.zk6-gkdGF4d5qwUXU8gme_SHSrhAQHSookKyNw0A661fOV0sxUBiLIu-s7ON9BbQhlRVxdLCPR7oAvZoMFI4GcZThWZPrfo2kb7uTrNFYgKI9cjnPdSzoMD7Kx3V6eS7LvbePC_qXir4XvzgzoXqHn7u83HlP8WIuYxOFBasP3dv0GM-6ClaGw9yVQfcPSBWoZ8VReS19F-TZT3kVg8CFo45DPmVEBJDpeKD0Y6kHSkHz9hkiPGYZKGO_oejjPp5XhXGiG8oNZP_76LvxEtdcxXSdNHB9bT9wJqrOpvAVX1dbKMtWY0LpBVbv6YNlOk4VtAYtWlIQ9BDd3Q8PnT4ySknG5pMOcr8mP8rVQ1Q2tO5395TX2-H4PDU3umpZmJv6AQBVz8hOrvOXUR5ZFf0GvzPDl3Wq6PRN7hnU4hUeXsFcLon2PckxHuou2C6qkHa43_HsHuKStB3gze-yRzDUeauBBlPlOY-kfUeur_EDVocEVO8XGg62Gq2HhbxmNGaJ3q4ZXryeyAs3p40VjmznhvILVVfwyCw_Le0aVz5GgPewBULWl6SJu8ySc_0Gc_YGk8fTM1AL6hWK-Wa67VVpc57-D_eC5YjaxoWh5tew8BFtj17C2TrPXZ8ut8aGbzq1SnmL--bDkFdd7rtBF_NdK3x0hANcz2rlkaU0suj0u0';

    $http = new GuzzleHttp\Client;
    $response = $http->get('https://passport.leovel.com/api/user', [
        'headers' => [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ]
    ]);
    
    return json_decode((string) $response->getBody(), true);
});


