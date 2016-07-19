<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('academies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('academy');
			$table->string('val');
			$table->string('academyteacher');
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
		Schema::drop('academies');
	}

}
