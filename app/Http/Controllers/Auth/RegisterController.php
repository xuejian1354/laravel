<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Action;
use App\Globalval;
use App\Ctrlrecord;
use App\Record;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
        	'sn' => Controller::getRandNum($data['email']),
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function register(Request $request)
    {
    	$this->validator($request->all())->validate();

    	$this->guard()->login($this->create($request->all()));

    	$this->addLogingRecord('register');

    	if ($this->guard()->user()->active != true) {
    		$request->session()->flush();
    		$request->session()->regenerate();
    		return redirect('/register')
    		->withErrors([
    				'email' => 'This account is not active, please contact with admin for setting first.',
    		]);
    	}

    	return redirect($this->redirectPath());
    }

    public function addLogingRecord($method) {
    
    	$user = Auth::user();
    
    	if($method == 'register') {
    		$action = Action::where('content', '注册')->first();
    		$sn = Controller::getRandNum();
    		Ctrlrecord::create([
    				'sn' => $sn,
    				'content' => '注册 "'.$user->name.'" 到 "'.Globalval::getVal('title').'"',
    				'usersn' => $user->sn,
    				'action' => $action->id,
    				'optnum' => Controller::getRandHex($user->email.$action->id),
    				'data' => null,
    		]);

    		if(Globalval::getVal('record_support') == true) {
    			Record::create(['sn' => $sn, 'type' => 'user', 'data' => 'register']);
    		}
    	}
    }
}
