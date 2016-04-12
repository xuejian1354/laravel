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

Route::group(['domain' => 'home.loongsmart.com'], function()
{
        Route::get('/', 'WelcomeController@home');
});

Route::group(['domain' => 'school.loongsmart.com'], function()
{
        Route::get('/', 'WelcomeController@school');
});

Route::get('/', 'WelcomeController@index');

Route::group(['prefix' => 'home', 'namespace' => 'Home'], function()
{
	Route::get('/', 'HomeController@index');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function()
{
	Route::get('/', 'AdminController@index');
	Route::post('/userdel', 'AdminController@userdel');
	Route::post('/useredit', 'AdminController@useredit');
	Route::post('/gwdel', 'AdminController@gwdel');
	Route::post('/gwedit', 'AdminController@gwedit');
	Route::post('/devdel', 'AdminController@devdel');
	Route::post('/devedit', 'AdminController@devedit');
	Route::post('/roomedt', 'AdminController@roomedt');
	Route::post('/roomdel', 'AdminController@roomdel');
});

Route::post('/devicedata', 'DeviceController@datapush');
Route::post('/admin/devoptdel', 'DeviceController@devoptdel');
Route::post('/admin/devoptadd', 'DeviceController@devoptadd');

Route::get('/xls', 'ExcelController@xlsupload');
Route::post('/xls/obj', 'ExcelController@import');
Route::post('/xls/courselist', 'ExcelController@courselist');
Route::post('/xls/roomlist', 'ExcelController@roomlist');

Route::controllers([
		'auth' => 'Auth\AuthController',
		'password' => 'Auth\PasswordController',
]);
