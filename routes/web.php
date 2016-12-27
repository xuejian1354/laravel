<?php

use App\Globalval;
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

$routecall = function() {

	// Web URL
	Route::group(['middleware' => ['web', 'auth']], function () {

		$url_requests = [
				'/' => 'AdminController@index',
				'/home' => 'AdminController@index',
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

	Auth::routes();
};

$routeredict = function () {
    Route::any('{ret?}', function ($ret = null) {
        //$host = Route::getCurrentRoute()->getAction()['domain'];
        $host = Request::server('HTTP_HOST');
        return redirect('http://www.'.$host.'/'.$ret);
    });
};

// Console URL
Route::get('/devdata', 'DevDataController@index');

if (Globalval::getVal('matrix') == 'server') {
	Route::group(['domain' => 'longyuanspace.com'], $routeredict);
	Route::group(['domain' => 'loongsky4.net'], $routeredict);

	Route::group(['domain' => 'www.longyuanspace.com'], $routecall);
	Route::group(['domain' => 'www.loongsky4.net'], $routecall);
}
else {
	$routecall();
}

Route::any('{ret?}', function ($ret = null) {

	//dd($ret);
	return 'NULL';
});
