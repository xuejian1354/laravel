<?php

use Illuminate\Database\Seeder;
use App\Msgboard;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GlobalvalTableSeeder::class);
        $this->call(ConsoleMenuTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(ActionTableSeeder::class);
        $this->call(AreaTableSeeder::class);
        $this->call(DevattrTableSeeder::class);
        $this->call(DevtypeTableSeeder::class);
        $this->call(DevoptTableSeeder::class);
        //$this->call(DeviceTableSeeder::class);
        $this->call(AreaboxTableSeeder::class);
        $this->call(AreaboxcontentTableSeeder::class);
        $this->call(MsgboardTableSeeder::class);
    }
}
