<?php

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

Route::middleware('auth:api')->resource('usuarios', 'UserController');

Route::post('authenticate', 'AuthController@login');

Route::post('authenticate/refresh', 'AuthController@refresh'); // ->name('login');

Route::post('logout', 'AuthController@logout');

Route::any('login', 'AuthController@refresh')->name('login');
