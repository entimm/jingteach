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

Route::get('/login/{code?}', 'UserController@loginView');
Route::post('/login', 'UserController@login');
Route::get('/quit', 'UserController@quit');

Route::get('export_raw/{start?}/{end?}', 'IndexController@exportRaw');
Route::get('export/{start?}/{end?}', 'IndexController@export');

Route::get('/result', 'IndexController@lastResult');

Route::get('/settings/all', 'SettingsController@show');
Route::get('/settings/update', 'SettingsController@update');
