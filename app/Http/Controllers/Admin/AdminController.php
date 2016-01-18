<?php namespace App\Http\Controllers\Admin;

use Input, Auth;
use App\User;
use App\Model\DBStatic\Grade;
use App\Http\Controllers\Controller;
use App\Model\DBStatic\Consolemenu;
use App\Model\DBStatic\Globalval;
use Illuminate\Support\Facades\Redirect;
use App\Model\DBStatic\Privilege;

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

	public function getGradeFromVal($val)
	{
		$grades = Grade::all();
		foreach($grades as $grade)
		{
			if ($grade->val == $val)
			{
				return $grade->grade;
			}
		}

		return 4;
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		//$action = isset($_GET['action'])?$_GET['action']:"#";
		$actions = explode('/', Input::get('action'));

		$amenu = "#";
		$grades = array();
		$privileges = array();
		$args = array();

		$menus = Consolemenu::all();
		$mmenus = array();
		foreach ($menus as $menu)
		{
			if($actions[0] == $menu->action)
			{
				$amenu = $menu;
				$amenu['caction'] = $menu->action;
			}
			array_push($mmenus, $menu->mmenu);
		}

		if($amenu == "#")
		{
			$amenu = $menus[0];
			$amenu['caction'] = $menus[0]->action;
		}

		if($amenu->action == "userinfo")
		{
			if(isset($actions[1]))
			{
				$amenu['caction'] = $actions[1];
			}

			$users = User::all();
			$grades = Grade::all();
			$privileges = Privilege::all();
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

				if($amenu['caction'] == 'edit' && isset($_GET['id']) && $user->id != Input::get('id'))
				{}
				else
				{
					array_push($args, $user);
				}
			}

			if($amenu['caction'] == 'edit' && Auth::user()->privilege < 5)
			{
				return view('errors.permitts');
			}
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

		if(Auth::user()->grade == 1 || Auth::user()->privilege == 5)
		{
			return view('admin.admin')
						->withGlobalvals(Controller::getGlobalvals())
						->withMenus($menus)
						->withNmenus($nmenus)
						->withAmenu($amenu)
						->withGrades($grades)
						->withPrivileges($privileges)
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

	public function useredit()
	{
		$user = User::find(Input::get('id'));
		$user->name = Input::get('name');
		$user->grade = $this->getGradeFromVal(Input::get('grade'));
		$user->privilege = intval(substr(Input::get('privilege'), 0, 1), 10);
		$user->save();

		return redirect("admin?action=userinfo&tabpos=".($user->grade-1));
	}
}
