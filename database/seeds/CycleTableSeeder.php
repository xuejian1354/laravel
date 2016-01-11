<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Model\DBStatic\Cycle;

class CycleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cycles')->delete();
        Cycle::create(['cycle' => '1', 'val' => '一次']);
        Cycle::create(['cycle' => '2', 'val' => '每月']);
        Cycle::create(['cycle' => '3', 'val' => '每周']);
        Cycle::create(['cycle' => '4', 'val' => '每天']);
    }
}
