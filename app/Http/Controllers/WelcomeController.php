<?php namespace App\Http\Controllers;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
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
	
	public function school()
	{
		return redirect('http://loongsmart.com/school"></head>');;
	}
}
