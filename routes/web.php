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

Route::get('/', "SearchController@index");

Route::get('/spotify', "Auth\LoginController@login");

Route::get('/login', "Auth\LoginController@showLoginPage");
Route::get('/login/validate', "Auth\LoginController@attemptLogin");

Route::post('/search', "SearchController@search");

Route::get('/album/{id}', "SearchController@getAlbum");
Route::get('/track/{id}', "SearchController@getTrack");
Route::get('/artist/{id}', "SearchController@getArtist");
