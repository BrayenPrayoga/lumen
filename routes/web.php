<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/version', function () use ($router) {
    return $router->app->version();
});

Route::group(['prefix' => 'api'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('profile', 'AuthController@me');

    Route::post('register-perorangan', 'RegisterController@register_perorangan');
    Route::post('register-instansi', 'RegisterController@register_instansi');
});

// Auth Bearer Statis
Route::group(['middleware' => 'auth.mitra','prefix' => 'api'], function () use ($router) {
    $router->post('pembayaran-simponi', 'MitraController@pembayaran_simponi');
});
// Auth Bearer Statis

// Auth Internal
Route::group(['middleware' => 'auth:internal','prefix' => 'internal'], function () use ($router) {
    $router->get('after-login', 'AuthController@afterLogin');
});
// Auth Internal

// Auth Pengguna
Route::group(['middleware' => 'auth:pengguna','prefix' => 'pengguna'], function () use ($router) {
    $router->get('after-login', 'AuthController@afterLogin');
});
// Auth Pengguna