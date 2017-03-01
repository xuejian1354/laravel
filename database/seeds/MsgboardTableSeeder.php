<?php

use Illuminate\Database\Seeder;
use App\Model\Msgboard;

class MsgboardTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('msgboards')->delete();
        Msgboard::create(['bgcolor' => '#00a65a', 'content' => '<br>']);
        Msgboard::create(['bgcolor' => '#f39c12', 'content' => '<br>']);
        Msgboard::create(['bgcolor' => '#00c0ef', 'content' => '<br>']);
        Msgboard::create(['bgcolor' => '#3c8dbc', 'content' => '<br>']);
        Msgboard::create(['bgcolor' => '#dd4b39', 'content' => '<br>']);
    }
}
