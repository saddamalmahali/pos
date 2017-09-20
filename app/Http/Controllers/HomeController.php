<?php

namespace App\Http\Controllers;

use App\CompanyProfile;
use Illuminate\Http\Request;
use App\Karyawan;
use Illuminate\Support\Facades\DB;
use App\Barang;
use App\Penjualan;
use App\Member;
class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jumlah_karyawan = Karyawan::count();
        $jumlah_barang = Barang::count();
        $data_barang_kurang = Barang::where('stok_barang', '<', 10)->get();
        $tanggal = date('Y-m-d');
        $hari = date('Y-m-d', strtotime('-5 days'));
        $data_penjualan = Penjualan::whereDate('tanggal_jual',  $tanggal)->get();
        $pelanggan = Member::all();
        

        $data = [
            'jumlah_karyawan'=>$jumlah_karyawan,
            'jumlah_barang'=>$jumlah_barang,
            'data_barang_kurang'=>$data_barang_kurang,
            'data_penjualan'=>$data_penjualan
        ];
        
        return view('home', ['data'=>$data]);
    }

    public function get_data_chart()
    {
        $tanggal = date('Y-m-d');
        $hari = date('Y-m-d', strtotime('-5 days'));
        $data_penjualan = Penjualan::whereDate('tanggal_jual',  $tanggal)->get();
        $data_histori_jual = array();

        $bulan = date('m');
        $tahun = date('Y');
        $number = cal_days_in_month(CAL_GREGORIAN, 8, 2003);

        for ($i=1; $i <= $number; $i++) { 
            $tanggal_chart = date('Y-m-d', strtotime($i.'-'.$bulan.'-'.$tahun));
            $tanggal_jual = date('Y-m-d', strtotime($i.'-'.$bulan.'-'.$tahun));
            $data_jual = Penjualan::whereDate('tanggal_jual', $tanggal_jual)->sum('total_harga');

            $data_push = [
                'tanggal'=>$tanggal_jual,
                'data'=>$data_jual
            ];
            array_push($data_histori_jual, $data_push);
        }

        return json_encode($data_histori_jual);
    }

    public function tentang_aplikasi()
    {
        $author = [
                'nama'=> 'Muhammad Ruslan',
                'npm'=>1306089,
                'dosen'=>'Ridwan Setiawan, ST, M.Kom'
            ];
        return view('help.tentang.index', ['author'=>$author]);
    }

    public function setting_index()
    {
        $company = new CompanyProfile();
        $company = $company->first();
        return view('setting_index', [
            'company'=>$company
        ]);
    }

    public function simpan_setting(Request $request)
    {
        $this->validate($request, [
            'nama_toko'=>'required',
            'telp'=>'required',
            'alamat'=>'required'
        ]);

        $nama_toko = $request->get('nama_toko');
        $telp = $request->get('telp');
        $alamat = $request->get('alamat');
        $company = CompanyProfile::find($request->get('id', 1));
        $company->nama_toko = $nama_toko;
        $company->telp = $telp;
        $company->alamat = $alamat;

        if($company->save())
        {
            $request->session()->flash('sukses', 'Berhasil Mengubah Company');
            return redirect('/admin/setting/index');
        }
    }
}
