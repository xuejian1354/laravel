<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentreportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contentreports', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->string('committer');
			$table->string('course');
			$table->string('maintitle');
			$table->string('content');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contentreports');
	}

}
