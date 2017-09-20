<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';

    static function createNoPelanggan()
    {
        $data_last = self::orderBy('created_at', 'desc')->first();
        
        if($data_last != ''){
            $id_data = $data_last->kode_pelanggan;
            $id_baru = (int) substr($id_data, 3, 3);
            $kode_baru = $id_baru+1;

            $kode_data = 'PG-'.sprintf("%'.03d", $kode_baru);
            return $kode_data;
        }else{
            
            return 'PG-001';
        }
    }
}
