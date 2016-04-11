<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rooms', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('sn')->unique();
			$table->string('name')->nullable();
			$table->string('roomtype')->nullable();
			$table->string('addr')->nullable();
			$table->string('status')->nullable();
			$table->string('user')->nullable();
			$table->string('owner')->nullable();
			$table->string('remarks')->nullable();
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
		Schema::drop('rooms');
	}

}
