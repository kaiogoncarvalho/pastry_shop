<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrdersPastriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_pastries', function (Blueprint $table) {
            $table->integer('order_id')->unsigned();
            $table->integer('pastry_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('pastry_id')->references('id')->on('pastries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('orders_pastries');
        Schema::enableForeignKeyConstraints();
    }
}
