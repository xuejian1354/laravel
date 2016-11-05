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

//Route::group(['domain' => 'classyun.com'], function () {

	// Web URL
	Route::group(['middleware' => ['web', 'auth']], function () {

		$url_requests = [
				'/' => 'AdminController@index',
				'/curinfo/{curopt?}' => 'AdminController@curInfo',
				'/areactrl/{areasn?}/{areaopt?}' => 'AdminController@areaCtrl',
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
//});


/*Route::group(['domain' => '{account}.classyun.com'], function () {

	Route::any('{ret?}', function ($account, $ret = null) {

		$dommain = Route::getCurrentRoute()->getAction()['domain'];
		return redirect('http://'.explode('.', $dommain, 2)[1].'/'.$ret);
	});
});*/


/*Route::any('{ret?}', function ($ret = null) {

	//dd($ret);
	return redirect('http://classyun.com/'.$ret);
});*/
