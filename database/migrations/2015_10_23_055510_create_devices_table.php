<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration {

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
			$table->string('dev_sn');
			$table->string('name')->nullable();
			$table->string('dev_type');
			$table->string('znet_status');
			$table->string('dev_data')->nullable();
			$table->string('gw_sn');
			$table->string('area')->nullable();
			$table->boolean('ispublic')->nullable();
			$table->timestamp('updatetime')->nullable();
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
