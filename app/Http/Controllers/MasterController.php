<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\KaryawanRequest as KaryawanValidation;
use App\Http\Requests\BarangRequest as BarangValidation;
use App\Http\Requests\SupplierRequest as SupplierValidation;
use App\Http\Requests\MemberRequest as MemberValidation;
use App\Karyawan;
use App\Barang;
use App\TipeMotor;
use App\Service;
use App\Pelanggan;
use App\Supplier;
use App\Member;

class MasterController extends Controller
{
    public function index_barang(Request $request)
    {
        $param = $request->input('param');
        if($param == null || $param == ''){
            $data_barang = new Barang();
            $data_barang = $data_barang->get();
            return view('master.barang.index', ['data_barang'=>$data_barang]);
        }else{
            $data_barang = Barang::where(function($query){
                $query->where('kode', 'like', '%' .$_GET['param']. '%')
              ->orWhere('kode_tipe_motor', 'like', '%' .$_GET['param']. '%')
              ->orWhere('nama_barang', 'like', '%' .$_GET['param']. '%');
            });
            $data_barang = $data_barang->paginate(10);
            return view('master.barang.index', ['data_barang'=>$data_barang]);
        }

    }

    public function tambah_barang()
    {
        $kode_barang = Barang::createNoBarang();
        return view('master.barang.tambah', ['kode_barang'=>$kode_barang]);
    }

    public function simpan_data_barang(BarangValidation $request)
    {
        $barang = new Barang();
        $barang->kode = $request->input('kode');
        $barang->nama_barang = $request->input('nama_barang');
        $barang->kode_tipe_motor = $request->input('kode_tipe_motor');
        $barang->harga_beli = (int) $request->input('harga_beli');
        $barang->harga_jual = (int) $request->input('harga_jual');
        $barang->stok_barang = (int) $request->input('stok_barang');
        $barang->keterangan = $request->input('keterangan');

        if($barang->save()){
            $request->session()->flash('sukses', 'Data Sukses Disimpan!');
            return redirect('/master/barang');
        }

    }

    public function edit_form_barang($id)
    {
        $barang = Barang::find($id);
        return view('master.barang.edit', ['barang'=>$barang]);
    }

    public function simpan_update_data_barang(BarangValidation $request)
    {
        $barang = Barang::find($request->input('id'));
        $barang->kode = $request->input('kode');
        $barang->nama_barang = $request->input('nama_barang');
        $barang->kode_tipe_motor = $request->input('kode_tipe_motor');
        $barang->harga_beli = (int) $request->input('harga_beli');
        $barang->harga_jual = (int) $request->input('harga_jual');
        $barang->stok_barang = (int) $request->input('stok_barang');
        $barang->keterangan = $request->input('keterangan');

        if($barang->save()){
            $request->session()->flash('sukses', 'Data Sukses Mutakhirkan!');
            return redirect('/master/barang');
        }
    }

    public function hapus_barang(Request $request)
    {
        $id_barang = $request->input('id');

        $barang = Barang::find($id_barang);

        if($barang->delete()){
            $request->session()->flash('error', 'Data Barang Berhasil Dihapus!');
            return json_encode(['sukses']);
        }
    }

    public function index_karyawan()
    {
        $data_karyawan = new Karyawan();
        $data_karyawan = $data_karyawan->paginate(10);
        return view('master.karyawan.index', ['data_karyawan'=>$data_karyawan]);
    }

    public function karyawan_form_tambah()
    {
        $id_karyawan = Karyawan::createNoKaryawan();
        return view('master.karyawan.tambah', ['id_karyawan'=>$id_karyawan]);
    }

    public function simpan_karyawan(KaryawanValidation $request)
    {
        // if ($request->file('foto')->isValid()) {
        //     $nama_foto = $request->file('foto')->getClientOriginalName();

        //     $path = "img";
        //     if($urlp = $request->foto->move($path, $nama_foto)){
        //         echo $urlp;
        //     }

        // }
        $karyawan = new Karyawan();
        $karyawan->kode_karyawan = $request->input('no_karyawan');
        $karyawan->nama_lengkap = $request->input('nama_lengkap');
        $karyawan->jenis_kelamin = $request->input('jenis_kelamin');
        $karyawan->tempat_lahir = $request->input('tempat_lahir');
        $karyawan->tanggal_lahir = date('Y-m-d', strtotime($request->input('tanggal_lahir')) );
        $karyawan->alamat = $request->input('alamat');

        if($request->file('foto') != null){
            if($request->file('foto')->isValid()){
                $nama_foto = $request->file('foto')->getClientOriginalName();

                $path = "img";
                if($urlp = $request->foto->move($path, $nama_foto)){
                    $karyawan->foto = $urlp;
                }

            }
        }
        $teknisi = $request->input('kasir');
        if(isset($teknisi)){
            $karyawan->username = $request->input('username');
            $karyawan->password = bcrypt($request->input('password'));
        }



        if($karyawan->save()){
            $request->session()->flash('sukses', 'Data Sukses Disimpan!');
            return redirect('/master/karyawan');
        }


    }

    public function hapus_karyawan(Request $request)
    {
        $id_karyawan = $request->input('id');

        $karyawan = Karyawan::find($id_karyawan);

        if($karyawan->delete()){
            $request->session()->flash('error', 'Data Berhasil Dihapus!');
            return json_encode(['sukses']);
        }
    }

    public function view_karyawan($id){
        $karyawan = Karyawan::find($id);
        return view("master.karyawan.detail", ['karyawan'=>$karyawan]);
    }

    //Menu Tipe Motor
    public function index_tipe_motor()
    {
        $data_tipe = new TipeMotor();
        $data_tipe = $data_tipe->paginate(5);
        return view('master.tipe_motor.index', ['data_tipe'=>$data_tipe] );
    }

    public function simpan_tipe_motor(Request $request)
    {
        $id = $request->input('id');
        if($id!= null || $id != "")
        {
            $tipe_motor = TipeMotor::find($id);
            $tipe_motor->kode = $request->input('kode');
            $tipe_motor->tipe_motor = $request->input('tipe_motor');

            if($tipe_motor->save()){
                $request->session()->flash('sukses', 'Data Berhasil Dimutakhirkan!');
                return redirect('/master/tipe_motor');
            }
        }else{
            $tipe_motor = new TipeMotor();
            $tipe_motor->kode = $request->input('kode');
            $tipe_motor->tipe_motor = $request->input('tipe_motor');

            if($tipe_motor->save()){
                $request->session()->flash('sukses', 'Data Berhasil Ditambahkan!');
                return redirect('/master/tipe_motor');
            }
        }
    }

    public function hapus_tipe_motor(Request $request)
    {
        $id_tipe = $request->input('id');

        $tipe = TipeMotor::find($id_tipe);

        if($tipe->delete()){
            $request->session()->flash('error', 'Data Berhasil Dihapus!');
            return json_encode(['sukses']);
        }
    }

    public function index_service()
    {
        $data_service = new Service();
        $data_service = $data_service->paginate(10);
        return view('master.service.index', ['data_service'=>$data_service]);
    }

    public function simpan_service(Request $request)
    {
        $id = $request->input('id');

        if($id == null || $id == ''){
            $service = new Service();
            $service->kode = Service::createNoService();
            $service->nama = $request->input('nama');
            $service->harga = $request->input('harga');
            $service->keterangan = $request->input('keterangan');
            if($service->save()){
                $request->session()->flash('sukses', 'Data Berhasil Ditambahkan!');
                return redirect('/master/service');
            }
        }else{
            $service = Service::find($id);
            $service->nama = $request->input('nama');
            $service->harga = $request->input('harga');
            $service->keterangan = $request->input('keterangan');
            if($service->save()){
                $request->session()->flash('sukses', 'Data Berhasil Dimutakhir!');
                return redirect('/master/service');
            }
        }
    }

    public function hapus_service(Request $request)
    {
        $id = $request->input('id');
        $service = Service::find($id);
        if($service->delete()){
            $request->session()->flash('error', 'Data Berhasil Dihapus!');
            return json_encode(['sukses']);
        }
    }

    public function index_pelanggan()
    {
        $data_tipe = TipeMotor::all();
        $data_pelanggan = Pelanggan::all();
        
        return view('master.pelanggan.index', ['data_pelanggan'=>$data_pelanggan, 'data_tipe'=>$data_tipe]);
    }

    public function simpan_pelanggan(Request $request)
    {
        $id = $request->input('id');

        if($id == null || $id == '')
        {
            $pelanggan = new Pelanggan();
            $pelanggan->kode = Pelanggan::createNoPelanggan();
            $pelanggan->nama = $request->input('nama');
            $pelanggan->no_telp = $request->input('no_telp');
            if($pelanggan->save()){
                $request->session()->flash('sukses', 'Data Berhasil Ditambahkan!');
                return redirect('/master/pembeli');
            }
        }else{
            $pelanggan = Pelanggan::find($id);
            $pelanggan->nama = $request->input('nama');
            $pelanggan->no_telp = $request->input('no_telp');
            if($pelanggan->save()){
                $request->session()->flash('sukses', 'Data Berhasil Dimutakhirkan!');
                return redirect('/master/pembeli');
            }
        }
    }

    public function index_admin_pelanggan()
    {
        $data_tipe = TipeMotor::all();
        $data_pelanggan = Pelanggan::all();
        return view('master.admin_pelanggan.index', ['data_pelanggan'=>$data_pelanggan, 'data_tipe'=>$data_tipe]);
    }

    public function simpan_admin_pelanggan(Request $request)
    {
        $id = $request->input('id');

        if($id == null || $id == '')
        {
            $pelanggan = new Pelanggan();
            $pelanggan->kode = Pelanggan::createNoPelanggan();
            $pelanggan->nama = $request->input('nama');
            $pelanggan->no_telp = $request->input('no_telp');
            if($pelanggan->save()){
                $request->session()->flash('sukses', 'Data Berhasil Ditambahkan!');
                return redirect('/master/admin/pembeli');
            }
        }else{
            $pelanggan = Pelanggan::find($id);
            $pelanggan->nama = $request->input('nama');
            $pelanggan->no_telp = $request->input('no_telp');
            if($pelanggan->save()){
                $request->session()->flash('sukses', 'Data Berhasil Dimutakhirkan!');
                return redirect('/master/admin/pembeli');
            }
        }
    }

    public function hapus_admin_pelanggan(Request $request)
    {
        $id = $request->input('id');

        $pelanggan = Pelanggan::find($id);
        if($pelanggan->delete()){
            $request->session()->flash('sukses', 'Data Berhasil Dimutakhirkan!');
            return json_encode(['sukses']);
        }

    }

    public function index_supplier()
    {
        $data_supplier = Supplier::all();
        return view('master.supplier.index', ['data_supplier'=>$data_supplier]);
    }

    public function tambah_supplier()
    {

        return view('master.supplier.tambah');
    }

    public function update_supplier($id)
    {
        $supplier = Supplier::find($id);

        return view('master.supplier.update', ['supplier'=>$supplier]);
    }

    public function simpan_supplier(SupplierValidation $request)
    {
        $id = $request->input('id');
        if($id == null || $id == '')
        {
            $supplier = new Supplier();
            $supplier->kode = $request->input('kode');
            $supplier->nama_supplier = $request->input('nama');
            $supplier->no_telp = $request->input('no_telp');
            $supplier->alamat = $request->input('alamat');
            if($supplier->save()){
                $request->session()->flash('sukses', 'Data Supplier Berhasil Ditambahkan!');
                return redirect('/master/supplier');
            }
        }else{
            $supplier = Supplier::find($id);
            $supplier->nama_supplier = $request->input('nama');
            $supplier->no_telp = $request->input('no_telp');
            $supplier->alamat = $request->input('alamat');
            if($supplier->save()){
                $request->session()->flash('sukses', 'Data Supplier Berhasil Dimutakhirkan!');
                return redirect('/master/supplier');
            }
        }
    }

    public function hapus_supplier(Request $request)
    {
        $id = $request->input('id');
        $supplier = Supplier::find($id);
        if($supplier->delete()){
            $request->session()->flash('error', 'Data Supplier Berhasil Dihapus!');
            return json_encode(['sukses']);
        }
    }

    public function index_member()
    {
      $member = Member::all();
      return view('master.member.index', [
          'data_member'=>$member,
      ]);
    }

    public function tambah_member()
    {
        $no_member = Member::createNoMember();

        return view('master.member.tambah', [
            'kode'=>$no_member
        ]);
    }

    public function simpan_member(MemberValidation $request)
    {
        $id = $request->input('id');

        if($id == '' || $id == null){
            $member = new Member();
            $member->kode = $request->input('kode');
            $member->nama = $request->input('nama');
            $member->no_plat = $request->input('no_plat');
            $member->alamat = $request->input('alamat');
            $member->no_telp = $request->input('no_telp');
            
            if($member->save()){
                $request->session()->flash('sukses', 'Data Member Berhasil Disimpan!');
                return redirect('/master/admin/member');
            } 
        }else{
            $member = Member::find($id);
            $member->kode = $request->input('kode');
            $member->nama = $request->input('nama');
            $member->no_plat = $request->input('no_plat');
            $member->alamat = $request->input('alamat');
            $member->no_telp = $request->input('no_telp');
            
            if($member->save()){
                $request->session()->flash('sukses', 'Data Member Berhasil Dimutakhirkan!');
                return redirect('/master/admin/member');
            } 
        }
        
    }

    public function edit_form_member($id)
    {
        $member = Member::find($id);

        return view('master.member.edit', [
            'member'=>$member
        ]);
    }

    public function hapus_member(Request $request)
    {
        $id = $request->input('id');

        $member = Member::find($id);

        if($member->delete()){
            $request->session()->flash('error', 'Data Member Berhasil Dihapus!');
            return json_encode(['sukses']);
        }
    }

    public function index_client_member()
    {
      $member = Member::all();
      return view('master.client.member.index', [
          'data_member'=>$member,
      ]);
    }

    public function tambah_client_member()
    {
        $no_member = Member::createNoMember();

        return view('master.client.member.tambah', [
            'kode'=>$no_member
        ]);
    }

    public function simpan_client_member(MemberValidation $request)
    {
        $id = $request->input('id');

        if($id == '' || $id == null){
            $member = new Member();
            $member->kode = $request->input('kode');
            $member->nama = $request->input('nama');
            $member->no_plat = $request->input('no_plat');
            $member->alamat = $request->input('alamat');
            $member->no_telp = $request->input('no_telp');
            
            if($member->save()){
                $request->session()->flash('sukses', 'Data Member Berhasil Disimpan!');
                return redirect('/master/client/member');
            } 
        }else{
            $member = Member::find($id);
            $member->kode = $request->input('kode');
            $member->nama = $request->input('nama');
            $member->no_plat = $request->input('no_plat');
            $member->alamat = $request->input('alamat');
            $member->no_telp = $request->input('no_telp');
            
            if($member->save()){
                $request->session()->flash('sukses', 'Data Member Berhasil Dimutakhirkan!');
                return redirect('/master/client/member');
            } 
        }
        
    }

    public function edit_client_form_member($id)
    {
        $member = Member::find($id);

        return view('master.client.member.edit', [
            'member'=>$member
        ]);
    }

    public function hapus_client_member(Request $request)
    {
        $id = $request->input('id');

        $member = Member::find($id);

        if($member->delete()){
            $request->session()->flash('error', 'Data Member Berhasil Dihapus!');
            return json_encode(['sukses']);
        }
    }
}
