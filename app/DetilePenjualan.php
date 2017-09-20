<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetilePenjualan extends Model
{
    protected $table = 'detile_penjualan';
    
    public function penjualan()
    {
        return $this->hasOne('App\Penjualan', 'id', 'id_penjualan');
    }

    public static function getDataBarang($tanggal)
    {
        $data_barang = DB::table('penjualan as p')
                        ->join('detile_penjualan as dp', 'p.id', '=', 'dp.id_penjualan')
                        ->join('barang as b', 'dp.kode_sparepart', '=', 'b.kode')
                        ->distinct()->select('b.nama_barang', 'b.kode')
                        ->where('p.tanggal_jual', '=', $tanggal)->get();

        return $data_barang;

    }

    public static function getJumlahBarang($kode_sparepart, $tanggal){
        $jumlah = DB::table('penjualan as p')
                    ->join('detile_penjualan as dp', 'p.id', '=', 'dp.id_penjualan')
                    ->where('p.tanggal_jual', '=', $tanggal)
                    ->where('dp.kode_sparepart', '=', $kode_sparepart)
                    ->sum('dp.jumlah_sp');
        return $jumlah;
    }
}
