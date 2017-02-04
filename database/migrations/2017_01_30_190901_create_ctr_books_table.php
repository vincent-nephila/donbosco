<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCtrBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctr_books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('level');
            $table->string('acctcode');
            $table->string('acctname');
            $table->string('subsidiary');
            $table->string('receipt_details');
            $table->integer('categoryswitch');
            $table->decimal('amount',10,2);
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
        Schema::drop('ctr_books');
    }
}
