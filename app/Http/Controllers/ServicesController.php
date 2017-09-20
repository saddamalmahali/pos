<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penjualan;
use App\Pembelian;
use App\TransaksiMember;
class ServicesController extends Controller
{
    public function print_nota_penjualan($id)
    {
        $penjualan = Penjualan::find($id);
        $data_transaksi_member = new TransaksiMember();
        return view('services.print.nota_penjualan', ['penjualan'=>$penjualan, 'data_transaksi_member'=>$data_transaksi_member]);
    }
    public function print_admin_nota_penjualan($id)
    {
        $penjualan = Penjualan::find($id);
        $data_transaksi_member = new TransaksiMember();
        return view('services.admin.print.nota_penjualan', ['penjualan'=>$penjualan, 'data_transaksi_member'=>$data_transaksi_member]);
    }
    public function print_admin_nota_penjualan_langsung(Request $request)
    {
        $id = $request->input('id');
        $penjualan = Penjualan::find($id);
         $data_transaksi_member = new TransaksiMember();
        return response()->json(view()->make('services.admin.print.nota_penjualan', ['penjualan'=>$penjualan, 'data_transaksi_member'=>$data_transaksi_member])->render());
    }

    public function print_admin_nota_pembelian($id){
        $pembelian = Pembelian::find($id);
       
        return view('services.admin.print.nota_pembelian', ['pembelian'=>$pembelian]);
    }
}
