<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode')->length(20);
            $table->string('nama_barang')->length(100);
            $table->string('kode_tipe_motor')->length(50)->nullable();
            $table->integer('harga_beli')->nullable()->default('0');
            $table->integer('harga_jual')->nullable()->default('0');
            $table->integer('stok_barang')->nullable()->default('0');
            $table->string('keterangan')->nullable();

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
        Schema::dropIfExists('barang');
    }
}
