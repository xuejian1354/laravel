<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('courses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('sn')->unique();
			$table->string('course')->nullable();
			$table->string('room')->nullable();
			$table->string('time')->nullable();
			$table->string('cycle')->nullable();
			$table->string('term')->nullable();
			$table->string('teacher')->nullable();
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
		Schema::drop('courses');
	}

}
