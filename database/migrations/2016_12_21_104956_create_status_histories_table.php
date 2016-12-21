<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idno');
            $table->date('date_registered');
            $table->date('date_enrolled');
            $table->integer('status')->length(11)->unsigned();
            $table->date('dropdate');
            $table->string('department');
            $table->string('level');
            $table->string('track');
            $table->string('strand');
            $table->string('course');
            $table->string('section');
            $table->integer('class_no')->length(15)->unsigned();
            $table->string('plan');
            $table->string('schoolyear');
            $table->string('period');
            $table->integer('isnew')->length(11)->unsigned();
            $table->integer('isesc')->length(11)->unsigned();
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
        Schema::drop('status_histories');
    }
}
