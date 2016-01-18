<?php namespace App\Http\Controllers\Admin;

use Input, Auth;
use App\User;
use App\Model\DBStatic\Grade;
use App\Http\Controllers\Controller;
use App\Model\DBStatic\Consolemenu;
use App\Model\DBStatic\Globalval;
use Illuminate\Support\Facades\Redirect;

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
		//$action = isset($_GET['action'])?$_GET['action']:"#";
		$action = Input::get('action');
		$amenu = "#";
		$grades = array();
		$args = array();

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

		if($amenu->action == "userinfo")
		{
			$users = User::all();
			$grades = Grade::all();
			foreach($grades as $grade)
			{
				$grade['count'] = 0;
			}

			foreach ($users as $user)
			{
				foreach($grades as $grade)
				{
					if($user->grade == $grade->grade)
					{
						$grade['count'] += 1;
						$user['gradename'] = $grade->val;
						$user['index'] = $grade['count'];
					}
				}
			}
			$args = $users;
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

		if(Auth::user()->grade == 1)
		{
			return view('admin.admin')
						->withGlobalvals(Controller::getGlobalvals())
						->withMenus($menus)
						->withNmenus($nmenus)
						->withAmenu($amenu)
						->withGrades($grades)
						->withArgs($args);
		}
		else
		{
			return view('errors.permitts');
		}
	}

	public function userdel()
	{
		User::find(Input::get('id'))->delete();
		return redirect("admin?action=userinfo&tabpos=".Input::get('tabpos'));
	}
}
