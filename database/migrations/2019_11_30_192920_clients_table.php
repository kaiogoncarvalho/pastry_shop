<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table){
            $table->increments('id')->primary();
            $table->string('name', 100);
            $table->string('email', 150)->unique();
            $table->string('phone', 15);
            $table->date('birthdate');
            $table->string('address', 255);
            $table->string('complement', 100);
            $table->string('neighborhood', 255);
            $table->integer('postcode');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
