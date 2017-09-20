<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetilePembelian extends Model
{
    protected $table = "detile_pembelian";

    public function pembelian()
    {
        return $this->hasOne('App\Pembelian', 'id', 'id_pembelian');
    }

    public function barang()
    {
        return $this->hasOne('App\Barang', 'id', 'kode_barang');
    }
}
