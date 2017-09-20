<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nota')->length(50);
            $table->date('tanggal_jual');
            $table->string('kode_pelanggan')->length(30)->nullable();
            $table->integer('id_user')->length(10);
            $table->integer('tipe_user')->length(2);
            $table->integer('id_teknisi')->length(10)->nullable();
            $table->integer('total_sp');
            $table->integer('total_harga');
            $table->integer('bayar');
            $table->integer('kembali');
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('penjualan');
    }
}
