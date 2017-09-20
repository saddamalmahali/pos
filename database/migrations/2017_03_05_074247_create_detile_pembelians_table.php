<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetilePembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detile_pembelian', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pembelian')->length(10);
            $table->integer('kode_barang');
            $table->integer('harga_beli');
            $table->integer('jumlah_sp');
            $table->integer('qty_awal');
            $table->integer('qty_akhir');
            $table->double('sub_total');
            
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
        Schema::dropIfExists('detile_pembelian');
    }
}
