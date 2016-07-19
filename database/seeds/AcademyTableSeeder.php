<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Model\DBStatic\Academy;

class AcademyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('academies')->delete();
        Academy::create(['academy' => '1', 'val' => '建筑学院', 'academyteacher' => 'root']);
        Academy::create(['academy' => '2', 'val' => '机械工程学院', 'academyteacher' => 'root']);
        Academy::create(['academy' => '3', 'val' => '能源与环境学院', 'academyteacher' => 'root']);
        Academy::create(['academy' => '4', 'val' => '信息工程学院', 'academyteacher' => 'root']);
        Academy::create(['academy' => '5', 'val' => '土木工程学院', 'academyteacher' => 'root']);
        Academy::create(['academy' => '6', 'val' => '电子科学与工程学院', 'academyteacher' => 'root']);
        Academy::create(['academy' => '7', 'val' => '数学系', 'academyteacher' => 'root']);
        Academy::create(['academy' => '8', 'val' => '自动化学院', 'academyteacher' => 'root']);
        Academy::create(['academy' => '9', 'val' => '计算机科学与工程学院', 'academyteacher' => 'root']);
        Academy::create(['academy' => '10', 'val' => '物理系', 'academyteacher' => 'root']);
        Academy::create(['academy' => '11', 'val' => '生物科学与医学工程学院', 'academyteacher' => 'root']);
        Academy::create(['academy' => '12', 'val' => '材料科学与工程学院', 'academyteacher' => 'root']);
        Academy::create(['academy' => '13', 'val' => '人文学院', 'academyteacher' => 'root']);
        Academy::create(['academy' => '14', 'val' => '经济管理学院', 'academyteacher' => 'root']);
        Academy::create(['academy' => '15', 'val' => '电气工程学院', 'academyteacher' => 'root']);
        Academy::create(['academy' => '16', 'val' => '外国语学院', 'academyteacher' => 'root']);
        Academy::create(['academy' => '17', 'val' => '体育系', 'academyteacher' => 'root']);
        Academy::create(['academy' => '18', 'val' => '化学与化工学院', 'academyteacher' => 'root']);
        Academy::create(['academy' => '19', 'val' => '交通学院', 'academyteacher' => 'root']);
        Academy::create(['academy' => '20', 'val' => '仪器科学与工程学院', 'academyteacher' => 'root']);
        Academy::create(['academy' => '21', 'val' => '艺术学院', 'academyteacher' => 'root']);
        Academy::create(['academy' => '22', 'val' => '法学院', 'academyteacher' => 'root']);
        Academy::create(['academy' => '23', 'val' => '医学院', 'academyteacher' => 'root']);
    }
}
