<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

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
    public function index()
    {
        return view('cullive.dashboard')
                ->with('curreq', $this->curreq)
                ->with('dashconfig', $this->dashconfig);
    }

    public function contentreq(Request $request, $childreq = null)
    {
        $this->curreq = $childreq;
        return view('cullive.layouts.content')
                ->with('curreq', $this->curreq)
                ->with('dashconfig', $this->dashconfig);
    }
}