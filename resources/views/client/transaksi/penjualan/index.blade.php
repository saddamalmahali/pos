@extends('layouts.client.main')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-xs-6">
                <h1>Data Penjualan</h1>
                <ol class="breadcrumb">
                    <li><a href="{{url('/home_client')}}">Dasboard</a></li>
                    <li class="active">Index</li>
                </ol>
            </div>
            <div class="col-md-6 col-xs-6">
                <div class="pull-right" style="margin-top:20px;">
                    <a href="{{url('/transaksi/penjualan/tambah')}}" class="btn btn-success" style="width:100px;"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Tambah</a>
                </div>
            </div>
        </div>
    </div>
    <div class="content-wrap">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-book"></i>&nbsp;&nbsp;&nbsp;Data Penjualan</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-stripped table-dataTable">
                                    <thead>
                                        <tr>
                                            <th width="5%" style="text-align : center;">No</th>
                                            <th style="text-align : center;">Nota</th>
                                            <th style="text-align : center;">Tanggal Jual</th>
                                            <th style="text-align : center;">Total SP</th>
                                            <th style="text-align : center;">Total Penjualan</th>
                                            <th style="text-align : center;">Konfirmasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $i = 0;
                                        ?>
                                        @forelse ($data_penjualan as $penjualan)
                                            <tr>
                                                <td align="center">{{$i+1}}</td>
                                                <td align="center">{{$penjualan->nota}}</td>
                                                <td align="center">{{date('d-m-Y',strtotime($penjualan->tanggal_jual))}}</td>
                                                <td align="center">{!! 
                                                    $penjualan->detile()->sum('jumlah_sp');
                                                !!}</td>
                                                <td align="center">
                                                   {!! $nilai =$penjualan->service()->sum('subtotal')+$penjualan->detile()->sum('sub_total'); number_format($nilai) !!} 
                                                </td>
                                                <td align="center">
                                                    @if($penjualan->pending !=null)
                                                        <a href="{{url('/transaksi/penjualan/konfirmasi_penjualan').'/'.$penjualan->id}}" class="btn btn-info btn-sm">Konfirmasi</a>
                                                    @else
                                                        <span class="label label-success">Transaksi Selesai</span>
                                                    @endif
                                                        
                                                    
                                                </td>
                                            </tr>
                                            <?php $i++ ?>
                                        @empty
                                            <tr>
                                                <td colspan="6" align="center">Tidak Ada Data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function printPage(url){

            window.open(url, "", "width=800,height=600", false);
        }
        var jenis = "{{session()->has('sukses') == 1 ? 'info' : 'error'}}";
        console.log(jenis);
        var message = "{{session()->has('sukses') == 1 ? session()->get('sukses') : session()->get('error')}}";
        var id = "{{ session()->get('id')}}";
        console.log(message);
        if(message != ""){
            if(jenis == 'info'){
                $.toast({
                    heading: 'Berhasil',
                    text: message,
                    showHideTransition: 'slide',
                    icon: 'info',
                    hideAfter: 3000,
                    position: 'top-right',
                    bgColor: '#FF4859'
                });
                if(id != ''){
                    var id_penjualan = "{{session()->get('id')}}";
                    var url = "{{url('/services/print/nota_penjualan').'/'}}"+id_penjualan;
                    console.log("Print Page : "+id_penjualan);
                    console.log("Url Print : "+url);
                    printPage(url);
                }
                
               
            }else{
                $.toast({
                    heading: 'Berhasil',
                    text: message,
                    showHideTransition: 'slide',
                    icon: 'info',
                    hideAfter: 3000,
                    position: 'top-right',
                    bgColor: '#FF4859'
                });
            }

        }

        
        jQuery(document).ready(function () {
            DataTableBasic.init();
        });
    </script>
@endsection