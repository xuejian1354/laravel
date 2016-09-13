<?php

use Illuminate\Database\Seeder;
use App\Area;
use App\Areaboxcontent;

class AreaboxcontentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areaboxcontents')->delete();

        foreach (Area::all() as $area) {
        	if( $area->type == '大棚' ) {
        		Areaboxcontent::create(['box_id' => 1, 'area_sn' => $area->sn, 'key' => '温湿度', 'val' => '23℃/68%']);
        		Areaboxcontent::create(['box_id' => 1, 'area_sn' => $area->sn, 'key' => '光照', 'val' => '1450 Lux']);
        		Areaboxcontent::create(['box_id' => 1, 'area_sn' => $area->sn, 'key' => 'CO2浓度', 'val' => '0.03%']);
        		
        		Areaboxcontent::create(['box_id' => 2, 'area_sn' => $area->sn, 'key' => '温度', 'val' => '28℃']);
        		Areaboxcontent::create(['box_id' => 2, 'area_sn' => $area->sn, 'key' => '水分', 'val' => '4.2']);
        		Areaboxcontent::create(['box_id' => 2, 'area_sn' => $area->sn, 'key' => 'PH值', 'val' => '6.8']);
        		
        		Areaboxcontent::create(['box_id' => 3, 'area_sn' => $area->sn, 'key' => '风速', 'val' => '&lt; 3级']);
        		Areaboxcontent::create(['box_id' => 3, 'area_sn' => $area->sn, 'key' => '风向', 'val' => '东风']);
        		Areaboxcontent::create(['box_id' => 3, 'area_sn' => $area->sn, 'key' => '降雨量', 'val' => '2mm']);

        		Areaboxcontent::create(['box_id' => 4, 'area_sn' => $area->sn, 'val' => '43']);
        	}
        }
    }
}
