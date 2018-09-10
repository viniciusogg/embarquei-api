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

//Route::post('usuarios', 'UsuarioController@store');
//Route::group(['prefix' => 'usuarios', 'middleware'=> 'auth:api'], function()
//{
//    Route::get('/', 'UsuarioController@index');
//    Route::get('/{id}', 'UsuarioController@show');
//    Route::delete('/{id}', 'UsuarioController@destroy');
//    Route::put('/{id}', 'UsuarioController@update');
//});

Route::apiResource('motoristas', 'MotoristaController');//->middleware('auth:api');

Route::apiResource('administradores', 'AdministradorController');//->middleware('auth:api');

Route::apiResource('instituicoesEnsino', 'InstituicaoEnsinoController');//->middleware('auth:api');

Route::apiResource('veiculosTransporte', 'VeiculoTransporteController');//->middleware('auth:api);

Route::post('estudantes', 'EstudanteController@store');
Route::group(['prefix' => 'estudantes', 'middleware'=> 'auth:api'], function()
{
    Route::get('/', 'EstudanteController@index');
    Route::get('/{id}', 'EstudanteController@show');
    Route::delete('/{id}', 'EstudanteController@destroy');
    Route::put('/{id}', 'EstudanteController@update');
});


Route::post('authenticate', 'AuthController@login');

Route::post('authenticate/refresh', 'AuthController@refresh'); // ->name('login');

Route::post('logout', 'AuthController@logout');

/*
 *  quando a autenticação falha (access token inválido), automaticamente
 *  o laravel redireciona para a rota /login, que chama o metodo refresh
 *  para renovar o access token
 */
Route::any('login', 'AuthController@refresh')->name('login');


// CRIAR UM MIDDLEWARE QUE FILTRE AS REQUISIÇÕES DE ACORDO COM O ADMIN QUE FEZ,
// E RETORNE APENAS OS DADOS DE INTERESSE DELE