<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

Route::group(['prefix' => '/v1'], function() {

    Route::post('obras/{Obra}/like', 'ObraController@like');
    Route::post('obras/{Obra}/dislike', 'ObraController@dislike');
    Route::post('obras/{Obra}/capitulos/{Capitulo}/like', 'CapituloController@like');
    Route::post('obras/{Obra}/capitulos/{Capitulo}/dislike', 'CapituloController@dislike');
    Route::resource('obras', 'ObraController');
    Route::resource('obras.capitulos', 'CapituloController');
    Route::resource('obras.comentarios', 'ComentarioController');
    Route::resource('obras.capitulos.feedbacks', 'FeedbackController');
    Route::resource('categorias', 'CategoriaController');
    Route::post('register', 'Auth\RegisterController@register')->middleware('guest');
    Route::post('login', 'Auth\LoginController@login')->middleware('guest');
    Route::post('logout', 'Auth\LoginController@logout')->middleware('auth:api');
});
