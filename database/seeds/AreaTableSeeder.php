<?php

use Illuminate\Database\Seeder;
use App\Area;
use App\Http\Controllers\Controller;

class AreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Area::query()->count() == 0) {
	        Area::create(['sn' => Controller::getRandNum(),
	        		'name' => '鱼塘1', 'type' => '鱼塘', 'addr' => '',
	        		'status' => '正使用', 'user' => 'root', 'owner' => 'root',
	        		'remarks' => '高淳鱼塘项目']);
	
	        Area::create(['sn' => Controller::getRandNum(),
	        		'name' => '鱼塘2', 'type' => '鱼塘', 'addr' => '', 'status' => '正使用',
	        		'user' => 'root', 'owner' => 'root', 'remarks' => null]);
	
	        Area::create(['sn' => Controller::getRandNum(),
	        		'name' => '鱼塘3', 'type' => '鱼塘', 'addr' => '', 'status' => '正使用',
	        		'user' => 'root', 'owner' => 'root', 'remarks' => null]);
        }
    }
}
