<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Karyawan;
use Illuminate\Support\Facades\DB;
use App\Barang;
use App\Penjualan;
class HomeClientController extends Controller
{
    // public function __construct(){
    //     $this->middleware('auth.karyawan');
    // }
    public function index()
    {
        $jumlah_karyawan = Karyawan::count();
        $jumlah_barang = Barang::count();
        $data_barang_kurang = Barang::where('stok_barang', '<', 10)->get();
        $tanggal = date('Y-m-d');
        $hari = date('Y-m-d', strtotime('-5 days'));
        $data_penjualan = Penjualan::whereDate('tanggal_jual',  $tanggal)->get();
        

        $data = [
            'jumlah_karyawan'=>$jumlah_karyawan,
            'jumlah_barang'=>$jumlah_barang,
            'data_barang_kurang'=>$data_barang_kurang,
            'data_penjualan'=>$data_penjualan
        ];
        return view('client.index', ['data'=>$data]);
    }

    public function get_data_chart()
    {
        $tanggal = date('Y-m-d');
        $hari = date('Y-m-d', strtotime('-5 days'));
        $data_penjualan = Penjualan::whereDate('tanggal_jual',  $tanggal)->get();
        $data_histori_jual = array();

        for ($i=4; $i >= 0; $i--) { 
            $tanggal_jual = date('Y-m-d', strtotime('-'.$i.' days'));
            $data_jual = Penjualan::whereDate('tanggal_jual', $tanggal_jual)->where("id_user", '=', auth('karyawan')->user()->id)->sum('total_harga');

            $data_push = [
                'tanggal'=>$tanggal_jual,
                'data'=>$data_jual
            ];
            array_push($data_histori_jual, $data_push);
        }

        return json_encode($data_histori_jual);
    }
}
