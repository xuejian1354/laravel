<?php namespace App\Http\Controllers\Admin;

use Input,Auth,DB;
use Carbon\Carbon;
use App\User;
use App\Model\Hardware\Gateway;
use App\Model\Hardware\Device;
use App\Model\DBStatic\Grade;
use App\Model\DBStatic\Consolemenu;
use App\Model\DBStatic\Globalval;
use App\Model\DBStatic\Privilege;
use App\Model\DBStatic\Devtype;
use App\Http\Controllers\Controller;
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

		if(isset($actions[1]))
		{
			$amenu['caction'] = $actions[1];
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

		if($amenu->action == "devstats" || $amenu->action == "devctrl")
		{
			$gateways = Gateway::all();
			$devices = Device::all();
			$gwargs = array();
			$devargs = array();

			foreach ($gateways as $gateway)
			{
				if($amenu['caction'] == 'gwedit' && isset($_GET['id']) && $gateway->id != Input::get('id'))
				{}
				else
				{
					array_push($gwargs, $gateway);
				}
			}

			foreach ($devices as $device)
			{
				$devtypes = Devtype::all();
				foreach($devtypes as $devtype)
				{
					if ($device->dev_type == $devtype->devtype)
					{
						$device['devtypename'] = $devtype->val;
					}
				}

				if($amenu['caction'] == 'devedit' && isset($_GET['id']) && $device->id != Input::get('id'))
				{}
				else
				{
					array_push($devargs, $device);
				}
			}

			if(Auth::user()->grade == 1 || Auth::user()->privilege == 5)
			{
				return view('admin.admin')
					->withGlobalvals(Controller::getGlobalvals())
					->withMenus($menus)
					->withNmenus($nmenus)
					->withAmenu($amenu)
					->withUsers(User::all())
					->withGateways($gwargs)
					->withDevices($devargs);
			}
			else
			{
				return view('errors.permitts');
			}
		}
		else if($amenu->action == "usermanage" || $amenu->action == "userinfo")
		{
			$args = array();
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

		if(Auth::user()->grade == 1 || Auth::user()->privilege == 5)
		{
			return view('admin.admin')
				->withGlobalvals(Controller::getGlobalvals())
				->withMenus($menus)
				->withNmenus($nmenus)
				->withAmenu($amenu);
		}
		else
		{
			return view('errors.permitts');
		}
	}

	public function userdel()
	{
		User::find(Input::get('id'))->delete();
		return redirect("admin?action=usermanage&tabpos=".Input::get('tabpos'));
	}

	public function useredit()
	{
		$user = User::find(Input::get('id'));

		DB::table('gateways')
			->where('owner', $user->name)
			->update([
					'owner' => Input::get('name'),
					'updated_at' => new Carbon
			]);

		DB::table('devices')
			->where('owner', $user->name)
			->update([
					'owner' => Input::get('name'),
					'updated_at' => new Carbon
			]);

		$user->name = Input::get('name');
		$user->grade = $this->getGradeFromVal(Input::get('grade'));
		$user->privilege = intval(substr(Input::get('privilege'), 0, 1), 10);
		$user->save();

		return redirect("admin?action=usermanage&tabpos=".($user->grade-1));
	}

	public function gwdel()
	{
		Gateway::find(Input::get('id'))->delete();
		return redirect("admin?action=devstats&tabpos=".Input::get('tabpos'));
	}

	public function gwedit()
	{
		$gateway = Gateway::find(Input::get('id'));
		$gateway->name = Input::get('name');
		$gateway->area = Input::get('area');
		$gateway->ispublic = Input::get('ispublic');
		$gateway->owner = Input::get('owner');
		$gateway->save();

		return redirect("admin?action=devstats&tabpos=0");
	}

	public function devdel()
	{
		Device::find(Input::get('id'))->delete();
		return redirect("admin?action=devstats&tabpos=".Input::get('tabpos'));
	}

	public function devedit()
	{
		$device = Device::find(Input::get('id'));
		$device->name = Input::get('name');
		$device->area = Input::get('area');
		$device->ispublic = Input::get('ispublic');
		$device->owner = Input::get('owner');
		$device->save();

		return redirect("admin?action=devstats&tabpos=1");
	}
}
