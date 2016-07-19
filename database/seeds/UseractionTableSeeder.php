<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Model\DBStatic\Useraction;

class UseractionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('useractions')->delete();
        Useraction::create(['useraction' => '1', 'val' => '登录']);
        Useraction::create(['useraction' => '2', 'val' => '查看消息']);
    }
}
