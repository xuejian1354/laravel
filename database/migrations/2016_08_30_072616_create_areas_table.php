<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('areas', function (Blueprint $table) {
    		$table->increments('id');
    		$table->string('sn')->unique();
    		$table->string('name')->nullable();
    		$table->string('type')->nullable();
    		$table->string('addr')->nullable();
    		$table->string('status')->nullable();
    		$table->string('user')->nullable();
    		$table->string('owner')->nullable();
    		$table->text('remarks')->nullable();
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
        Schema::drop('areas');
    }
}
