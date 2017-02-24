<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Message;

/**
 * Class CulliveController
 * @package App\Http\Controllers
 */
class CulliveController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        return view('cullive.base');
    }
    
    public function landplanting(Request $request, $req = null)
    {   
        return view('cullive.landplanting');
    }
    
    public function devgardening(Request $request, $req = null)
    {
        return view('cullive.devgardening');
    }
    
    public function farmbreeding(Request $request, $req = null)
    {
        return view('cullive.farmbreeding');
    }
    
    public function aquaculture(Request $request, $req = null)
    {
        return view('cullive.aquaculture');
    }

    public function upinfo(Request $request) {

        $name = $request->get('Name');
        $email = $request->get('Mail');
        $text = $request->get('Message');
        if (trim($name) != '' && trim($email) != '' && trim($text) != '') {
            Message::create([
                'name' => $name,
                'email' => $email,
                'text' => $text
            ]);

            return 'TRUE';
        }

        return 'False';
    }
}