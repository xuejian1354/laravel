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
    protected $entrance;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->slideto = 0;
        $this->entrance = config('cullive.entrance');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        return view($this->entrance.'.base');
    }
    
    public function landplanting(Request $request, $childreq = null)
    {
        if ($childreq) {
            return view($this->entrance.'.landplanting.'.$childreq)
                    ->with('slideto', $this->slideto);
        }

        return view($this->entrance.'.landplanting')
                ->with('slideto', $this->slideto);
    }
    
    public function devgardening(Request $request, $childreq = null)
    {
        if ($childreq) {
            return view($this->entrance.'.devgardening.'.$childreq)
                    ->with('slideto', $this->slideto);
        }
        return view($this->entrance.'.devgardening')
                ->with('slideto', $this->slideto);
    }
    
    public function farmbreeding(Request $request, $childreq = null)
    {
        if ($childreq) {
            return view($this->entrance.'.farmbreeding.'.$childreq)
                    ->with('slideto', $this->slideto);
        }
        return view($this->entrance.'.farmbreeding')
                ->with('slideto', $this->slideto);
    }
    
    public function aquaculture(Request $request, $childreq = null)
    {
        if ($childreq) {
            return view($this->entrance.'.aquaculture.'.$childreq)
                    ->with('slideto', $this->slideto);
        }
        return view($this->entrance.'.aquaculture')
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

    public function mbhandler(Request $request) {
        $reqs = explode('/', $request->path());

        if($reqs[1] == 'mbenvdetect' && $reqs[2] == 'autoctrl') {
            return redirect(config('cullivebefore.mainrouter'));
        }

        return view($this->entrance.'.'.$reqs[0]);
    }
}