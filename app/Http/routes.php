<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', 'WelcomeController@index');

Route::group(['prefix' => 'home', 'namespace' => 'Home'], function()
{
	Route::get('/', 'HomeController@index');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function()
{
	Route::get('/', 'AdminController@index');
});

Route::controllers([
		'auth' => 'Auth\AuthController',
		'password' => 'Auth\PasswordController',
]);
