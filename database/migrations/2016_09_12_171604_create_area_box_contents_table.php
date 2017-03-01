<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreaBoxContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areaboxcontents', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('type');
			$table->integer('box_id');
			$table->string('area_sn')->nullable();
			$table->string('key')->nullable();
			$table->string('val')->nullable();
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
        Schema::drop('areaboxcontents');
    }
}
