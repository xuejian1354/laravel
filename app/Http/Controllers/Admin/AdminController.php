<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\DBStatic\Consolemenu;

class AdminController extends Controller {

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
		$action = isset($_GET['action'])?$_GET['action']:"#";
		$amenu = "#";
		
		$menus = Consolemenu::all();
		$mmenus = array();
		foreach ($menus as $menu)
		{
			if($action == $menu->action)
			{
				$amenu = $menu;
			}
			array_push($mmenus, $menu->mmenu);
		}
		
		if($amenu == "#")
		{
			$amenu = $menus[0];
		}
		
		$umenus = array_unique($mmenus);
		$nmenus = array();
		foreach($umenus as $umenu)
		{
			foreach ($menus as $menu)
			{
				if ($umenu == $menu->mmenu)
				{
					array_push($nmenus, $menu);
					break;
				}
			}
		}

		return view('admin.admin')
					->withMenus($menus)
					->withNmenus($nmenus)
					->withAmenu($amenu);
	}

}
