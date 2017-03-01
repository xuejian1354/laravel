<?php

use App\Model\Globalval;
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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/upinfo', 'CulliveController@upinfo');

Route::get('/landplanting', 'CulliveController@landplanting');
Route::get('/devgardening', 'CulliveController@devgardening');
Route::get('/farmbreeding', 'CulliveController@farmbreeding');
Route::get('/aquaculture', 'CulliveController@aquaculture');

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/dashboard', [ 'as' => 'web.dashboard', 'uses' => 'HomeController@index']);
    Route::get('/home', function () {
        return redirect()->route('web.dashboard');
    });

    Route::post('/dashboard/{childreq}', 'HomeController@contentreq');

    Route::get('/landplanting/{childreq}', 'ChildCulliveController@landplanting');
    Route::get('/devgardening/{childreq}', 'ChildCulliveController@devgardening');
    Route::get('/farmbreeding/{childreq}', 'ChildCulliveController@farmbreeding');
    Route::get('/aquaculture/{childreq}', 'ChildCulliveController@aquaculture');
});

Auth::routes();


/*
 * Routes come from cullive before
 */
$routecall = function() {

    // Web URL
    Route::group(['middleware' => ['web', 'auth']], function () {

        $url_requests = [
            config('cullivebefore.mainrouter') => 'CulliveBefore\AdminController@index',
            config('cullivebefore.mainrouter').'/curinfo/{curopt?}' => 'CulliveBefore\AdminController@curInfo',
            config('cullivebefore.mainrouter').'/areactrl/{areasn?}/{areaopt?}' => 'CulliveBefore\AdminController@areaCtrl',
            config('cullivebefore.mainrouter').'/devstats/{devopt?}' => 'CulliveBefore\AdminController@devStats',
            config('cullivebefore.mainrouter').'/videoreal/{camopt?}' => 'CulliveBefore\AdminController@videoReal',
            config('cullivebefore.mainrouter').'/alarminfo' => 'CulliveBefore\AdminController@alarmInfo',
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
};

// Console URL
Route::get('/devdata', 'DevDataController@index');

if (Globalval::getVal('matrix') == 'server' && Globalval::getVal('domain_permit')) {
    //Enable is lower performance
    Route::group(['domain' => 'cullive.com'], $routeredict);
    Route::group(['domain' => 'www.cullive.com'], $routecall);
}
else {
    $routecall();
}

Route::any('{ret?}', function ($ret = null) {

    //dd($ret);
    return 'NULL';
});

