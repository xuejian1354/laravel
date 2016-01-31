<?php namespace App\Http\Controllers\Home;

use DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		DB::table('globalvals')
			->where('name', 'title')
			->update([
					'fieldval' => 'SmartHome',
					'updated_at' => new Carbon
			]);
		return view('home.home')->withGlobalvals(Controller::getGlobalvals());
	}

}
