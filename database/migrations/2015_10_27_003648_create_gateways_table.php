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
			$table->string('ip')->nullable();
			$table->string('udp_port')->nullable();
			$table->string('tcp_port')->nullable();
			$table->string('http_url')->nullable();
			$table->string('area')->nullable();
			$table->boolean('ispublic')->nullable();
			$table->string('owner')->nullable();
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
		Schema::drop('gateways');
	}

}
