<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class DevDataController extends Controller
{
    public function index() {

    	event(new \App\Events\DevDataEvent(Input::get('sn'), Input::get('data')));
    	return view('welcome');
    }
}
