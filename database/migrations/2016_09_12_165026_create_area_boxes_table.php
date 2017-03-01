<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreaBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areaboxes', function(Blueprint $table)
		{
			$table->integer('id')->unique();
			$table->string('area_type')->nullable();
			$table->string('title')->nullable();
			$table->integer('column');
			$table->string('icon_class')->nullable();
			$table->string('color_class')->nullable();
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
        Schema::drop('areaboxes');
    }
}
