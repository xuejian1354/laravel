<?php namespace App\Http\Controllers\Admin;

use Input, Auth, DB;
use Carbon\Carbon;
use App\User;
use App\Model\DBStatic\Grade;
use App\Model\DBStatic\Privilege;
use App\Model\Room\Room;
use App\Http\Controllers\Controller;

class AdminUserManage {

	protected $menus;

	protected $grades;
	protected $privileges;
	protected $args;

	public function __construct($menus)
	{
		$this->menus = $menus;

		$this->args = array();
		$users = User::all();
		$this->grades = Grade::all();
		$this->privileges = Privilege::all();
		foreach($this->grades as $grade)
		{
			$grade['count'] = 0;
		}

		foreach ($users as $user)
		{
			foreach($this->grades as $grade)
			{
				if($user->grade == $grade->grade)
				{
					$grade['count'] += 1;
					$user['gradename'] = $grade->val;
					$user['index'] = $grade['count'];
				}
			}

			if($menus->getAmenu()['caction'] == 'edit' && isset($_GET['id']) && $user->id != Input::get('id'))
			{}
			else
			{
				array_push($this->args, $user);
			}
		}
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

	public function getUserView()
	{
		if($this->menus->getAmenu()['caction'] == 'edit' && Auth::user()->privilege < 5)
		{
			return view('errors.permitts');
		}

		if(Auth::user()->grade == 1 || Auth::user()->privilege == 5)
		{
			return AdminController::getViewWithMenus('admin.admin')
						->withGrades($this->grades)
						->withPrivileges($this->privileges)
						->withAreas(Room::all())
						->withArgs($this->args);
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
	
		$area = Input::get('area');
		if ($area != null && $area != 'null')
		{
			$user->area = $area;
		}
		$user->save();
	
		return redirect("admin?action=usermanage&tabpos=".($user->grade-1));
	}
}
