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
        $this->call(GradesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ActionsTableSeeder::class);
        $this->call(AreaTableSeeder::class);
        $this->call(DevattrTableSeeder::class);
        $this->call(DevtypeTableSeeder::class);
        $this->call(DevoptTableSeeder::class);
        //$this->call(DeviceTableSeeder::class);
        $this->call(FuncmodelTableSeeder::class);
    }
}
