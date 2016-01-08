<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Model\DBStatic\Coursetype;

class CoursetypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coursetypes')->delete();
        Coursetype::create(['coursetype' => '1', 'val' => '静态课程']);
        Coursetype::create(['coursetype' => '2', 'val' => '动态课程']);
    }
}
