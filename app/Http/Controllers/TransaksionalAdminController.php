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
use App\Supplier;
use App\Member;
use App\Pembelian;
use App\DetilePembelian;
use App\TransaksiMember;
class TransaksionalAdminController extends Controller
{
    public function index_penjualan()
    {
        $data_penjualan = new Penjualan();
        $data_penjualan = $data_penjualan->get();
        return view('admin.transaksi.penjualan.index', ['data_penjualan'=>$data_penjualan]);
    }

    public function form_tambah_penjualan()
    {
        $data_tipe = TipeMotor::all();
        $data_penjualan = new Penjualan();
        $data_penjualan = $data_penjualan->paginate(10);
        $data_barang =Barang::all();
        $data_pelanggan = Pelanggan::all();
        $data_member = Member::all();
        $data_service = Service::all();
        $no_nota = Penjualan::createNoPenjualan();
        $data_montir = Karyawan::whereNull('username')->get();
        return view('admin.transaksi.penjualan.tambah', [
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
        if($data_detile > 0 || $detile_service > 0){
            $penjualan->nota = $request->input('nota');
            $penjualan->tanggal_jual = date('Y-m-d', strtotime($request->input('tanggal_jual')));
            $penjualan->total_sp = 0;
            $penjualan->total_harga = $request->input('jumlah_bayar');
            $penjualan->bayar = $request->input('bayar');
            $montir = $request->input('montir');
            if(isset($montir))
            {
                $penjualan->id_teknisi = $montir;
            }
            $penjualan->kembali = $request->input('kembali');
            $pelanggan = $request->input('pelanggan');
            if(isset($pelanggan)){
                $penjualan->kode_pelanggan = $pelanggan;
            }
            $penjualan->id_user = auth('web')->user()->id;
            $penjualan->tipe_user = 2;
            //return json_encode($request->input('jumlah_bayar'));
            if($penjualan->save()){
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
                
                
                
                
            }

            $member = $request->input('member');
            if($member != '' || $member != null){
                $transaksi_member = new TransaksiMember();
                $transaksi_member->id_penjualan = $penjualan->id;
                $transaksi_member->id_member = $member;
                $transaksi_member->save();
            }

            $penjualan->total_sp = $total_sp;
                
            $penjualan->save();

            $request->session()->flash('sukses', 'Data Sukses Disimpan!');
            $request->session()->flash('id', $penjualan->id);
            return redirect('/admin/transaksi/penjualan');
            
        }else{
            return "Kosong";
        }
        

        return dd($request->all());
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
                $barang = Barang::where('kode', '=',$detile->kode_sparepart)->first();
                if($barang != null){
                    $barang->stok_barang = $barang->stok_barang + $detile->jumlah_sp;
                    $barang->save();
                }
                $detile->delete();
            }
        }

        if($penjualan->transaksi_member()->count() > 0){
            $penjualan->transaksi_member->delete();
        }

        

        if($penjualan->delete()){
            $request->session()->flash('error', 'Data Penjualan Berhasil Dihapus!');
            return json_encode(['sukses']);
        }
    }

    public function update_penjualan(Request $request, $id)
    {
        // $data_tipe = TipeMotor::all();
        // $data_penjualan = new Penjualan();
        // $data_penjualan = $data_penjualan->paginate(10);
        // $data_barang =Barang::all();
        // $data_pelanggan = Pelanggan::all();
        // $data_member = Member::all();
        // $data_service = Service::all();
        // $no_nota = Penjualan::createNoPenjualan();
        // $data_montir = Karyawan::whereNull('username')->get();
        // return view('admin.transaksi.penjualan.tambah', [
        //     'data_tipe'=>$data_tipe,
        //     'data_penjualan'=>$data_penjualan,
        //     'data_barang'=>$data_barang,
        //     'no_nota'=>$no_nota,
        //     'data_pelanggan'=>$data_pelanggan,
        //     'data_member'=>$data_member,
        //     'data_service'=>$data_service,
        //     'data_montir'=>$data_montir
        // ]);
        $penjualan = Penjualan::find($id);
        $data_pelanggan = Pelanggan::all();
        $data_barang =Barang::all();
        $data_member = Member::all();
        $data_montir = Karyawan::whereNull('username')->get();
        $data_service = Service::all();
        return view('admin.transaksi.penjualan.update', [
                'penjualan'=>$penjualan,
                'data_pelanggan'=>$data_pelanggan,
                'data_barang'=>$data_barang,
                'data_member'=>$data_member,
                'data_montir'=>$data_montir,
                'data_service'=>$data_service,
            ]);
    }

    public function simpan_update(Request $request)
    {
        $id = $request->input('id');
        $penjualan = Penjualan::find($id);

        if($penjualan->service != null){
            foreach ($penjualan->service as $service) {
                $service->delete();
            }
        }

        if($penjualan->detile != null){
            foreach ($penjualan->detile as $detile) {
                $b = Barang::where('kode', '=', $detile->kode_sparepart)->first();
                $b->stok_barang = $b->stok_barang+$detile->jumlah_sp;
                if($b->save()){
                    $detile->delete();
                }
            }
        }
        if($penjualan->transaksi_member != null){
            $penjualan->transaksi_member->delete();
        }

        $data_detile = $request->input('detile_penjualan');
        $detile_service = $request->input('detile_service');
        $teknisi = $request->input('id_teknisi');
        if($data_detile > 0 || $detile_service > 0){
            $penjualan->nota = $request->input('nota');
            $penjualan->tanggal_jual = date('Y-m-d', strtotime($request->input('tanggal_jual')));
            $penjualan->total_sp = 0;
            $penjualan->total_harga = $request->input('jumlah_bayar');
            $penjualan->bayar = $request->input('bayar');
            $montir = $request->input('montir');
            if(isset($montir))
            {
                $penjualan->id_teknisi = $montir;
            }
            $penjualan->kembali = $request->input('kembali');
            $pelanggan = $request->input('pelanggan');
            if(isset($pelanggan)){
                $penjualan->kode_pelanggan = $pelanggan;
            }
            $penjualan->id_user = auth('web')->user()->id;
            $penjualan->tipe_user = 2;
            //return json_encode($request->input('jumlah_bayar'));
            if($penjualan->save()){
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
                
                
                
                
            }

            $member = $request->input('member');
            if($member != '' || $member != null){
                $transaksi_member = new TransaksiMember();
                $transaksi_member->id_penjualan = $penjualan->id;
                $transaksi_member->id_member = $member;
                $transaksi_member->save();
            }

            $penjualan->total_sp = $total_sp;
                
            $penjualan->save();

            $request->session()->flash('sukses', 'Data Sukses Disimpan!');
            $request->session()->flash('id', $penjualan->id);
            return redirect('/admin/transaksi/penjualan');
            
        }else{
            return "Kosong";
        }
    }

    public function index_pembelian()
    {
        $data_pembelian = Pembelian::all();
        return view('admin.transaksi.pembelian.index', ['data_pembelian'=>$data_pembelian]);
    }

    public function tambah_pembelian()
    {
        $data_supplier = Supplier::all();
        $data_barang = Barang::all();
        return view('admin.transaksi.pembelian.tambah', ['data_supplier'=>$data_supplier, 'data_barang'=>$data_barang]);
    }

    public function simpan_pembelian(Request $request)
    {
        /*
         *  id_pembelian
         *  kode_barang
         *  harga_beli
         *  jumlah_sp
         *  qty_awal
         *  qty_akhir
         *  subtotal 
         *  
        */
        $pembelian = new Pembelian();
        $pembelian->kode = $request->input('kode_pembelian');
        $pembelian->tanggal = date('Y-m-d', strtotime($request->input('tanggal_beli')));
        $pembelian->kode_supplier = $request->input('supplier');
        $pembelian->total_sp = 0;
        $pembelian->memo = $request->input('keterangan');
        $detile_pembelian = $request->input('detile_pembelian');

        if($pembelian->save()){
            $total_barang= 0;
            foreach ($detile_pembelian as $detile) {
                $detile_beli = new DetilePembelian();
                $barang = Barang::find($detile['barang']);
                $detile_beli->id_pembelian = $pembelian->id;

                $detile_beli->kode_barang = $detile['barang'];
                $detile_beli->harga_beli = $detile['harga_beli'];
                $detile_beli->jumlah_sp = $detile['jumlah'];
                $detile_beli->qty_awal = $barang->stok_barang;

                $detile_beli->qty_akhir = $barang->stok_barang+$detile['jumlah'];
                $detile_beli->sub_total = $detile['jumlah_harga'];
                $total_barang = $total_barang+$detile['jumlah'];
                if($detile_beli->save()){
                    $barang->stok_barang= $barang->stok_barang+$detile['jumlah'];
                    $barang->harga_beli = $detile['harga_beli'];
                    $barang->save();
                }
            }

            $pembelian->total_sp = $total_barang;

            if($pembelian->save()){
                $request->session()->flash('sukses', 'Data Sukses Disimpan!');
                return redirect('/admin/transaksi/pembelian');
            }

        }
        // return json_encode($request->all());

    }

    public function view_pembelian($id)
    {
        $pembelian = Pembelian::find($id);

        return view('admin.transaksi.pembelian.view', ['pembelian'=>$pembelian]);
    }

    public function hapus_pembelian(Request $request)
    {
        $id_pembelian = $request->input('id');

        $pembelian = Pembelian::find($id_pembelian);

        if($pembelian->detile()->count() > 0){
            foreach ($pembelian->detile as $detile) {
                $barang = Barang::find($detile->kode_barang);
                if($barang != null){
                    $barang->stok_barang = $barang->stok_barang - $detile->jumlah_sp;
                    if($barang->save()){
                        $detile->delete();
                    }
                }
                
                
            }
        }

        if($pembelian->delete()){
            $request->session()->flash('error', 'Data Pembelian Berhasil Dihapus!');
            return json_encode(['sukses']);
        }
    }


}
