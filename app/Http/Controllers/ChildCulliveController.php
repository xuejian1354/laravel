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
        parent::__construct();
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
        case 'plantservice':
            $this->slideto++;
        case 'plantmanage':
            $this->slideto++;
        case 'plantctrl':
            break;
        }

        return parent::landplanting($request, $childreq);
    }

    public function devgardening(Request $request, $childreq = null)
    {
        switch ($childreq) {
        case 'businessctrl':
            $this->slideto++;
        case 'qualityctrl':
            $this->slideto++;
        case 'productionctrl':
            $this->slideto++;
        case 'seedctrl':
            $this->slideto++;
        case 'greenhousectrl':
            break;
        }

        return parent::devgardening($request, $childreq);
    }

    public function farmbreeding(Request $request, $childreq = null)
    {
        switch ($childreq) {
        case 'dungctrl':
            $this->slideto++;
        case 'milkctrl':
            $this->slideto++;
        case 'eggctrl':
            $this->slideto++;
        case 'feedctrl':
            $this->slideto++;
        case 'barctrl':
            break;
        }

        if ($childreq == 'barctrl') {
            return redirect(config('cullivebefore.mainrouter'));
        }

        return parent::farmbreeding($request, $childreq);
    }

    public function aquaculture(Request $request, $childreq = null)
    {
        switch ($childreq) {
        case 'aquaservice':
            $this->slideto++;
        case 'aquadetect':
            $this->slideto++;
        case 'aquamanage':
            $this->slideto++;
        case 'aquactrl':
            break;
        }

        return parent::aquaculture($request, $childreq);
    }
}