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

Route::get('/', 'WelcomeController@index');

Route::group(['prefix' => 'home', 'namespace' => 'Home'], function()
{
	Route::get('/', 'HomeController@index');
	Route::get('/news', 'HomeController@index');
	Route::get('/tactive', 'HomeController@tactive');
	Route::get('/sactive', 'HomeController@sactive');
});

Route::group(['prefix' => 'academy', 'namespace' => 'Academy'], function()
{
	Route::get('/', 'AcademyController@index');
	Route::get('/info', 'AcademyController@index');
	Route::get('/team', 'AcademyController@index');
});

Route::group(['prefix' => 'classgrade', 'namespace' => 'Classgrade'], function()
{
	Route::get('/', 'ClassgradeController@index');
	Route::get('/info', 'ClassgradeController@index');
	Route::get('/details', 'ClassgradeController@index');
});

Route::group(['prefix' => 'report', 'namespace' => 'Report'], function()
{
	Route::get('/', 'ReportController@index');
	Route::get('/check', 'ReportController@index');
	Route::get('/work', 'ReportController@index');
});

Route::group(['prefix' => 'service', 'namespace' => 'Service'], function()
{
	Route::get('/', 'ServiceController@index');
	Route::get('/email', 'ServiceController@index');
	Route::get('/file', 'ServiceController@index');
	Route::get('/note', 'ServiceController@index');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function()
{
	Route::get('/', 'AdminController@index');
	Route::post('/userdel', 'AdminController@userdel');
	Route::post('/useredit', 'AdminController@useredit');
	Route::post('/gwdel', 'AdminController@gwdel');
	Route::post('/gwedit', 'AdminController@gwedit');
	Route::post('/devdel', 'AdminController@devdel');
	Route::post('/devmvarea', 'AdminController@devmvarea');
	Route::post('/devedit', 'AdminController@devedit');
	Route::post('/roomedt', 'AdminController@roomedt');
	Route::post('/roomdel', 'AdminController@roomdel');
	Route::post('/roomadd', 'AdminController@roomadd');
	Route::post('/courseedt', 'AdminController@courseedt');
	Route::post('/coursedel', 'AdminController@coursedel');
	Route::post('/courseadd', 'AdminController@courseadd');
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
