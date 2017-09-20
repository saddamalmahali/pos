<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetilePenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detile_penjualan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_penjualan')->length(10);
            $table->string('kode_sparepart')->length(50);
            $table->string('nama_sparepart')->length(100);
            $table->string('tipe_motor')->length(100);
            $table->integer('harga_jual');
            $table->integer('discount')->nullable();
            $table->integer('jumlah_sp');
            $table->integer('qty_awal');
            $table->integer('qty_akhir');
            $table->double('sub_total');
            $table->integer('id_pelanggan')->nullable();
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
        Schema::dropIfExists('detile_penjualan');
    }
}
