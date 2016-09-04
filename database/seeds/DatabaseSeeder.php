<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ConsoleMenuTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(GlobalvalTableSeeder::class);
        $this->call(AreaTableSeeder::class);
        $this->call(ActionTableSeeder::class);
        $this->call(RecordTableSeeder::class);
        $this->call(DevtypeTableSeeder::class);
        $this->call(DeviceTableSeeder::class);
    }
}
