<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiMember extends Model
{
    protected $table = 'transaksi_member';
    public function penjualan()
    {
        return $this->hasOne('App\Penjualan', 'id', 'id_penjualan');
    }

    public function member()
    {
        return $this->hasOne('App\Member', 'id', 'id_member');
    }
}
