<?php

use Illuminate\Database\Seeder;
use App\Devattr;

class DevattrTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('devattrs')->delete();
        Devattr::create(['id' => 1, 'name' => '检测']);
        Devattr::create(['id' => 2, 'name' => '控制']);
        Devattr::create(['id' => 3, 'name' => '监控']);
        Devattr::create(['id' => 4, 'name' => '综合']);
    }
}
