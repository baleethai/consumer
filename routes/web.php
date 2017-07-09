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
    
    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjJjYzM4Nzg3MTc5MzdhMmQxYjIxNjUzNTgxMjc0MDA0N2VkMWNiNzhjYWQ4ZWU2ZTk3ZjdhYTg2MDcxM2UzYWI4Nzk1ZTY0YmQ3NTE0NWRjIn0.eyJhdWQiOiIzIiwianRpIjoiMmNjMzg3ODcxNzkzN2EyZDFiMjE2NTM1ODEyNzQwMDQ3ZWQxY2I3OGNhZDhlZTZlOTdmN2FhODYwNzEzZTNhYjg3OTVlNjRiZDc1MTQ1ZGMiLCJpYXQiOjE0OTk1NzU4OTQsIm5iZiI6MTQ5OTU3NTg5NCwiZXhwIjoxNTAwODcxODk0LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.jqjfNnCNi0lf2jtiGctUWeWsjNgzdhEg40DWim0oRnPeqO7r0aYvzrwFljnumcxRMskFn3kl3m3MhqkNmRD-R5b8zI8pP57oatjI9NZM9V21vPpy6SZUDyWJXalQg8BxKYPWAcPV3Rdf9Y2v_eGmjCWoU7Z7OdjmzBB6Aibo6no_W6nBTbXDIN_Tc-wgjpEVrUDvU4HHF8wHrW6z4Y_Vv_c4affDneqGL-MbqG_iDjdJUh8NuSPn5AE4wgn46BuTTVyFNz2ItDpcS42QbYLr96m4qeUspmaOc2vTK-mvXNfhEEPCiuLy75DgGDsNcwzwQrHZgez8jjdTZbKRVZ3z4aNnFzrXMGXDMdBrSMED81JSkZZRrSiZyoZLmTU5okDyINH2YDVCNYxwXd1J2m806Tae9a_BYSeclohvAQA29qjUjNWH4ZNXPsblw5EzhUZFJOE-RStYruzbkFZpX287DKf31p3RGRmTNbYjC0xVbevwCGhXvQGB2qzw8Bo9h6XWnH1uEhenEJw9WYKsbuPcAyp7SIvSSTUmIiX--lwFMoWM3J5EgRMf4NePbpRX7kEeZZBWJdjfha5yPj6syqcNen6JR5QLfERUfL99_VNht8Lbf-dq0ZIKsalfEZ7FZOEFRDdtELE3Yn21IDDRBOyr2oiwS_QAleuGQK7IvYbwfXY';

    $http = new GuzzleHttp\Client;
    $response = $http->get('https://passport.leovel.com/api/user', [
        'headers' => [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ]
    ]);
    
    return json_decode((string) $response->getBody(), true);
});

Route::get('/refresh', function (Request $request) {
    
    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjJjYzM4Nzg3MTc5MzdhMmQxYjIxNjUzNTgxMjc0MDA0N2VkMWNiNzhjYWQ4ZWU2ZTk3ZjdhYTg2MDcxM2UzYWI4Nzk1ZTY0YmQ3NTE0NWRjIn0.eyJhdWQiOiIzIiwianRpIjoiMmNjMzg3ODcxNzkzN2EyZDFiMjE2NTM1ODEyNzQwMDQ3ZWQxY2I3OGNhZDhlZTZlOTdmN2FhODYwNzEzZTNhYjg3OTVlNjRiZDc1MTQ1ZGMiLCJpYXQiOjE0OTk1NzU4OTQsIm5iZiI6MTQ5OTU3NTg5NCwiZXhwIjoxNTAwODcxODk0LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.jqjfNnCNi0lf2jtiGctUWeWsjNgzdhEg40DWim0oRnPeqO7r0aYvzrwFljnumcxRMskFn3kl3m3MhqkNmRD-R5b8zI8pP57oatjI9NZM9V21vPpy6SZUDyWJXalQg8BxKYPWAcPV3Rdf9Y2v_eGmjCWoU7Z7OdjmzBB6Aibo6no_W6nBTbXDIN_Tc-wgjpEVrUDvU4HHF8wHrW6z4Y_Vv_c4affDneqGL-MbqG_iDjdJUh8NuSPn5AE4wgn46BuTTVyFNz2ItDpcS42QbYLr96m4qeUspmaOc2vTK-mvXNfhEEPCiuLy75DgGDsNcwzwQrHZgez8jjdTZbKRVZ3z4aNnFzrXMGXDMdBrSMED81JSkZZRrSiZyoZLmTU5okDyINH2YDVCNYxwXd1J2m806Tae9a_BYSeclohvAQA29qjUjNWH4ZNXPsblw5EzhUZFJOE-RStYruzbkFZpX287DKf31p3RGRmTNbYjC0xVbevwCGhXvQGB2qzw8Bo9h6XWnH1uEhenEJw9WYKsbuPcAyp7SIvSSTUmIiX--lwFMoWM3J5EgRMf4NePbpRX7kEeZZBWJdjfha5yPj6syqcNen6JR5QLfERUfL99_VNht8Lbf-dq0ZIKsalfEZ7FZOEFRDdtELE3Yn21IDDRBOyr2oiwS_QAleuGQK7IvYbwfXY';

    $refreshToken = 'def5020060c0d23a2fae47b4ed7e8ba8e633451863e9a8f236c6325e6e280d6326b5b88f2d1bf0b601b7bfdeda6ebb292ca781b0445aa186c735135817572ab6db3246a4b245a8f19fdd868627336cdb7227541812238c7c11de13b71d3121077ff86b3020ec1012535e5cc4fb3fe83d28b7daf9c551bbbface319d8793c483f4d1905ed3d522f4190148781076a8f5186ba8af9e9b81b94b84da6536684c28d5614058275b55d60077653f7a5c03a29360545988f19ccfb6ff3951e16198a385847a23d60b628420c209aa09a54090c4b0c896aa18f1db41496d56c1d072d3ac72b7559660dc849f108ec27188b7943ac7f0b2544972d19afa89616a4f51f77190e0331d8b0674548dae7ff4d2c4476d867b491d1a83f8033b1638cbbfbe74dffa359c7ac5690487a8bb254007183ae691de4d0ffc2ca99394a27c012a8570a53b2b0474e6e80b35cd113af7e45e1f61c4055885c5773ebdef60342db9ffd4dbe';

    $http = new GuzzleHttp\Client;

    $response = $http->post('https://passport.leovel.com/oauth/token', [
        'form_params' => [
            'grant_type'    => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id'     => '3',
            'client_secret' => 'Z5v5G3pJea7XoL3toX452NPb7qOT7u5OQ8f3D9wC',
            'scope'         => '',
        ],
    ]);

    return json_decode((string) $response->getBody(), true);

});




