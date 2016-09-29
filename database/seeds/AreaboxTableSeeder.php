<?php

use Illuminate\Database\Seeder;
use App\Areabox;

class AreaboxTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areaboxes')->delete();
        Areabox::create([
        		'id' => 1, 
        		'area_type' => '大棚', 
        		'title' => '空气指数', 
        		'column' => 4, 
        		'icon_class' => 'fa-cloud', 
        		'color_class' => 'bg-aqua',
        ]);

        Areabox::create([
        		'id' => 2,
        		'area_type' => '大棚',
        		'title' => '土壤指数',
        		'column' => 4,
        		'icon_class' => 'fa-eraser',
        		'color_class' => 'bg-red',
        ]);

        Areabox::create([
        		'id' => 3,
        		'area_type' => '大棚',
        		'title' => '气象站',
        		'column' => 4,
        		'icon_class' => 'fa-spoon',
        		'color_class' => 'bg-green',
        ]);

        Areabox::create([
        		'id' => 4,
        		'area_type' => '大棚',
        		'title' => '设备',
        		'column' => 4,
        		'icon_class' => 'fa-support',
        		'color_class' => 'bg-yellow',
        ]);

        Areabox::create([
        		'id' => 5,
        		'area_type' => '养猪场',
        		'title' => '温湿度',
        		'column' => 3,
        		'icon_class' => 'fa-tint',
        		'color_class' => 'bg-green',
        ]);

        Areabox::create([
        		'id' => 6,
        		'area_type' => '养猪场',
        		'title' => '光照',
        		'column' => 3,
        		'icon_class' => 'fa-sun-o',
        		'color_class' => 'bg-aqua',
        ]);

        Areabox::create([
        		'id' => 7,
        		'area_type' => '养猪场',
        		'title' => '空气质量',
        		'column' => 3,
        		'icon_class' => 'fa-cloud',
        		'color_class' => 'bg-red',
        ]);
    }
}
