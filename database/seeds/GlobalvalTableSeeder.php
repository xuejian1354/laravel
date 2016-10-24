<?php

use Illuminate\Database\Seeder;
use App\Globalval;

class GlobalvalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('globalvals')->delete();
        Globalval::create(['name' => 'title', 'val' => 'Cullive']);
        Globalval::create(['name' => 'easydarwin_service', 'val' => 'http://127.0.0.1:8088']);
        Globalval::create(['name' => 'easydarwin_hlslist', 'val' => '/api/getHLSList']);
        Globalval::create(['name' => 'easydarwin_addhls', 'val' => '/api/addHLSList']);
        Globalval::create(['name' => 'easydarwin_delhls', 'val' => '/api/StopHLS']);
    }
}
