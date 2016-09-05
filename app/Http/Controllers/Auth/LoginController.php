<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Action;
use App\Record;
use App\Globalval;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    protected function sendLoginResponse(Request $request)
    {
    	$request->session()->regenerate();
    	$this->clearLoginAttempts($request);

    	$this->addLogingRecord('login');

    	return $this->authenticated($request, $this->guard()->user()) ?: redirect()->intended($this->redirectPath());
    }

    public function logout(Request $request)
    {
    	$this->addLogingRecord('logout');

    	$this->guard()->logout();
    	$request->session()->flush();
    	$request->session()->regenerate();
    	return redirect('/');
    }

    public function addLogingRecord($method) {

    	$user = Auth::user();

    	if($method == 'login') {
	    	$action = Action::where('content', '登录')->first();
	    	Record::create([
	    			'sn' => Controller::getRandNum(),
	    			'content' => '"'.$user->name.'" 登录到 "'.Globalval::getVal('title').'"',
	    			'usersn' => $user->sn,
	    			'action' => $action->id,
	    			'optnum' => Controller::getRandHex($user->email.$action->id),
	    			'data' => null,
	    	]);
    	}
    	elseif($method == 'logout') {
    		$action = Action::where('content', '退出')->first();
    		Record::create([
    				'sn' => Controller::getRandNum(),
    				'content' => '"'.$user->name.'" 从 "'.Globalval::getVal('title').'" 退出',
    				'usersn' => $user->sn,
    				'action' => $action->id,
    				'optnum' => Controller::getRandHex($user->email.$action->id),
    				'data' => null,
    		]);
    	}
    }
}
