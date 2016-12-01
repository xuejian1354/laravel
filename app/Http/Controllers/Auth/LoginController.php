<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Action;
use App\Ctrlrecord;
use App\Globalval;
use App\Record;
use App\Http\Controllers\AdminController;

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
     * Where to redirect users after login.
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

    	return $this->authenticated($request, $this->guard()->user()) ?: redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
    	if ($user->active != true) {
    		$request->session()->flush();
    		$request->session()->regenerate();
    		return redirect('/login')
    				->withErrors([
			            'email' => 'This account is not active, please contact with admin for setting first.',
			        ]);
    	}

    	$this->addLogingRecord('login');
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
	    	$sn = Controller::getRandNum();
	    	Ctrlrecord::create([
	    			'sn' => $sn,
	    			'content' => '"'.$user->name.'" 登录到 "'.Globalval::getVal('title').'"',
	    			'usersn' => $user->sn,
	    			'action' => $action->id,
	    			'optnum' => Controller::getRandHex($user->email.$action->id),
	    			'data' => null,
	    	]);

	    	if(Globalval::getVal('record_support') == true) {
	    		Record::create(['sn' => $sn, 'type' => 'user', 'data' => 'login']);
	    	}

	    	AdminController::syncServerAddr();
    	}
    	elseif($method == 'logout') {
    		$action = Action::where('content', '退出')->first();
    		$sn = Controller::getRandNum();
    		Ctrlrecord::create([
    				'sn' => $sn,
    				'content' => '"'.$user->name.'" 从 "'.Globalval::getVal('title').'" 退出',
    				'usersn' => $user->sn,
    				'action' => $action->id,
    				'optnum' => Controller::getRandHex($user->email.$action->id),
    				'data' => null,
    		]);

    		if(Globalval::getVal('record_support') == true) {
    			Record::create(['sn' => $sn, 'type' => 'user', 'data' => 'logout']);
    		}
    	}
    }
}
