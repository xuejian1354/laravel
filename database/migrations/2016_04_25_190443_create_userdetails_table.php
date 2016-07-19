<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('userdetails', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('sn')->unique();
			$table->string('name');
			$table->string('sexuality')->nullable();
			$table->string('people')->nullable();
			$table->string('num')->unique();
			$table->integer('grade');
			$table->integer('type');
			$table->string('birthdate')->nullable();
			$table->string('polity')->nullable();
			$table->string('native')->nullable();
			$table->string('cellphone')->nullable();
			$table->string('civinum')->nullable();
			$table->string('address')->nullable();
			$table->string('qq')->nullable();
			$table->string('email')->nullable();
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
		Schema::drop('userdetails');
	}

}
