<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('redis:publish {channel} {message}', function ($channel, $message) {
	Redis::publish($channel, $message);
})->describe('Publish to a Redis channel');

Artisan::command('video:support {action}', function ($action) {
	if($action == 'enable') {
		$vd = App\Model\Globalval::where('name', 'video_support')->first();
		if($vd) {
			$vd->val = true;
			$vd->save();
			print_r("video support enable\n");
		}
	}
	else if($action == 'disable') {
		$vd = App\Model\Globalval::where('name', 'video_support')->first();
		if($vd) {
			$vd->val = false;
			$vd->save();
			print_r("video support disable\n");
		}
	}
	else {
		print_r("Can't excute action \"".$action."\"\t\tchoice: [enable|disable]\n");
	}
})->describe('Video support enable|disable');

Artisan::command('video:server {action}', function ($action) {
    if($action == 'enable') {
        $vd = App\Model\Globalval::where('name', 'node_rtmptoserver_enable')->first();
        if($vd) {
            $vd->val = true;
            $vd->save();
            print_r("video push to server enable\n");
        }
    }
    else if($action == 'disable') {
        $vd = App\Model\Globalval::where('name', 'node_rtmptoserver_enable')->first();
        if($vd) {
            $vd->val = false;
            $vd->save();
            print_r("video push to server disable\n");
        }
    }
    else {
        print_r("Can't excute action \"".$action."\"\t\tchoice: [enable|disable]\n");
    }
})->describe('Video push to server enable|disable');

Artisan::command('record:support {action}', function ($action) {
	if($action == 'enable') {
		$vd = App\Model\Globalval::where('name', 'record_support')->first();
		if($vd) {
			$vd->val = true;
			$vd->save();
			print_r("record support enable\n");
		}
	}
	else if($action == 'disable') {
		$vd = App\Model\Globalval::where('name', 'record_support')->first();
		if($vd) {
			$vd->val = false;
			$vd->save();
			print_r("video support disable\n");
		}
	}
	else {
		print_r("Can't excute action \"".$action."\"\t\tchoice: [enable|disable]\n");
	}
})->describe('Record support enable|disable');

Artisan::command('matrix {name}', function ($name) {
	if($name == 'server') {
		$vd = App\Model\Globalval::where('name', 'matrix')->first();
		if($vd) {
			$vd->val = $name;
			$vd->save();
			print_r("matrix is server\n");

			$ti = App\Model\Globalval::where('name', 'title')->first();
			if ($ti) {
			    $ti->val = 'Cullive';
			    $ti->save();
			}
		}
	}
	else if($name == 'raspberrypi') {
		$vd = App\Model\Globalval::where('name', 'matrix')->first();
		if($vd) {
			$vd->val = $name;
			$vd->save();
			print_r("matrix is raspberrypi\n");

			$ti = App\Model\Globalval::where('name', 'title')->first();
			if ($ti) {
			    $ti->val = 'RaspberryPi3';
			    $ti->save();
			}
		}
	}
	else {
		print_r("Can't set matrix \"".$name."\"\t\tchoice: [server|raspberrypi]\n");
	}
})->describe('Matrix setting server|raspberrypi');

Artisan::command('domain:permit {action}', function ($action) {
    if($action == 'enable') {
        $vd = App\Model\Globalval::where('name', 'domain_permit')->first();
        if($vd) {
            $vd->val = true;
            $vd->save();
            print_r("domain permission enable\n");
        }
    }
    else if($action == 'disable') {
        $vd = App\Model\Globalval::where('name', 'domain_permit')->first();
        if($vd) {
            $vd->val = false;
            $vd->save();
            print_r("domain permission disable\n");
        }
    }
    else {
        print_r("Can't excute action \"".$action."\"\t\tchoice: [enable|disable]\n");
    }
})->describe('Domain permission enable|disable');