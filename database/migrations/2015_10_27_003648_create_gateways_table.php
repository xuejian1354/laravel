<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGatewaysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gateways', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->nullable();
			$table->string('gw_sn');
			$table->string('transtocol');
			$table->string('ip');
			$table->string('udp_port');
			$table->string('tcp_port');
			$table->string('http_url');
			$table->string('area')->nullable();
			$table->string('updatetime')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('gateways');
	}

}
