<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    
    public function detile(){
        return $this->hasMany('App\DetilePenjualan', 'id_penjualan', 'id');
    }

    public function service()
    {
        return $this->hasMany('App\DetileService', 'id_penjualan', 'id');
    }

    public function pending(){
        return $this->hasOne('App\PenjualanPending', 'id_penjualan', 'id');
    }

    public function karyawan()
    {
        return $this->hasOne('App\Karyawan', 'id', 'id_teknisi');
    }

    public function pelanggan()
    {
        return $this->hasOne('App\Pelanggan', 'id', 'kode_pelanggan');
    }

    public function transaksi_member()
    {
        return $this->hasOne('App\TransaksiMember', 'id_penjualan', 'id');
    }
    static function createNoPenjualan()
    {
        $penjualan_last = self::orderBy('created_at', 'desc')->first();
        
        if($penjualan_last != ''){
            // $id_barang = $barang_last->kode;
            // $kode_awal = substr($id_barang, 0, 2);
            // $id_barang = (int) substr($id_barang, 8, 3);
            // $kode_baru = $id_barang++;
            // $date = date('dmy');

            // $kode_barang = 'B-'.$date.sprintf("%'.03d", $id_barang);
            // return $kode_barang;
            $kode_baru = '';
            $kode_penjualan = $penjualan_last->nota;
            $kode_awal = substr($kode_penjualan, 0, 3);
            $data_tanggal = substr($kode_penjualan, 3, 6);
            $tanggal = substr($data_tanggal, 4,2).'-'.substr($data_tanggal, 2,2).'-'.substr($data_tanggal, 0,2);
           
            $tanggal_akhir = date('dmy', strtotime($tanggal));
            
        //     // return $tanggal_akhir;
            $tanggal_skr = date('dmy');
            // return $tanggal_skr;
            if($tanggal_skr === $tanggal_akhir){
                $kode_ambil = (int) substr($kode_penjualan, 10, 3);
                $kode_ambil++;
                $kode_ambil = sprintf("%'.03d", $kode_ambil);

                return "NP-".date('dmy').$kode_ambil;
                // return "ada";
                // $kode_baru = '001';
                // return "NP-".date('dmy', strtotime($tanggal_skr)).$kode_baru;
                // return "Ada";
            }else if($tanggal_skr > $tanggal_akhir){
                // return $tanggal_skr;
                $kode_baru = '001';
                return "NP-".$tanggal_skr.$kode_baru;
            }else{
                $date = date('dmy');
                return 'NP-'.$date.'001';
            }
        }else{
            $date = date('dmy');
            return 'NP-'.$date.'001';
        }
    }
}
