<?php

namespace App\Http\Controllers;

use App\CompanyProfile;
use Illuminate\Http\Request;
use App\Barang;
use App\PrintLaporan;
use Illuminate\Support\Facades\DB;
use App\Penjualan;
use App\Pembelian;
use App\DetilePenjualan;
use App\DetilePembelian;
use App\Member;
class LaporanController extends Controller
{
    public function index_stok(Request $request){
        $data_barang = Barang::all();

        return view('laporan.stok.index', ['data_barang'=>$data_barang]);

    }

    function Footer($pdf)
    {
        // Go to 1.5 cm from bottom
        $pdf->SetY(190);
        // Select Arial italic 8
        $pdf->SetFont('Arial','I',8);
        // Print centered page number
        $pdf->Cell(0,8,'Page '.$pdf->PageNo(),0,0,'C');
    }
    public function print_page(){
        $pdf = new PrintLaporan();
        $company = CompanyProfile::find(1);
        $pdf->AddPage("L");
        $pdf->SetFont('Arial','B',20);

        $pdf->Cell(0,8,$company->nama_toko,0,1,"C");
        $pdf->SetFont("Times","I","8");
        $pdf->Cell(0,5,$company->alamat,0,1,"C");
        $pdf->SetLineWidth(1);
        $pdf->Line(10,26,283,26);
        $pdf->SetLineWidth(0);
        $pdf->Line(10,27,283,27);

        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(0,10,"Rekapitulasi Data Stok Barang",0,"","C");
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont("Arial","",10);
        $pdf->cell(220);
        $pdf->cell(0, 8, "Per Tanggal : ".date('d-m-y'), 0, "", "R");
        $pdf->Ln();
        $pdf->SetFont('Arial','B',12);
        $pdf->cell(20,8,"No",1,"","C");
        $pdf->cell(45,8,"Kode",1,"","C");
        $pdf->cell(80,8,"Nama Barang",1,"","C");
        $pdf->cell(35,8,"Harga Beli",1,"","C");
        $pdf->cell(35,8,"Harga Jual",1,"","C");
        $pdf->cell(20,8,"Stok",1,"","C");
        $pdf->cell(40,8,"Keterangan",1,"","C");
        $pdf->Ln();
        $pdf->SetFont("Arial","",10);
        $data_barang=Barang::all();
        $i = 0;
        foreach($data_barang as $barang){
            $pdf->Cell(20,7,$i+1,1,"","C");
            $pdf->Cell(45,7,$barang->kode,1,"","C");
            $pdf->Cell(80,7,$barang->nama_barang,1,"","L");
            $pdf->Cell(35,7,"Rp. ".number_format($barang->harga_beli).",-",1,"","R");
            $pdf->Cell(35,7,"Rp. ".number_format($barang->harga_jual).",-",1,"","R");
            $pdf->cell(20,7,$barang->stok_barang,1,"","C");
            $pdf->cell(40,7,$barang->keterangan,1,"","C");
            $pdf->Ln();
            $i++;
        }
        $pdf->aliasNbPages();

        $pdf->Output();
        exit;
    }

    public function print_penjualan_page($tanggal){
        $pdf = new PrintLaporan();
        $company = CompanyProfile::find(1);
        $pdf->AddPage("L");
        $pdf->SetFont('Arial','B',20);

        $pdf->Cell(0,8,$company->nama_toko,0,1,"C");
        $pdf->SetFont("Times","I","8");
        $pdf->Cell(0,5,$company->alamat,0,1,"C");
        $pdf->SetLineWidth(1);
        $pdf->Line(10,26,283,26);
        $pdf->SetLineWidth(0);
        $pdf->Line(10,27,283,27);

        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(0,10,"Laporan Penjualan Barang",0,"","C");
        $pdf->SetFont('Arial','B',12);
        $pdf->Ln();
        $pdf->cell(0, 8, "Tanggal : ".date('d-m-y', strtotime($tanggal)), 0, "", "C");

        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFillColor(192);
        $pdf->SetFont('Arial','B',12);
        $pdf->SetFillColor(192);
        $pdf->cell(20,10,"No",1,"","C", 1);
        $pdf->cell(35,10,"Kode",1,"","C", 1);
        $pdf->cell(60,10,"Nama Barang",1,"","C", 1);
        $pdf->cell(30,10,"Harga Jual",1,"","C", 1);
        $pdf->cell(30,10,"Banyak",1,"","C", 1);
        $pdf->cell(20,10,"Qty (A)",1,"","C", 1);
        $pdf->cell(20,10,"Qty (AK)",1,"","C", 1);
        $pdf->cell(25,10,"disc",1,"","C", 1);
        $pdf->cell(35,10,"Sub Total",1,"","C", 1);
        $pdf->Ln();
        $pdf->SetFont("Arial","B",10);
        $data_penjualan = Penjualan::where("tanggal_jual", "=", $tanggal)->get();
        $total = 0;
        $total_sp = 0;
        foreach($data_penjualan as $penjualan){
            $pdf->SetFont("Arial","B",10);
            $pdf->Cell(20,7,"@",1,"","C", 1);
            // @if($penjualan->transaksi_member != null)
            //     <td align="center">{{$penjualan->transaksi_member->member->nama}}</td>
            // @else
            //     @if($penjualan->pelanggan != null)
            //         <td align="center">{{$penjualan->pelanggan->no_plat}}</td>
            //     @else
            //         <td align="center" class="bg-warning">Tidak Terdaftar</td>
            //     @endif
            // @endif
            $pm = '';
            if($penjualan->transaksi_member != null){
                $pm = $penjualan->transaksi_member->member->nama;
            }else{
                if($penjualan->pelanggan != null){
                    $pm = $penjualan->pelanggan->no_plat;
                }else{
                    $pm = "Tidak Terdaftar Pelanggan/Member";
                }
            }

            $pdf->Cell(255,7," No. Nota :    ".$penjualan->nota."                    Pelanggan/Member :   ".$pm,1,"",false, 1);
            $pdf->Ln();
            $i = 0;
            $total_transaksi = 0;
            $total_transaksi_sp = 0;
            // $pdf->Cell(275,7," Service",1, "",false, 1);
            // $pdf->Ln();
            // $y = 0;
            // foreach ($penjualan->service as $service) {
            //     $pdf->SetFont("Arial","",10);
            //     $pdf->Cell(20,7,$y+1,1,"","C");
            //     if($service->service != null){
            //         $pdf->Cell(95,7,$service->service->kode.' | '.$service->service->nama,1,"","L");
            //     }else{
            //         $pdf->Cell(95,7,"",1,"","L");
            //     }

            //     $pdf->Cell(30,7,"",1,"","R");
            //     $pdf->Cell(30,7,"",1,"","C");
            //     $pdf->cell(20,7,"",1,"","C");
            //     $pdf->cell(20,7,"",1,"","C");
            //     $pdf->cell(25,7,$service->discount,1,"","C");
            //     $pdf->cell(35,7,number_format($service->harga),1,"","R");
            //     $total_transaksi = $total_transaksi+$service->harga;
            //     $pdf->Ln();

            //     $y++;
            // }
            $pdf->SetFont("Arial","B",10);
            $pdf->Cell(275,7," Barang",1, "",false, 1);
            $pdf->Ln();
            foreach ($penjualan->detile as $detile) {
                $pdf->SetFont("Arial","",10);
                $pdf->Cell(20,7,$i+1,1,"","C");
                $pdf->Cell(35,7,$detile->kode_sparepart,1,"","C");
                $pdf->Cell(60,7,$detile->nama_sparepart,1,"","L");
                $pdf->Cell(30,7,"Rp. ".number_format($detile->harga_jual).",-",1,"","R");
                $pdf->Cell(30,7,$detile->jumlah_sp,1,"","C");
                $pdf->cell(20,7,$detile->qty_awal,1,"","C");
                $pdf->cell(20,7,$detile->qty_akhir,1,"","C");
                $pdf->cell(25,7,$detile->discount,1,"","C");
                $pdf->cell(35,7,number_format($detile->sub_total),1,"","R");
                $pdf->Ln();
                $total_transaksi = $total_transaksi+$detile->sub_total;
                $total_transaksi_sp = $total_transaksi_sp + $detile->jumlah_sp;
                $i++;
            }
            $pdf->SetFont("Arial","B",10);
            $pdf->Cell(145,7,"Total Transaksi",1,"","R");
            $pdf->Cell(30,7,number_format($total_transaksi_sp),1,"","C");
            $pdf->Cell(65,7,"Sub Total Transaksi",1,"","R");
            $pdf->Cell(35,7,number_format($total_transaksi),1,"","R");
            $total = $total + $total_transaksi;
            $total_sp = $total_sp + $total_transaksi_sp;
            $pdf->Ln();
        }
        $pdf->SetFont("Arial","B",10);
        $pdf->Cell(145,7,"Total",1,"","R", 1);
        $pdf->Cell(30,7,number_format($total_sp),1,"","C", 1);
        $pdf->Cell(65,7,"Total Transaksi",1,"","R", 1);
        $pdf->Cell(35,7,number_format($total),1,"","R", 1);
        // foreach($data_barang as $barang){
        //     $pdf->Cell(20,7,$i+1,1,"","C");
        //     $pdf->Cell(45,7,$barang->kode,1,"","C");
        //     $pdf->Cell(80,7,$barang->nama_barang,1,"","L");
        //     $pdf->Cell(35,7,"Rp. ".number_format($barang->harga_beli).",-",1,"","R");
        //     $pdf->Cell(35,7,"Rp. ".number_format($barang->harga_jual).",-",1,"","R");
        //     $pdf->cell(20,7,$barang->stok_barang,1,"","C");
        //     $pdf->cell(40,7,$barang->keterangan,1,"","C");
        //     $pdf->Ln();
        //     $i++;
        // }
        $pdf->aliasNbPages();

        $pdf->Output();
        exit;
    }

    public function laporan_penjualan_tanggal(Request $request)
    {
        $tanggal = $request->input('tanggal');

        $this->print_penjualan_page($tanggal);
    }

    public function index_penjualan(Request $request)
    {
        $tanggal = $request->input('tanggal');

        if($tanggal != null || $tanggal != ''){
            $data_barang= Barang::all();
            $tanggal = date('Y-m-d', strtotime($tanggal));
            $data_detile = new DetilePenjualan();
            $data_penjualan = Penjualan::where("tanggal_jual", "=", $tanggal);
            $data_pembelian = Pembelian::where("tanggal", "=", $tanggal);
            $data_detile_pembelian = new DetilePembelian();
            return view('laporan.penjualan.hasil', [
                                    'tanggal'=>$tanggal,
                                    'data_barang'=>$data_barang,
                                    'data_penjualan'=>$data_penjualan,
                                    'data_detile'=>$data_detile,
                                    'data_detile_pembelian'=>$data_detile_pembelian,
                                    'data_pembelian'=>$data_pembelian,

                                    ]);
        }else{
            return view('laporan.penjualan.index');
        }
    }

    public function index_riwayat_tm(Request $request)
    {
        $member = $request->input('member');
        if($member != null || $member != ''){
            $data_member = Member::find($member);
            $transaksi = $data_member->transaksi;

            return view('laporan.penjualan.hasil_riwayat_tm', [
                'data_member'=>$data_member,
                'data_transaksi'=>$transaksi
            ]);
        }else{
            $data_member = Member::all();
            return view('laporan.penjualan.riwayat_tm', [
                'data_member'=>$data_member
            ]);
        }


    }

    public function index_pembelian(Request $request)
    {
        $tanggal = $request->input('tanggal');

        if($tanggal != null || $tanggal != ''){

            $tanggal = date('Y-m-d', strtotime($tanggal));
            $data_pembelian = Pembelian::where(DB::raw('EXTRACT(MONTH from tanggal)'), "=", date('m', strtotime($tanggal)));
            return view('laporan.pembelian.hasil', [
                                    'tanggal'=>$tanggal,
                                    'data_pembelian'=>$data_pembelian,

                                    ]);
        }else{
            return view('laporan.pembelian.index');
        }
    }

    public function print_pembelian_page($tanggal){
        $pdf = new PrintLaporan();
        $company = CompanyProfile::find(1);
        $pdf->AddPage("L");
        $pdf->SetFont('Arial','B',20);

        $pdf->Cell(0,8,$company->nama_toko,0,1,"C");
        $pdf->SetFont("Times","I","8");
        $pdf->Cell(0,5,$company->alamat,0,1,"C");
        $pdf->SetLineWidth(1);
        $pdf->Line(10,26,283,26);
        $pdf->SetLineWidth(0);
        $pdf->Line(10,27,283,27);

        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(0,10,"Laporan Pembelian Detile Barang",0,"","C");
        $pdf->SetFont('Arial','B',12);
        $pdf->Ln();
        $bulan = "";
        switch (date('m', strtotime($tanggal))) {
            case 1:
                $bulan = "Januari";
                break;
            case 2:
                $bulan = "Februari";
                break;
            case 3:
                $bulan = "Maret";
                break;
            case 4:
                $bulan = "April";
                break;
            case 5:
                $bulan = "Mei";
                break;
            case 6:
                $bulan = "Juni";
                break;
            case 7:
                $bulan = "Juli";
                break;
            case 8:
                $bulan = "Agustus";
                break;
            case 9:
                $bulan = "September";
                break;
            case 10:
                $bulan = "Oktober";
                break;
            case 11:
                $bulan = "November";
                break;
            case 12:
                $bulan = "Desember";
                break;

            default:
                $bulan = '';
                break;
        }
        $pdf->cell(0, 8, "Bulan : ".$bulan, 0, "", "C");

        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFillColor(192);
        $pdf->SetFont('Arial','B',12);
        $pdf->SetFillColor(192);
        $pdf->cell(20,10,"No",1,"","C", 1);
        $pdf->cell(35,10,"Kode",1,"","C", 1);
        $pdf->cell(85,10,"Nama Barang",1,"","C", 1);
        $pdf->cell(30,10,"Harga Jual",1,"","C", 1);
        $pdf->cell(30,10,"Banyak",1,"","C", 1);
        $pdf->cell(20,10,"Qty (A)",1,"","C", 1);
        $pdf->cell(20,10,"Qty (AK)",1,"","C", 1);
        $pdf->cell(35,10,"Sub Total",1,"","C", 1);
        $pdf->Ln();
        $pdf->SetFont("Arial","B",10);
        $data_pembelian = Pembelian::where(DB::raw('EXTRACT(MONTH from tanggal)'), "=", date('m',strtotime($tanggal)))->get();
        $total = 0;
        $total_sp = 0;
        foreach($data_pembelian as $pembelian){
            $pdf->SetFont("Arial","B",10);
            $pdf->Cell(20,7,"@",1,"","C", 1);
            // @if($penjualan->transaksi_member != null)
            //     <td align="center">{{$penjualan->transaksi_member->member->nama}}</td>
            // @else
            //     @if($penjualan->pelanggan != null)
            //         <td align="center">{{$penjualan->pelanggan->no_plat}}</td>
            //     @else
            //         <td align="center" class="bg-warning">Tidak Terdaftar</td>
            //     @endif
            // @endif
            $supp = '';
            $pembelian->supplier != null ? $supp = $pembelian->supplier->nama_supplier : $supp="";
            $pdf->Cell(255,7," SUPPLIER :    ".$supp,1,"",false, 1);
            $pdf->Ln();
            $i = 0;
            $total_transaksi = 0;
            $total_transaksi_sp = 0;
            foreach ($pembelian->detile as $detile) {
                $pdf->SetFont("Arial","",10);
                $pdf->Cell(20,7,$i+1,1,"","C");
                $pdf->Cell(35,7,$detile->barang != null ? $detile->barang->kode : "",1,"","C");
                $pdf->Cell(85,7,$detile->barang != null ? $detile->barang->nama_barang : "",1,"","L");
                $pdf->Cell(30,7,"Rp. ".number_format($detile->harga_beli).",-",1,"","R");
                $pdf->Cell(30,7,$detile->jumlah_sp,1,"","C");
                $pdf->cell(20,7,$detile->qty_awal,1,"","C");
                $pdf->cell(20,7,$detile->qty_akhir,1,"","C");
                $pdf->cell(35,7,number_format($detile->sub_total),1,"","R");
                $pdf->Ln();
                $total_transaksi = $total_transaksi+$detile->sub_total;
                $total_transaksi_sp = $total_transaksi_sp + $detile->jumlah_sp;
                $i++;
            }
            $pdf->SetFont("Arial","B",10);
            $pdf->Cell(170,7,"Total Transaksi",1,"","R");
            $pdf->Cell(30,7,number_format($total_transaksi_sp),1,"","C");
            $pdf->Cell(40,7,"Sub Total Transaksi",1,"","R");
            $pdf->Cell(35,7,number_format($total_transaksi),1,"","R");
            $total = $total + $total_transaksi;
            $total_sp = $total_sp + $total_transaksi_sp;
            $pdf->Ln();
        }
        $pdf->SetFont("Arial","B",10);
        $pdf->Cell(170,7,"Total",1,"","R", 1);
        $pdf->Cell(30,7,number_format($total_sp),1,"","C", 1);
        $pdf->Cell(40,7,"Total Transaksi",1,"","R", 1);
        $pdf->Cell(35,7,number_format($total),1,"","R", 1);
        // foreach($data_barang as $barang){
        //     $pdf->Cell(20,7,$i+1,1,"","C");
        //     $pdf->Cell(45,7,$barang->kode,1,"","C");
        //     $pdf->Cell(80,7,$barang->nama_barang,1,"","L");
        //     $pdf->Cell(35,7,"Rp. ".number_format($barang->harga_beli).",-",1,"","R");
        //     $pdf->Cell(35,7,"Rp. ".number_format($barang->harga_jual).",-",1,"","R");
        //     $pdf->cell(20,7,$barang->stok_barang,1,"","C");
        //     $pdf->cell(40,7,$barang->keterangan,1,"","C");
        //     $pdf->Ln();
        //     $i++;
        // }
        $pdf->aliasNbPages();

        $pdf->Output();
        exit;
    }

    public function laporan_pembelian_tanggal(Request $request)
    {
        $tanggal = $request->input('tanggal');

        $this->print_pembelian_page($tanggal);
    }

    public function index_penjualan_barang(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        if($bulan != null || $bulan != ''){
            //$data_barang= Barang::all();
            $data_penjualan = Penjualan::where(DB::raw('extract(month from tanggal_jual)'), '=', $bulan)->get();

            return view('laporan.penjualan_barang.hasil', [
                                    'bulan'=>$bulan,
                                    'tahun'=>$tahun,
                                    'data_penjualan'=>$data_penjualan
                                    ]);
        }else{
            return view('laporan.penjualan_barang.index');
        }
    }


    public function detile_penjualan_barang(Request $request){

        $barang = Barang::find($request->input('id'));
        $bulan = $request->input('bulan');
        $data_penjualan = $barang->getDataPenjualan($request->input('id'), $bulan);


        return $data_penjualan;
    }
}
