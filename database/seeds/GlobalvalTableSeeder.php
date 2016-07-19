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
        Globalval::create(['name' => 'title', 'fieldval' => 'ClassYun']);
        Globalval::create(['name' => 'ctrlFrame', 'fieldval' => null]);
        Globalval::create(['name' => 'curterm', 'fieldval' => '2016上']);
        Globalval::create(['name' => 'studentnums', 'fieldval' => '40']);
        Globalval::create(['name' => 'coursetimes', 'fieldval' => '80']);
        Globalval::create(['name' => '1-2-classtime', 'fieldval' => '8:00~9:30']);
        Globalval::create(['name' => '3-4-classtime', 'fieldval' => '10:00~11:30']);
        Globalval::create(['name' => '5-6-classtime', 'fieldval' => '13:00~14:30']);
        Globalval::create(['name' => '7-8-classtime', 'fieldval' => '15:00~16:30']);
        Globalval::create(['name' => '9-11-classtime', 'fieldval' => '18:00~21:00']);
    }
}
