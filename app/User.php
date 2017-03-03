<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use App\Http\PageTag;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sn', 'name', 'email', 'password', 'grade'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function rel_grade() {
        return $this->hasOne('App\Model\Grade', 'grade', 'grade');
    }

    public static function getUserData($way, $page) {
        if($way == 'userdel') {
            $usersns = json_decode($request->input('usersns'));
            foreach ($usersns as $usersn) {
                $user = User::where('sn', $usersn)->first();
        
                $content = $user->name.'" 从 "'.trans('message.appname').'"注销';
                Record::addRecord($user->sn, '注销', $content);
        
                $user->delete();
            }
        }
        
        /* User lists from page */
        $gp = $page;
        $users = User::query();
        
        $pagetag = new PageTag(6, 3, $users->count(), $gp?$gp:1);
        $users = $users->orderBy('updated_at', 'desc')
                        ->paginate($pagetag->getRow());

        if($way == 'userlist' || $way == 'userdel') {
            return [
                'way' => $way,
                'pagetag' => $pagetag,
                'users' => $users,
            ];
        }

        return [
            'way' => 'none',
        ];
    }

    public static function getUserDataFromRequest(Request $request) {

        //$method = $request->isMethod('post')
        $way = $request->input('way');
        $page = $request->input('page');

        return User::getUserData($way, $page);
    }
}
