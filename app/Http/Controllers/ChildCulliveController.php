<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

/**
 * Class CulliveController
 * @package App\Http\Controllers
 */
class ChildCulliveController extends CulliveController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function landplanting(Request $request, $childreq = null)
    {
        switch ($childreq) {
        case 'plantctrl':
            dd($request);
            break;

        case 'plantmanage':
            dd($request);
            break;

        case 'plantservice':
            dd($request);
            break;
        }

        return view('cullive.landplanting');
    }
    
    public function devgardening(Request $request, $childreq = null)
    {
        switch ($childreq) {
        case 'greenhousectrl':
            dd($request);
            break;

        case 'seedctrl':
            dd($request);
            break;

        case 'productionctrl':
            dd($request);
            break;

        case 'qualityctrl':
            dd($request);
            break;

        case 'businessctrl':
            dd($request);
            break;
        }

        return view('cullive.devgardening');
    }
    
    public function farmbreeding(Request $request, $childreq = null)
    {
        switch ($childreq) {
        case 'barctrl':
            dd($request);
            break;

        case 'feedctrl':
            dd($request);
            break;

        case 'eggctrl':
            dd($request);
            break;

        case 'milkctrl':
            dd($request);
            break;

        case 'dungctrl':
            dd($request);
            break;
        }

        return view('cullive.farmbreeding');
    }
    
    public function aquaculture(Request $request, $childreq = null)
    {
        switch ($childreq) {
        case 'aquactrl':
            dd($request);
            break;

        case 'aquamanage':
            dd($request);
            break;

        case 'aquadetect':
            dd($request);
            break;

        case 'aquaservie':
            dd($request);
            break;
        }

        return view('cullive.aquaculture');
    }
}