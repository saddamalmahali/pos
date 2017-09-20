@extends('layouts.server.main')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-xs-6">
                <h1>Data Pembelian</h1>
                <ol class="breadcrumb">
                    <li><a href="{{url('/home')}}">Dasboard</a></li>
                    <li class="active">Index</li>
                </ol>
            </div>
            <div class="col-md-6 col-xs-6">
                <div class="pull-right" style="margin-top:20px;">
                    <a href="{{url('/admin/transaksi/pembelian')}}" class="btn btn-danger" style="width:150px;"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;Kembali</a>
                    <a href="{{url('/admin/transaksi/pembelian/tambah')}}" class="btn btn-success" style="width:150px;"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Tambah Baru</a>
                </div>
            </div>
        </div>
    </div>
    <div class="content-wrap">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Detile Pembelian : #{{$pembelian->kode}}</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <table class="table">
                                    <tr>
                                        <th colspan="3" class="text-center"><h4>DATA PEMBELIAN</h4></th>
                                    </tr>
                                    <tr>
                                        <th>Kode</th>
                                        <td>:</td>
                                        <td><input type="text" readonly class="form-control" value="{{$pembelian->kode}}"></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal</th>
                                        <td>:</td>
                                        <td><input type="text" readonly class="form-control" value="{{$pembelian->tanggal}}"></td>
                                    </tr>
                                    <tr>
                                        <th>Supplier</th>
                                        <td>:</td>
                                        <td><input type="text" readonly class="form-control" value="{{$pembelian->supplier->nama_supplier}}"></td>
                                    </tr>
                                    <tr>
                                        <th>Memo</th>
                                        <td>:</td>
                                        <td>
                                            <textarea  id=""  rows="4" readonly class="form-control">{{$pembelian->memo}}</textarea>
                                        </td>
                                    </tr>    
                                </table>
                            </div>
                            <div class="col-md-8">
                                <h3 class="text-center">Detile Pembelian</h3>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Barang</th>
                                            <th class="text-center">Harga Jual</th>
                                            <th class="text-center">Banyak</th>
                                            <th class="text-center">Qty Awal</th>
                                            <th class="text-center">Qty Akhir</th>
                                            <th class="text-center">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; ?>
                                        @forelse ($pembelian->detile as $detile)
                                            <tr>
                                                <td align="center">{{$i+1}}</td>
                                                <td align="center">{{$detile->barang != null ? $detile->barang->kode.' | '.$detile->barang->nama_barang : ""}}</td>
                                                <td align="center">Rp. {{number_format($detile->harga_beli)}},-</td>
                                                <td align="center">{{$detile->jumlah_sp}}</td>
                                                <td align="center">{{$detile->qty_awal}}</td>
                                                <td align="center">{{$detile->qty_akhir}}</td>
                                                <td align="right">Rp. {{number_format($detile->sub_total)}},-</td>
                                            </tr>
                                            <?php $i++; ?>
                                        @empty
                                            <tr>
                                                <td></td>
                                            </tr>
                                        @endforelse

                                        @if($pembelian->detile != null)
                                            <tr>
                                                <td colspan="6" align="center"><b>TOTAL</b></td>
                                                <td align="right"><b>Rp. {{number_format($pembelian->detile()->sum('sub_total'))}},-</b></td>
                                            </tr>
                                        @else
                                            
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection