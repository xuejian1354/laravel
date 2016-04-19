<?php namespace App\Http\Controllers;

class WelcomeController extends Controller {

	public function __construct()
	{
		$this->middleware('guest');
	}

	public function index()
	{
		return view('welcome.home')->withGlobalvals(Controller::getGlobalvals());
	}
	
	public function home()
	{
		return redirect('http://loongsmart.com/home"></head>');
	}
}
