<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCtrlrecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctrlrecords', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('sn')->unique();
			$table->string('content')->nullable();
			$table->string('usersn')->nullable();
			$table->integer('action')->nullable();
			$table->string('optnum')->nullable();
			$table->string('data')->nullable();
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
        Schema::drop('ctrlrecords');
    }
}
