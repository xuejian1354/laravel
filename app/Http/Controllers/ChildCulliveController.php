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
        case 'plantmanage':
        case 'plantservice':
            return view('cullive.landplanting.'.$childreq);
        }

        return view('cullive.landplanting');
    }

    public function devgardening(Request $request, $childreq = null)
    {
        switch ($childreq) {
        case 'greenhousectrl':
        case 'seedctrl':
        case 'productionctrl':
        case 'qualityctrl':
        case 'businessctrl':
            return view('cullive.devgardening.'.$childreq);
        }

        return view('cullive.devgardening');
    }

    public function farmbreeding(Request $request, $childreq = null)
    {
        switch ($childreq) {
        case 'barctrl':
        case 'feedctrl':
        case 'eggctrl':
        case 'milkctrl':
        case 'dungctrl':
            return view('cullive.farmbreeding.'.$childreq);
        }

        return view('cullive.farmbreeding');
    }

    public function aquaculture(Request $request, $childreq = null)
    {
        switch ($childreq) {
        case 'aquactrl':
        case 'aquamanage':
        case 'aquadetect':
        case 'aquaservie':
            return view('cullive.aquaculture.'.$childreq);
        }

        return view('cullive.aquaculture');
    }
}