<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('devices', function(Blueprint $table)
    	{
    		$table->increments('id');
    		$table->string('sn')->unique();
    		$table->string('name')->nullable();
    		$table->integer('type');
    		$table->integer('attr');
    		$table->string('status')->nullable();
    		$table->string('data')->nullable();
    		$table->string('psn')->nullable();
    		$table->string('area')->nullable();
    		$table->string('alarmthres')->nullable();
    		$table->string('owner')->nullable();
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
    	Schema::drop('devices');
    }
}
