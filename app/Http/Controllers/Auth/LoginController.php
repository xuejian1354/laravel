<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Action;
use App\Record;

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

    protected function authenticated(Request $request, $user)
    {
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
            Record::create([
                'sn' => $sn,
                'content' => '"'.$user->name.'" 登录到 "'.trans('message.appname').'"',
                'usersn' => $user->sn,
                'action' => $action->id,
                'optnum' => Controller::getRandHex($user->email.$action->id),
                'data' => null,
            ]);
        }
        elseif($method == 'logout') {
            $action = Action::where('content', '退出')->first();
            $sn = Controller::getRandNum();
            Record::create([
                'sn' => $sn,
                'content' => '"'.$user->name.'" 从 "'.trans('message.appname').'" 退出',
                'usersn' => $user->sn,
                'action' => $action->id,
                'optnum' => Controller::getRandHex($user->email.$action->id),
                'data' => null,
            ]);
        }
    }
}
