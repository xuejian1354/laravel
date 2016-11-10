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
		$vd = App\Globalval::where('name', 'video_support')->first();
		if($vd) {
			$vd->val = true;
			$vd->save();
			print_r("video support enable\n");
		}
	}
	else if($action == 'disable') {
		$vd = App\Globalval::where('name', 'video_support')->first();
		if($vd) {
			$vd->val = false;
			$vd->save();
			print_r("video support disable\n");
		}
	}
})->describe('Video support enable|disable');