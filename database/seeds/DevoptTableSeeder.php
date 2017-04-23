<?php

use Illuminate\Database\Seeder;
use App\Devopt;
use App\Http\Controllers\Controller;

class DevoptTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('devopts')->delete();
    	Devopt::create(['devtype' => 23, 'method' => 'trigger', 'channel' => 4, 'data' => '{ "off":"00", "on":"01" }']);
    	Devopt::create(['devtype' => 24, 'method' => 'trigger', 'channel' => 4, 'data' => '{ "off":"00", "on":"01" }']);
    	Devopt::create(['devtype' => 25, 'method' => 'trigger', 'channel' => 4, 'data' => '{ "off":"00", "on":"01" }']);
    	Devopt::create(['devtype' => 26, 'method' => 'trigger', 'channel' => 4, 'data' => '{ "off":"00", "on":"01" }']);
    	Devopt::create(['devtype' => 27, 'method' => 'trigger', 'channel' => 4, 'data' => '{ "off":"00", "on":"01" }']);
    	Devopt::create(['devtype' => 28, 'method' => 'trigger', 'channel' => 6, 'data' => '{ "off":"00", "on":"01" }']);
    	Devopt::create(['devtype' => 29, 'method' => 'trigger', 'channel' => 4, 'data' => '{ "off":"00", "on":"01" }']);
    	Devopt::create(['devtype' => 30, 'method' => 'switch', 'channel' => 1, 'data' => '{"正":"01", "停":"02", "反":"03"}']);
    }
}
