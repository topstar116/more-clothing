<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_users', function (Blueprint $table) {
            $table->id();
            $table->string('name1');
            $table->string('name2');
            $table->string('kana1');
            $table->string('kana2');
            $table->string('address1');
            $table->string('address2');
            $table->integer('manager_id');
            $table->string('tel');
            $table->string('post');
            $table->string('email');
            $table->string('memo');
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
        Schema::dropIfExists('rental_users');
    }
}
