<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Request\PenjualanRequest as PenjualanValidation;
use App\Barang;
use App\Karyawan;
use App\TipeMotor;
use App\Penjualan;
use App\DetilePenjualan;
use App\Pelanggan;
use App\Service;
use App\DetileService;
use App\TransaksiMember;
use App\Member;
use App\PenjualanPending;
class TransaksionalController extends Controller
{
    public function index_penjualan()
    {
        $data_penjualan = Penjualan::orderBy('created_at', 'desc')->get();
        return view('client.transaksi.penjualan.index', ['data_penjualan'=>$data_penjualan]);
    }

    public function form_tambah_penjualan()
    {
        $data_tipe = TipeMotor::all();
        $data_penjualan = new Penjualan();
        $data_penjualan = $data_penjualan->paginate(10);
        $data_barang =Barang::all();
        $data_pelanggan = Pelanggan::all();
        $data_service = Service::all();
        $data_member = Member::all();
        $no_nota = Penjualan::createNoPenjualan();
        $data_montir = Karyawan::whereNull('username')->get();
        return view('client.transaksi.penjualan.tambah', [
            'data_tipe'=>$data_tipe,
            'data_penjualan'=>$data_penjualan,
            'data_barang'=>$data_barang,
            'no_nota'=>$no_nota,
            'data_pelanggan'=>$data_pelanggan,
            'data_member'=>$data_member,
            'data_service'=>$data_service,
            'data_montir'=>$data_montir
        ]);
    }

    public function get_data_barang(Request $request)
    {
        $term = $request->input('term');


        $data_barang =Barang::where('nama_barang', 'like', "%$term%")->orWhere('kode_tipe_motor', 'like', "%$term%")->get();
        return json_encode($data_barang);
    }

    public function simpan_penjualan(Request $request)
    {
        $penjualan = new Penjualan();
        $data_detile = $request->input('detile_penjualan');
        $detile_service = $request->input('detile_service');
        $teknisi = $request->input('id_teknisi');
        $penjualan->nota = $request->input('nota');
        $penjualan->tanggal_jual = date('Y-m-d', strtotime($request->input('tanggal_jual')));
        $penjualan->total_sp = 0;
        $penjualan->total_harga = 0;
        $penjualan->bayar = 0;
        $montir = $request->input('montir');
        if(isset($montir))
        {
            $penjualan->id_teknisi = $montir;
        }
        $penjualan->kembali = 0;
        $pelanggan = $request->input('pelanggan');
        if(isset($pelanggan)){
            $penjualan->kode_pelanggan = $pelanggan;
        }
        $penjualan->id_user = auth('karyawan')->user()->id;
        $penjualan->tipe_user = 1;
       
        if($penjualan->save())
        {
            $pending = new PenjualanPending();
            $pending->id_penjualan = $penjualan->id;
            if($pending->save()){
                 $member = $request->input('member');
                if($member != '' || $member != null){
                    $transaksi_member = new TransaksiMember();
                    $transaksi_member->id_penjualan = $penjualan->id;
                    $transaksi_member->id_member = $member;
                    $transaksi_member->save();
                }
                $request->session()->flash('sukses', 'Data Sukses Dimasukan kedalam Antrian!');
                return redirect('/transaksi/penjualan');
            }
            
        }
    }

    public function get_data_barang_from_id(Request $request)
    {
        $id_barang = $request->input('id');
        $barang = Barang::find($id_barang);

        return json_encode($barang);
    }

    public function coba_print()
    {
       return view('coba.print');
    }

    public function get_data_service(Request $request)
    {
        $id_service = $request->input('id');
        $service = Service::find($id_service);

        return json_encode($service);
    }

    public function hapus_penjualan(Request $request)
    {
        $id_penjualan = $request->input('id');

        $penjualan = Penjualan::find($id_penjualan);

        if($penjualan->service()->count() > 0){
            foreach ($penjualan->service as $service) {
                $service->delete();
            }
        }

        if($penjualan->detile()->count() > 0){
            foreach ($penjualan->detile as $detile) {
                $detile->delete();
            }
        }

        

        if($penjualan->delete()){
            $request->session()->flash('error', 'Data Penjualan Berhasil Dihapus!');
            return json_encode(['sukses']);
        }
    }

    public function konfirmasi_penjualan(Request $request, $id)
    {
        $penjualan = Penjualan::find($id);
        $data_barang =Barang::all();
        $data_pelanggan = Pelanggan::all();
        $data_service = Service::all();
        $data_member = Member::all();
        $data_montir = Karyawan::whereNull('username')->get();
        return view('client.transaksi.penjualan.simpan', [
            'penjualan'=>$penjualan,
            'data_barang'=>$data_barang,
            'data_pelanggan'=>$data_pelanggan,
            'data_service'=>$data_service,
            'data_member'=>$data_member,
            'data_montir'=>$data_montir,
        ]);
    }

    public function simpan_transaksi_penjualan(Request $request)
    {
        $penjualan = Penjualan::find($request->input('id'));
        $data_detile = $request->input('detile_penjualan');
        $detile_service = $request->input('detile_service');
        
        
        $total_sp = 0;
        if($data_detile != null){
            foreach ($data_detile as $detile ) {
                /*
                *    ========================
                *    Detile Penjualan
                *    ========================
                *    -   id
                *    -   id_penjualan
                *    -   kode_sparepart
                *    -   nama_sparepart
                *    -   tipe_motor
                *    -   harga_jual
                *    -   discount
                *    -   jumlah_sp
                *    -   qty_awal
                *    -   qty_akhir
                *    -   sub_total
                *    -   id_pelanggan 
                */
                if(isset($detile['barang'])){
                    $barang = Barang::find($detile['barang']);

                    $detile_penjualan = new DetilePenjualan();
                    $detile_penjualan->id_penjualan = $penjualan->id;
                    $detile_penjualan->kode_sparepart = $barang->kode;
                    $detile_penjualan->nama_sparepart = $barang->nama_barang;
                    $detile_penjualan->tipe_motor = $barang->kode;
                    $detile_penjualan->harga_jual = $barang->harga_jual;
                    
                    $diskon = $detile['disc'];
                    if($diskon != '' || $diskon != null){
                        $detile_penjualan->discount = $diskon;
                    }else{
                        $detile_penjualan->discount = 0;
                    }

                    $detile_penjualan->jumlah_sp = $detile['jumlah'];
                    $total_sp = $total_sp+$detile['jumlah'];
                    $detile_penjualan->qty_awal = $barang->stok_barang;
                    $detile_penjualan->qty_akhir = $barang->stok_barang - $detile['jumlah'];
                    $detile_penjualan->sub_total = $detile['jumlah_harga'];
                    $detile_penjualan->id_pelanggan = null;
                    
                    if($detile_penjualan->save()){
                        $barang->stok_barang = $barang->stok_barang - $detile['jumlah'];
                        $barang->save();
                    }
                    unset($detile_penjualan);
                }

            }
        }
            
        
        
        if($detile_service != null){
            foreach ($detile_service as $data_s) {
                if(isset($data_s['id_service'])){
                    $service = Service::find($data_s['id_service']);
                    $detile_service = new DetileService();
                    $detile_service->id_penjualan = $penjualan->id;
                    $detile_service->id_service = $data_s['id_service'];
                    $diskon = $data_s['discount'];
                    if($diskon != '' || $diskon != null){
                        $detile_service->discount = $diskon;
                    }else{
                        $detile_service->discount = 0;
                    }
                    
                    
                    $detile_service->harga = $service->harga;
                    $detile_service->subtotal = $data_s['jumlah_harga'];
                    $detile_service->save();
                    unset($detile_service);
                }
            }
        }
            
        $penjualan->total_harga = $request->input('jumlah_bayar');
        $penjualan->bayar = $request->input('bayar');
        $penjualan->kembali = $request->input('kembali');
        $penjualan->total_sp = $total_sp;
            
        if($penjualan->save()){
            $pending = PenjualanPending::where('id_penjualan',$penjualan->id)->first();
            if($pending->delete()){
                $request->session()->flash('sukses', 'Data Sukses Disimpan!');
                $request->session()->flash('id', $penjualan->id);
                return redirect('/transaksi/penjualan');
            }
            
        }

        
            
        
    }
}
