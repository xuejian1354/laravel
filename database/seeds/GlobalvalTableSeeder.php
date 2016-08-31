<?php

use Illuminate\Database\Seeder;
use App\Globalval;

class GlobalvalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('globalvals')->delete();
        Globalval::create(['name' => 'title', 'val' => 'Cullive']);
    }
}
