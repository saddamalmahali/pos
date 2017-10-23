@extends('layouts.server.main')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-xs-6">
                <h1>Laporan Transaksi Member</h1>
                <ol class="breadcrumb">
                    <li><a href="{{url('/home')}}">Dasboard</a></li>
                    <li class="active">Index</li>
                </ol>
            </div>
        </div>
    </div>
    
    <div class="content-wrap">
        <div class="row">
            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-user"></i>&nbsp;&nbsp;Data Member</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <tr>
                                <th style="padding-top:5px;padding-bottom:5px;">Kode Member</th>
                                <td style="padding-top:5px;padding-bottom:5px;">:</td>
                                <td style="padding-top:5px;padding-bottom:5px;">{{$data_member->kode}}</td>
                            </tr>
                            <tr>
                                <th style="padding-top:5px;padding-bottom:5px;">Nama Member</th>
                                <td style="padding-top:5px;padding-bottom:5px;">:</td>
                                <td style="padding-top:5px;padding-bottom:5px;">{{$data_member->nama}}</td>
                            </tr>
                            <tr>
                                <th style="padding-top:5px;padding-bottom:5px;">Plat No</th>
                                <td style="padding-top:5px;padding-bottom:5px;">:</td>
                                <td style="padding-top:5px;padding-bottom:5px;">{{$data_member->no_plat}}</td>
                            </tr>
                            <tr>
                                <th style="padding-top:5px;padding-bottom:5px;">No Telp</th>
                                <td style="padding-top:5px;padding-bottom:5px;">:</td>
                                <td style="padding-top:5px;padding-bottom:5px;">{{$data_member->no_telp}}</td>
                            </tr>
                            <tr>
                                <th style="padding-top:5px;padding-bottom:5px; vertical-align:top;" >Alamat</th>
                                <td style="padding-top:5px;padding-bottom:5px;">:</td>
                                <td style="padding-top:5px;padding-bottom:5px;" width="50%">{{$data_member->alamat}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-industry"></i>&nbsp;&nbsp;Data Transaksi Member</h3>

                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="10%" class="text-center">No</th>
                                    <th width="20%" class="text-center">Nota</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Total Brg</th>
                                    <th class="text-center">Jumlah Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=0; $total = 0; $total_sp = 0;?>
                                @forelse ($data_transaksi as $transaksi)
                                    <tr>
                                        <td align="center">{{$i+1}}</td>
                                        <td align="center">{{$transaksi->penjualan->nota}}</td>
                                        <td align="center">{{date('d-m-Y', strtotime($transaksi->penjualan->tanggal_jual))}}</td>
                                        <td align="center">{{$transaksi->penjualan->total_sp}}</td>
                                        <td align="right">{{number_format($transaksi->penjualan->total_harga)}}</td>
                                    </tr>
                                    <?php 
                                        $total = $total+$transaksi->penjualan->total_harga; 
                                        $total_sp = $total_sp+$transaksi->penjualan->total_sp;
                                        $i++; 
                                    ?>
                                @empty
                                    <tr>
                                        <td colspan="5" align="center">Tidak Ada Data Transaksi</td>
                                    </tr>
                                @endforelse
                                @if($data_transaksi != null)
                                    <tr>
                                        <td colspan="4" align="right">Total</td>
                                        <td align="right"><b>{{number_format($total)}}</b></td>
                                    </tr>
                                @endif

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
                                                       