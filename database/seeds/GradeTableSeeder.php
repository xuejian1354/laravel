<?php

use Illuminate\Database\Seeder;
use App\Model\Grade;

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
        Grade::create(['grade' => '1', 'val' => '管理员']);
        Grade::create(['grade' => '2', 'val' => '用户']);
        Grade::create(['grade' => '3', 'val' => '访客']);
    }
}
