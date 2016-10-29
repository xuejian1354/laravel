<?php

use Illuminate\Database\Seeder;
use App\Devopt;
use App\Http\Controllers\Controller;

class DevoptsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Devopt::create(['devtype' => 26, 'method' => 'switch', 'key' => 'sw1', 'data' => '00']);
    	Devopt::create(['devtype' => 26, 'method' => 'switch', 'key' => 'sw1', 'data' => '01']);
    	Devopt::create(['devtype' => 26, 'method' => 'switch', 'key' => 'sw2', 'data' => '00']);
    	Devopt::create(['devtype' => 26, 'method' => 'switch', 'key' => 'sw2', 'data' => '01']);
    	Devopt::create(['devtype' => 26, 'method' => 'switch', 'key' => 'sw3', 'data' => '00']);
    	Devopt::create(['devtype' => 26, 'method' => 'switch', 'key' => 'sw3', 'data' => '01']);
    	Devopt::create(['devtype' => 26, 'method' => 'switch', 'key' => 'sw4', 'data' => '00']);
    	Devopt::create(['devtype' => 26, 'method' => 'switch', 'key' => 'sw5', 'data' => '01']);
    }
}
