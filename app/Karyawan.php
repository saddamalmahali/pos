<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Karyawan extends Authenticatable
{
    protected $table = "karyawan";

    static function createNoKaryawan()
    {
        $karyawan_last = self::orderBy('created_at', 'desc')->first();
        
        if($karyawan_last != ''){
            $id_karyawan = $karyawan_last->kode_karyawan;
            $kode_awal = substr($id_karyawan, 0, 2);
            $id_karyawan = (int) substr($id_karyawan, 8, 2);
            $kode_baru = $id_karyawan++;
            $date = date('dmy');

            $kode_karyawan = 'K-'.$date.sprintf("%'.02d", $id_karyawan);
            return $kode_karyawan;
        }else{
            $date = date('dmy');
            return 'K-'.$date.'01';
        }
    }
}
