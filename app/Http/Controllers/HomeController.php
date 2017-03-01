<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    protected $curreq;
    protected $dashconfig;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->curreq = 'usermanage';
        $this->dashconfig = config('ltemsg.dashboard');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $mixdata = User::getUserData('userlist', 1);
        $mixdata['request'] = $request;

        return $this->getViewWithCommon('cullive.dashboard', $mixdata);
    }

    public function contentreq(Request $request, $childreq = null)
    {
        $this->curreq = $childreq;
        $mixdata = [];

        //dd($childreq);
        switch ($this->curreq) {
        case 'usermanage':
            $mixdata['request'] = $request;
            $mixdata = array_merge($mixdata, User::getUserData('userlist', 1));
            break;
        }

        return $this->getViewWithCommon('cullive.layouts.content', $mixdata);
    }

    public function getViewWithCommon($view = null, $mixdata = [], $data = [], $mergeData = []) {
        return view($view, $data, $mergeData)
                ->with($mixdata)
                ->with('user', Auth::user())
                ->with('curreq', $this->curreq)
                ->with('dashconfig', $this->dashconfig);
    }
}