<?php namespace App\Http\Controllers;

class WelcomeController extends Controller {

	public function __construct()
	{
		$this->middleware('guest');
	}

	public function index()
	{
		$globalvals = Controller::getGlobalvals();
		if($globalvals['title'] == 'SmartHome')
		{
			return view('welcome.home')->withGlobalvals(Controller::getGlobalvals());
		}
		elseif ($globalvals['title'] == 'SmartLab')
		{
			return view('welcome.school')->withGlobalvals(Controller::getGlobalvals());
		}
		else {
			return 'Hello world';
		}
	}
	
	public function home()
	{
		return redirect('http://loongsmart.com/home"></head>');
	}
}
