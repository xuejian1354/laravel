<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public static function getRandHex($seed = null, $length = 6) {
        return Controller::getRandNum($seed, $length, $radix = 16);
    }
    
    public static function getRandNum($seed = null, $length = 6, $radix = 10) {
    
        if($seed == null) {
            $seed = rand(1, 1000000);
        }
    
        if($radix == 10) {
            return substr(hexdec(md5($seed)), 2, $length);
        }
        elseif($radix == 16) {
            return strtoupper(substr(md5($seed), 2, $length));
        }
        else {
            throw new \Exception(__CLASS__.'::'.__FUNCTION__.'('.__LINE__
                        .') Error with rand generation');
        }
    }
}
