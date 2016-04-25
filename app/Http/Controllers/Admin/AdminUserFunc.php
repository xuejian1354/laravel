<?php namespace App\Http\Controllers\Admin;

use Input, Auth, DB;
use App\User;
use App\Http\Controllers\Controller;

class AdminUserFunc {

	protected $menus;

	public function __construct($menus)
	{
		$this->menus = $menus;
	}

	public function getFuncView()
	{
		if(Auth::user()->grade == 1 || Auth::user()->privilege == 5)
		{
			$user = null;
			$id = Input::get('id');
			if($id != null)
			{
				$user = User::find($id);
			}

			if($user == null)
			{
				$user = Auth::user();
			}

			return AdminController::getViewWithMenus('admin.admin')
						->withUser($user);
		}
		else
		{
			return view('errors.permitts');
		}
	}
}
