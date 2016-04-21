<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassgradesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('classgrades', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('classgrade');
			$table->integer('academy');
			$table->string('val');
			$table->string('classteacher');
			$table->string('otherteachers')->nullable();
			$table->text('text')->nullable();
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
		Schema::drop('classgrades');
	}

}
