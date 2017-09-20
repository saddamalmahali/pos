@extends('layouts.server.main')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-xs-6">
                <h1>Stok Barang</h1>
                <ol class="breadcrumb">
                    <li><a href="{{url('/home')}}">Dasboard</a></li>
                    <li class="active">Index</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="content-wrap">
        <div class="row ">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Laporan Stok Barang</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-center">
                                    Laporan Stok Barang <br />
                                    {{\App\CompanyProfile::find(1)->nama_toko}} <br />
                                    <small>Per Tanggal : {{date('d-m-Y')}}</small>

                                </h2>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    <a href="{{url('/admin/laporan/stok/print')}} " target="_blank" style="margin:20px;" class="btn btn-success"><i class="fa fa-print"></i>&nbsp;&nbsp; Print Data</a>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-hover table-dataTable">
                            <thead>
                                <tr>
                                    <th class="text-center" width="30px;">No</th>
                                    <th class="text-center" width="100px;">Kode</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Harga Beli</th>
                                    <th class="text-center">Harga Jual</th>
                                    <th class="text-center">Stok</th>
                                    <th class="text-center">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=0; ?>
                                @forelse ($data_barang as $barang)
                                    <tr>
                                        <td align="center">{{$i+1}}</td>
                                        <td align="center">{{$barang->kode}}</td>
                                        <td>{{$barang->nama_barang}}</td>
                                        <td align="right">Rp. {{number_format($barang->harga_beli)}},-</td>
                                        <td align="right">Rp. {{number_format($barang->harga_jual)}},-</td>
                                        <td align="center">{{$barang->stok_barang}}</td>
                                        <td align="center">{{$barang->Keterangan}}</td>
                                    </tr>
                                    <?php $i++; ?>
                                @empty
                                    <tr>
                                        <td colspan="7" align="center">Tidak Ada Data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function () {
            DataTableBasic.init();
        });
    </script>
@endsection
