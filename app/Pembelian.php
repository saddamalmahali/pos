<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = "pembelian";

    public function supplier()
    {
        return $this->hasOne('App\Supplier', 'id', 'kode_supplier');
    }

    public function detile()
    {
        return $this->hasMany('App\DetilePembelian', 'id_pembelian', 'id');
    }
}
