<?php namespace App\Http\Controllers\Setting;

use DB, Input, Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class SettingController extends Controller {

	protected  $grades = [1, 2, 3, 4];

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function password()
	{
		return $this->getUserView('setting.password')
						->withTitle('password')
						->withGlobalvals(Controller::getGlobalvals());
	}

	public function details()
	{
	    return $this->getUserView('setting.details')
                	    ->withTitle('details')
                	    ->withGlobalvals(Controller::getGlobalvals());
	}

	public function records()
	{
	    return $this->getUserView('setting.records')
                	    ->withTitle('records')
                	    ->withGlobalvals(Controller::getGlobalvals());
	}

	public function resetpass()
	{
		$oldpass = Input::get('old_pass');
		$newpass = Input::get('new_pass');
		$confirmpass = Input::get('confirm_pass');

		if($oldpass == null)
		{
			return redirect('setting/password')->withErrors('No input old password');
		}

		if($newpass == null)
		{
			return redirect('setting/password')->withErrors('No input new password');
		}

		if($newpass != $confirmpass)
		{
			return redirect('setting/password')->withErrors('Input new password with confirm dismatch');
		}

		if(Auth::attempt(['email' => Auth::user()->email, 'password' => $oldpass]) == false)
		{
			return redirect('setting/password')->withErrors('Input old password error');
		}

		if($oldpass == $newpass)
		{
			return redirect('setting/password')->withErrors('The new password are same with old password');
		}

		Auth::user()->password = bcrypt($newpass);
		Auth::user()->save();

		return $this->getUserView('setting/password')
						->withTitle('password')
						->withGlobalvals(Controller::getGlobalvals())
						->withInfo('Reset password success !');
	}
}
