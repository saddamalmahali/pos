<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetileServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detile_service', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_penjualan')->length(10);
            $table->integer('id_service')->length(10);
            $table->integer('discount')->nullable();  
            $table->integer('harga');
            $table->integer('subtotal');            
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
        Schema::dropIfExists('detile_service');
    }
}
