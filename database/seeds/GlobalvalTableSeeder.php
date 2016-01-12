<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Model\DBStatic\Globalval;

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
        Globalval::create(['key' => 'title', 'val' => 'SmartLab']);
    }
}
