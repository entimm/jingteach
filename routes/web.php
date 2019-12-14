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

Route::get('/', 'IndexController@index');
Route::get('/data', 'IndexController@data');
Route::post('/submit', 'IndexController@submit');

Route::view('/success', 'success');

Route::view('/login', 'login');
Route::post('/login', 'UserController@login');
Route::get('/quit', 'UserController@quit');
