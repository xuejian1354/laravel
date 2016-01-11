<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMainreportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mainreports', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title')->unique();
			$table->string('creator');
			$table->string('course');
			$table->string('details');
			$table->json('commitlist');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('mainreports');
	}

}
