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
use App\Model\DBStatic\Devcmd;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Model\Room\Room;
use App\Model\Course\Course;
use App\Model\DBStatic\Roomtype;
use App\Model\DBStatic\Roomaddr;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use App\Model\DBStatic\Cycle;
use App\Model\DBStatic\Term;
use App\Http\Controllers\ExcelController;
use Illuminate\Database\QueryException;
use App\Model\DBStatic\News;
use App\Model\DBStatic\Idgrade;
use App\Model\DBStatic\Academy;
use App\Model\DBStatic\Classgrade;

class AdminController extends Controller {

	protected $grades = [1, 2, 3, 4];

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$menus = new AMenus();
		
		switch($menus->getAmenu()->action)
		{
		case "courselist":
		case "courseimport":
			$admincourse = new AdminCourse($menus);
			return $admincourse->getCourseView();
			
		case "roomstats":
		case "roomctrl":
		case "roomimport":
			$adminroom = new AdminRoom($menus);
			return $adminroom->getRoomView();

		case "devstats":
		case "devctrl":
			$admindevice = new AdminDevice($menus);
			return $admindevice->getDeviceView();

		case "usermanage":
			$adminusermanage = new AdminUserManage($menus);
			return $adminusermanage->getUserView();

		case "userinfo":
			$adminuserinfo = new AdminUserInfo($menus);
			return $adminuserinfo->getUserView();

		case "userfunc":
		case "useractivity":
		case "usercourse":
		case "userclassgrade":
		case "userreport":
		case "userexam":
		case "userscore":
		case "userdetails":
		case "userrecord":
			$adminuserfunc = new AdminUserFunc($menus);
			return $adminuserfunc->getFuncView();

		case "password":
			if(Auth::user()->grade == 1 || Auth::user()->privilege == 5)
			{
				return AdminController::getViewWithMenus('admin.admin')
						->withUsers(User::query()->OrderBy('email', 'asc')->get());
			}
			else
			{
				return view('errors.permitts');
			}
		}

		if(Auth::user()->grade == 1 || Auth::user()->privilege == 5)
		{
			return AdminController::getViewWithMenus('admin.admin');
		}
		else
		{
			return view('errors.permitts');
		}
	}

	public function userdel()
	{
		$menus = new AMenus();
		$adminusermanage = new AdminUserManage($menus);

		return $adminusermanage->userdel();
	}

	public function useredit()
	{
		$menus = new AMenus();
		$adminusermanage = new AdminUserManage($menus);

		return $adminusermanage->useredit();
	}

	public function gwdel()
	{
		$menus = new AMenus();
		$admindevice = new AdminDevice($menus);

		return $admindevice->gwdel();
	}

	public function gwedit()
	{
		$menus = new AMenus();
		$admindevice = new AdminDevice($menus);

		return $admindevice->gwedit();
	}

	public function devdel()
	{
		$menus = new AMenus();
		$admindevice = new AdminDevice($menus);

		return $admindevice->devdel();
	}

	public function devmvarea()
	{
		$menus = new AMenus();
		$admindevice = new AdminDevice($menus);

		return $admindevice->devmvarea();
	}

	public function devedit()
	{
		$menus = new AMenus();
		$admindevice = new AdminDevice($menus);

		return $admindevice->devedit();
	}
	
	public function roomedt()
	{
		$menus = new AMenus();
		$adminroom = new AdminRoom($menus);

		return $adminroom->roomedt();
	}

	public function roomdel()
	{
		$menus = new AMenus();
		$adminroom = new AdminRoom($menus);

		return $adminroom->roomdel();
	}

	public function roomadd()
	{
		$menus = new AMenus();
		$adminroom = new AdminRoom($menus);

		return $adminroom->roomadd();
	}
	
	public function courseedt()
	{
		$menus = new AMenus();
		$admincourse = new AdminCourse($menus);

		return $admincourse->courseedt();
	}
	
	public function coursedel()
	{
		$menus = new AMenus();
		$admincourse = new AdminCourse($menus);

		return $admincourse->coursedel();
	}

	public function courseadd()
	{
		$menus = new AMenus();
		$admincourse = new AdminCourse($menus);

		return $admincourse->courseadd();
	}

	public function addnews()
	{
		$menus = new AMenus();
		$adminuserinfo = new AdminUserInfo($menus);

		return $adminuserinfo->addnews();
	}

	public function newsdel()
	{
		$menus = new AMenus();
		$adminuserinfo = new AdminUserInfo($menus);

		return $adminuserinfo->newsdel();
	}

	public function newsadel()
	{
		$menus = new AMenus();
		$adminuserfunc = new AdminUserFunc($menus);
	
		return $adminuserfunc->newsadel();
	}

	public function newsedts()
	{
		$menus = new AMenus();
		$adminuserinfo = new AdminUserInfo($menus);

		return $adminuserinfo->newsedts();
	}

	public function academydel()
	{
		$menus = new AMenus();
		$adminuserinfo = new AdminUserInfo($menus);

		return $adminuserinfo->academydel();
	}

	public function addacademy()
	{
		$menus = new AMenus();
		$adminuserinfo = new AdminUserInfo($menus);

		return $adminuserinfo->addacademy();
	}

	public function academyedt()
	{
		$menus = new AMenus();
		$adminuserinfo = new AdminUserInfo($menus);

		return $adminuserinfo->academyedt();
	}

	public function classgradedel()
	{
		$menus = new AMenus();
		$adminuserinfo = new AdminUserInfo($menus);

		return $adminuserinfo->classgradedel();
	}

	public function addclassgrade()
	{
		$menus = new AMenus();
		$adminuserinfo = new AdminUserInfo($menus);

		return $adminuserinfo->addclassgrade();
	}

	public function classgradeedt()
	{
		$menus = new AMenus();
		$adminuserinfo = new AdminUserInfo($menus);

		return $adminuserinfo->classgradeedt();
	}

	public function adddetail()
	{
		$menus = new AMenus();
		$adminuserfunc = new AdminUserFunc($menus);
		
		return $adminuserfunc->adddetail();
	}
	
	public function coursearrange()
	{
	    $menus = new AMenus();
	    $adminuserfunc = new AdminUserFunc($menus);
	    
	    return $adminuserfunc->coursearrange();
	}
	
	public function coursearrangedel()
	{
	    $menus = new AMenus();
	    $adminuserfunc = new AdminUserFunc($menus);
	     
	    return $adminuserfunc->coursearrangedel();
	}

	public function coursechoosetsave()
	{
	    $menus = new AMenus();
	    $adminuserfunc = new AdminUserFunc($menus);
	    
	    return $adminuserfunc->coursechoosetsave();
	}

	public function coursechoosestart()
	{
	    $menus = new AMenus();
	    $adminuserfunc = new AdminUserFunc($menus);
	    
	    return $adminuserfunc->coursechoosestart();
	}

	public function coursechoosestudsave()
	{
	    $menus = new AMenus();
	    $adminuserfunc = new AdminUserFunc($menus);
	     
	    return $adminuserfunc->coursechoosestudsave();
	}

	public function resetpass()
	{
		$email = Input::get('email');
		$newpass = Input::get('new_pass');
		$confirmpass = Input::get('confirm_pass');

		if($newpass == null)
		{
			return redirect('admin?action=password')->withErrors('No input new password');
		}
	
		if($newpass != $confirmpass)
		{
			return redirect('admin?action=password')->withErrors('Input new password with confirm dismatch');
		}
	
		if(Auth::attempt(['email' => $email, 'password' => $newpass]))
		{
			return redirect('admin?action=password')->withErrors('Input different password with old');
		}

		DB::table('users')
				->where('email', $email)
				->update(['password' => bcrypt($newpass)]);

		$amenu = "#";
		$menus = Consolemenu::all();
		$mmenus = array();

		foreach ($menus as $menu)
		{
			if($menu->action == 'password')
			{
				if($amenu == "#")
				{
					$amenu = $menu;
					$amenu['caction'] = $menu->action;
				}
			}
			array_push($mmenus, $menu->mmenu);
		}

		if($amenu == "#")
		{
			$amenu = $menus[0];
			$amenu['caction'] = $menus[0]->action;
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

		return $this->getUserView('admin.admin')
							->withUsers(User::all())
							->withGlobalvals(Controller::getGlobalvals())
							->withMenus($menus)
							->withNmenus($nmenus)
							->withAmenu($amenu)
							->withInfo('Reset password success !');
	}

	public static function getViewWithMenus($view = null, $actions = null, $user = null, $data = [], $mergeData = [])
	{
		$menus = new AMenus($actions);
		if($user != null)
		{
		    switch($user->grade)
		    {
		    case 1:
		        $menus->setCMenuWithAction('usercourse', '课程安排');
		        $menus->setCMenuWithAction('userclassgrade', '教室操作');
		        $menus->setCMenuWithAction('userreport', '作业查询');
		        $menus->setCMenuWithAction('userexam', '考试查询');
		        break;

	        case 2:
	            $menus->setCMenuWithAction('userclassgrade', '教室操作');
	            $menus->setCMenuWithAction('userscore', '成绩发布');
	            break;

            case 3:
                $menus->setCMenuWithAction('userreport', '课程安排');
                $menus->setCMenuWithAction('userexam', '考试查询');
                break;

            case 4:
                $menus->setCMenuWithAction('userreport', 'NULL');
                $menus->setCMenuWithAction('userexam', '考试查询');
                $menus->setCMenuWithAction('userrecord', 'NULL');
                break;
		    }
		}

		return view($view, $data, $mergeData)
					->withGlobalvals(Controller::getGlobalvals())
					->withMenus($menus->getMenus())
					->withNmenus($menus->getNmenus())
					->withAmenu($menus->getAmenu());
	}

	public static function backView($info = 'Error')
	{
		return '<script type="text/javascript">history.back(-1);alert("'.$info.'");</script>';
	}

}
