<?php

use Illuminate\Database\Seeder;
use App\Funcmodel;

class FuncmodelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('funcmodels')->delete();
        Funcmodel::create(['id' => 1, 'name' => '物联网监控']);
        Funcmodel::create(['id' => 2, 'name' => '信息管理']);
        Funcmodel::create(['id' => 3, 'name' => '溯源系统']);
        Funcmodel::create(['id' => 4, 'name' => '生产过程']);
    }
}
