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
