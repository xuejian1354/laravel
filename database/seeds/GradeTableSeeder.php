<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Model\DBStatic\Grade;

class GradeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('grades')->delete();
        Grade::create(['id' => '1', 'val' => '管理员']);
        Grade::create(['id' => '2', 'val' => '教师']);
        Grade::create(['id' => '3', 'val' => '学生']);
        Grade::create(['id' => '4', 'val' => '访客']);
    }
}
