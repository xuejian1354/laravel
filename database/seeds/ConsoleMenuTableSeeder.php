<?php

use Illuminate\Database\Seeder;
use App\ConsoleMenu;

class ConsoleMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('console_menus')->delete();
        ConsoleMenu::create(['name' => '当前信息', 'action' => 'curinfo', 'pnode' => 0, 'inode' => 1, 'haschild' => false, 'img' => 'fa fa-paw']);
        ConsoleMenu::create(['name' => '场景监控', 'action' => 'areactrl', 'pnode' => 0, 'inode' => 2, 'haschild' => true, 'img' => 'fa fa-file-picture-o']);
        ConsoleMenu::create(['name' => '设备状态', 'action' => 'devstats', 'pnode' => 0, 'inode' => 3, 'haschild' => false, 'img' => 'fa fa-chain']);
        ConsoleMenu::create(['name' => '视频图像', 'action' => 'videoreal', 'pnode' => 0, 'inode' => 4, 'haschild' => false, 'img' => 'fa fa-video-camera']);
        ConsoleMenu::create(['name' => '报警提示', 'action' => 'alarminfo', 'pnode' => 0, 'inode' => 5, 'haschild' => false, 'img' => 'fa fa-volume-up']);

        ConsoleMenu::create(['name' => '大棚1', 'action' => '1', 'pnode' => 2, 'inode' => 6, 'haschild' => false, 'img' => 'fa fa-th-large']);
        ConsoleMenu::create(['name' => '大棚2', 'action' => '2', 'pnode' => 2, 'inode' => 7, 'haschild' => false, 'img' => 'fa fa-th-large']);
        ConsoleMenu::create(['name' => '鱼业基地', 'action' => '3', 'pnode' => 2, 'inode' => 8, 'haschild' => false, 'img' => 'fa fa-align-center']);
        ConsoleMenu::create(['name' => '养猪场', 'action' => '4', 'pnode' => 2, 'inode' => 9, 'haschild' => false, 'img' => 'fa fa-pause']);
    }
}
