<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlarmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alarms', function (Blueprint $table) {
            $table->increments('id');
			$table->string('sn')->unique();
			$table->string('content')->nullable();
			$table->string('devsn')->nullable();
			$table->string('action')->nullable();
			$table->string('thres')->nullable();
			$table->string('val')->nullable();
			$table->string('optnum')->nullable();
			$table->boolean('enable');
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
        Schema::dropIfExists('alarms');
    }
}
