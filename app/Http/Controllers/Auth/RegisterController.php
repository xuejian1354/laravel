<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use App\User;
use App\Model\Action;
use App\Model\Globalval;
use App\Model\Record;
use App\Model\Ctrlrecord;

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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
            'sn' => Controller::getRandHex($data['email']),
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'grade' => 3,
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        $this->addRegisterRecord('register');

        return $this->registered($request, $user)
        ?: redirect($this->redirectPath());
    }

    public function addRegisterRecord($method) {

        $user = Auth::user();

        if($method == 'register') {
            $action = Action::where('content', '注册')->first();
            $sn = Controller::getRandNum();
            Ctrlrecord::create([
                'sn' => $sn,
                'content' => '注册 "'.$user->name.'" 到 "'.trans('message.appname').'"',
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
