<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorySalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items');
            $table->foreignId('staff_id')->constrained('staffs');
            $table->unsignedBigInteger('get_point_id');
            $table->string('site_url')->nullable();
            $table->date('sold_on');
            $table->unsignedInteger('platform_fee');
            $table->unsignedInteger('moreclo_fee');
            $table->unsignedInteger('postage');
            // $table->unsignedInteger('fee');
            $table->string('memo', 2000)->nullable();
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_sales');
    }
}
