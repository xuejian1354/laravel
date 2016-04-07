<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Model\DBStatic\Roomtype;

class RoomtypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roomtypes')->delete();
        Roomtype::create(['roomtype' => '1', 'val' => '阶梯教室']);
        Roomtype::create(['roomtype' => '2', 'val' => '普通教室']);
        Roomtype::create(['roomtype' => '3', 'val' => '多媒体教室']);
        Roomtype::create(['roomtype' => '4', 'val' => '实验室']);
        Roomtype::create(['roomtype' => '5', 'val' => '报告厅']);
        Roomtype::create(['roomtype' => '6', 'val' => '办公室']);
        Roomtype::create(['roomtype' => '7', 'val' => '其它']);
    }
}
