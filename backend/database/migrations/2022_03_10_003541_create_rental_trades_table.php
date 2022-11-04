<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_trades', function (Blueprint $table) {
            $table->id();
            $table->string('rental_user_name1');
            $table->string('rental_user_name2');
            $table->integer('Staff_id');
            $table->integer('price');
            $table->integer('fee');
            $table->string('Staff_name1');
            $table->string('Staff_name2');
            $table->string('start_at');
            $table->string('finish_at');
            $table->string('return_at');
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
        Schema::dropIfExists('rental_trades');
    }
}
