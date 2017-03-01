<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsoleMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('console_menus', function (Blueprint $table)
        {
        	$table->increments('id');
            $table->string('name');
            $table->string('action')->nullable();
            $table->integer('pnode');
            $table->integer('inode');
            $table->boolean('haschild');
            $table->string('img')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('console_menus');
    }
}
