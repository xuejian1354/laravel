<?php

use Illuminate\Database\Seeder;
use App\Device;
use App\Devtype;
use App\Http\Controllers\Controller;
use App\User;

class DeviceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(count(Device::all()) == 0) {
        	$root = User::where('name', 'root')->firstOrFail();

        	foreach (Devtype::all() as $devtype) {
        		$ran = Controller::getRandHex();
        		Device::create([
        				'sn' => $ran,
        				'name' => $devtype->name.substr($ran, -4),
        				'type' => $devtype->id,
        				'ispublic' => false,
        				'owner' => $root->sn,
        		]);
        	}
        }
    }
}
