<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKaryawansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_karyawan')->length(50)->unique();
            $table->string('nama_lengkap')->length(50);
            $table->enum('jenis_kelamin', ['l', 'p']);
            $table->string('tempat_lahir')->length(50);
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('foto')->length(100)->nullable();
            $table->string('username')->length(50)->nullable();
            $table->string('password')->length(100)->nullable();
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
        Schema::dropIfExists('karyawan');
    }
}
