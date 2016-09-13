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

Route::group(['domain' => 'loongsky3.net'], function () {

	Route::group(['middleware' => ['web', 'auth']], function () {

		Route::get('/', 'AdminController@index');

		Route::get('/curinfo', 'AdminController@curInfo');
		Route::get('/areactrl/{areaid?}', 'AdminController@areaCtrl');
		Route::get('/devstats', 'AdminController@devStats');
		Route::get('/videoreal', 'AdminController@videoReal');
		Route::get('/alarminfo', 'AdminController@alarmInfo');
	});

	Route::group(['middleware' => ['api', 'auth']], function () {
		Route::post('/devctrl/{devsn}', 'DeviceController@devCtrl');
	});

	Auth::routes();
});


/*Route::group(['domain' => '{account}.loongsky3.net'], function () {

	Route::any('{ret?}', function ($account, $ret = null) {

		$dommain = Route::getCurrentRoute()->getAction()['domain'];
		return redirect('http://'.explode('.', $dommain, 2)[1].'/'.$ret);
	});
});*/


Route::any('{ret?}', function ($ret = null) {

	//dd($ret);
	return redirect('http://loongsky3.net/'.$ret);
});