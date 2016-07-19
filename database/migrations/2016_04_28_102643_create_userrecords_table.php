<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRecordsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('userrecords', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('sn')->unique();
			$table->string('name')->nullable();
			$table->string('usersn')->nullable();
			$table->integer('action')->nullable();
			$table->string('optnum')->nullable();
			$table->string('data')->nullable();
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
		Schema::drop('userrecords');
	}

}
