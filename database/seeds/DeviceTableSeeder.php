<?php

use Illuminate\Database\Seeder;
use App\Device;
use App\Devtype;
use App\Http\Controllers\Controller;
use App\User;
use App\Area;

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
            $area = ['鱼塘1', '鱼塘2', '鱼塘3'];

        	foreach (Devtype::all() as $devtype) {
        		$ran = Controller::getRandHex();
        		Device::create([
        				'sn' => $ran,
        				'name' => $devtype->name.substr($ran, -4),
        				'type' => $devtype->id,
        				'attr' => $devtype->attr,
                        'area' => Area::where('name', $area[array_rand($area)])->first()->sn,
        				'owner' => $root->sn,
        		]);
        	}
        }
    }
}
