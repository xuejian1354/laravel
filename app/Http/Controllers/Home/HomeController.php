<?php namespace App\Http\Controllers\Home;

use DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class HomeController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('home.home')->withGlobalvals(Controller::getGlobalvals());
	}

}
