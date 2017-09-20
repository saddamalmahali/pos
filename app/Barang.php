<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class barang extends Model
{
    protected $table = 'barang';
    static function createNoBarang()
    {
        $barang_last = self::orderBy('created_at', 'desc')->first();
        
        if($barang_last != ''){
            $id_barang = $barang_last->kode;
            $kode_awal = substr($id_barang, 0, 2);
            $id_barang = (int) substr($id_barang, 8, 3);
            $kode_baru = $id_barang++;
            $date = date('dmy');

            $kode_barang = 'B-'.$date.sprintf("%'.03d", $id_barang);
            return $kode_barang;
        }else{
            $date = date('dmy');
            return 'B-'.$date.'001';
        }
    }

    public function getJumlahBarang($bulan, $id_barang){
        /* 
            select p.nota, p.tanggal_jual, dp.kode_sparepart, 
            dp.nama_sparepart, dp.jumlah_sp 
            from penjualan p 
            inner join detile_penjualan dp on p.id=dp.id_penjualan
        */
        $barang = $this->find($id_barang);
        $penjualan = Penjualan::where(DB::raw('extract(month from tanggal_jual)'), '=', $bulan)->get();
        $jumlah_barang = 0;
        
        $jumlah_barang = DB::table('penjualan')
                                    ->join('detile_penjualan', 'penjualan.id', '=', 'detile_penjualan.id_penjualan')
                                    ->where(DB::raw('extract(month from tanggal_jual)'), '=', $bulan)
                                    ->where('kode_sparepart', '=', $barang->kode)
                                    ->sum('jumlah_sp');

        return $jumlah_barang;

    }

    public function getDataPenjualan($barang, $bulan){
        $barang = $this->find($barang);
        $penjualan = Penjualan::where(DB::raw('extract(month from tanggal_jual)'), '=', $bulan)->get();
        $jumlah_barang = 0;
        
        $jumlah_barang = DB::table('penjualan')
                                    ->join('detile_penjualan', 'penjualan.id', '=', 'detile_penjualan.id_penjualan')
                                    ->where(DB::raw('extract(month from tanggal_jual)'), '=', $bulan)
                                    ->where('kode_sparepart', '=', $barang->kode)
                                    ->get();

        return response()->json(view()->make('laporan.penjualan_barang.detile', ['data_transaksi'=>$jumlah_barang])->render());
    }
}
