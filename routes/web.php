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

	// Web URL
	Route::group(['middleware' => ['web', 'auth']], function () {

		$url_requests = [
				'/' => 'AdminController@index',
				'/curinfo/{curopt?}' => 'AdminController@curInfo',
				'/areactrl/{areasn?}' => 'AdminController@areaCtrl',
				'/devstats/{devopt?}' => 'AdminController@devStats',
				'/videoreal/{camopt?}' => 'AdminController@videoReal',
				'/alarminfo' => 'AdminController@alarmInfo',
		];

		foreach ($url_requests as $key => $val) {
			Route::match(['get', 'post'], $key, $val);
		}
	});

	// Post Request
	Route::group(['middleware' => ['api', 'auth']], function () {
		Route::post('/devsetting', 'DeviceController@devSetting');
		Route::post('/devctrl/{devsn}', 'DeviceController@devCtrl');
	});

	// Console URL
	Route::get('/devdata', 'DevDataController@index');

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