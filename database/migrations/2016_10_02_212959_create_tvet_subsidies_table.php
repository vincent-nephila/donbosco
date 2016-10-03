<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTvetSubsidiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvet_subsidies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idno');
            $table->decimal('sponsor',10,2);
            $table->decimal('subsidy',10,2);
            $table->decimal('discount',10,2);
            $table->string('batch');
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
        Schema::drop('tvet_subsidies');
    }
}
