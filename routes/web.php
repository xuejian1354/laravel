<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'AdminController@index');

Route::get('/curinfo', 'AdminController@curInfo');
Route::get('/areactrl', 'AdminController@areaCtrl');
Route::get('/devstats', 'AdminController@devStats');
Route::get('/videoreal', 'AdminController@videoReal');
Route::get('/alarminfo', 'AdminController@alarmInfo');
