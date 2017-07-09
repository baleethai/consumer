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
use Illuminate\Cookie\CookieJar;

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

Route::get('/callback', function (Request $request, CookieJar $cookieJar) {

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

Route::get('/user', function (Request $request) {
    
    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjgxYWZhMTY1NzNjYmUxNjcxYTUwYjc0ZTkwNDRlMDhkYzMzNzhkMGQ4NGJkODEyZDcxNDA4ODE5YTM4NGU4NjljZjQ0OGI2OWQyYjk0ZTA3In0.eyJhdWQiOiIzIiwianRpIjoiODFhZmExNjU3M2NiZTE2NzFhNTBiNzRlOTA0NGUwOGRjMzM3OGQwZDg0YmQ4MTJkNzE0MDg4MTlhMzg0ZTg2OWNmNDQ4YjY5ZDJiOTRlMDciLCJpYXQiOjE0OTk1NzU3MzksIm5iZiI6MTQ5OTU3NTczOSwiZXhwIjoxNTAwODcxNzM5LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.xDpQjCmKK56NfcyP5vzF5pnlp-Ee6Z3p2jxJiLNHini08QlWUq8llKgPA92Wj4MGO4w9r3F6aquBMep48Ahvh3p0Oskll-Q6SCeJACsJOxQdSnwMKCr0yIiU7epMWoo1C_ZkGxDYJU0JuAhuQQCNVi_cb_MCNZnwo65UjZZsC2vwBGMSeqcD9bSZVM9TkdjABkwbJ5eoXnK66IPhbL3eTDzqOPc8zvq_kWtwjpEDc9i7PeQ0dboVkp-5tNqurenJUc84oYTiRNDZBgy7TQslalSNoAdoeuYyUmASLbAuuaplKhpxOzIGn1Hmt_mXyt7v7i81n2p-myAkwmf6P3W2Q7IRDroMxCik-uFjkxZTmhxfMQzPl1cNRDRrNjfDh8cWeWaAKBtntKDU8HNDiuku1a2Y0ERQEFs_Nj2fakPb6t6LSUCPIJHTWle4yuFlJI-oICch_q30wT1xA7ZaMysWc-yBh33a4SmDsqjfAXYcEfT-z6ONVkxAzHfk3xMhVbbe6Q6PxH8vws3G71cM8tkujPuLu4RiMaXELJ7IGG_J4DJITPU7k31mcm2JE5uRODj1Oy0p6Qa4fTq9PI6GlKxMt03zIS-n0h9gZrrhfFLfmyLlOzkIEJuUzkMya5Gg-taGYsITfUfLI09vrzU2gYKhf1E3Rg--TqQHd_FJ02db8v0';

    $http = new GuzzleHttp\Client;
    $response = $http->get('https://passport.leovel.com/api/user', [
        'headers' => [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ]
    ]);
    
    return json_decode((string) $response->getBody(), true);
});


