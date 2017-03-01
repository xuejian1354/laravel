<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Model\Message;

/**
 * Class CulliveController
 * @package App\Http\Controllers
 */
class CulliveController extends Controller
{
    protected $slideto;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->slideto = 0;
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
    
    public function landplanting(Request $request, $childreq = null)
    {
        if ($childreq) {
            return view('cullive.landplanting.'.$childreq)
                    ->with('slideto', $this->slideto);
        }

        return view('cullive.landplanting')
                ->with('slideto', $this->slideto);
    }
    
    public function devgardening(Request $request, $childreq = null)
    {
        if ($childreq) {
            return view('cullive.devgardening.'.$childreq)
                    ->with('slideto', $this->slideto);
        }
        return view('cullive.devgardening')
                ->with('slideto', $this->slideto);
    }
    
    public function farmbreeding(Request $request, $childreq = null)
    {
        if ($childreq) {
            return view('cullive.farmbreeding.'.$childreq)
                    ->with('slideto', $this->slideto);
        }
        return view('cullive.farmbreeding')
                ->with('slideto', $this->slideto);
    }
    
    public function aquaculture(Request $request, $childreq = null)
    {
        if ($childreq) {
            return view('cullive.aquaculture.'.$childreq)
                    ->with('slideto', $this->slideto);
        }
        return view('cullive.aquaculture')
                ->with('slideto', $this->slideto);
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