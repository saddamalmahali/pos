@extends('layouts.server.main')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-xs-6">
                <h1>Data Penjualan</h1>
                <ol class="breadcrumb">
                    <li><a href="{{url('/home')}}">Dasboard</a></li>
                    <li class="active">Index</li>
                </ol>
            </div>
            <div class="col-md-6 col-xs-6">
                <div class="pull-right" style="margin-top:20px;">
                    <a href="{{url('/admin/transaksi/penjualan/tambah')}}" class="btn btn-success" style="width:100px;"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Tambah</a>
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
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" id="tanggal" style="margin-bottom:10px;" placeholder="Filter Per Tanggal" value="{{date('d-m-Y')}}" class="form-control">
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-stripped table-dataTable">
                                        <thead>
                                            <tr>
                                                <th style="text-align : center;">Nota</th>
                                                <th style="text-align : center;">Tanggal Jual</th>
                                                <th style="text-align : center;">Total SP</th>
                                                <th style="text-align : center;">Total Penjualan</th>
                                                <th style="text-align : center;">Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $i = 0;
                                            ?>
                                            @forelse ($data_penjualan as $penjualan)
                                                <tr>
                                                    <td align="center">{{$penjualan->nota}}</td>
                                                    <td align="center">{{date('d-m-Y',strtotime($penjualan->tanggal_jual))}}</td>
                                                    <td align="center">{!! 
                                                        $penjualan->detile()->sum('jumlah_sp');
                                                    !!}</td>
                                                    <td align="center">
                                                    {!!$nilai =$penjualan->service()->sum('subtotal')+$penjualan->detile()->sum('sub_total'); number_format($nilai);!!} 
                                                    </td>
                                                    <td align="center">
                                                        <a class="btn btn-info btn-rounded btn-print btn-xs" id="{{$penjualan->id}}"><i class="fa fa-print"></i></a>
                                                        <a href="{{url('/admin/transaksi/penjualan/update/').'/'.$penjualan->id}}" class="btn btn-warning btn-rounded btn-xs"><i class="fa fa-pencil"></i></a>
                                                        <a href="" class="btn btn-danger btn-rounded btn-hapus btn-xs" id="{{$penjualan->id}}"><i class="fa fa-trash"></i></a> &nbsp;
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
        console.log(message);
        if(message != ""){
            if(jenis == 'info'){
                var id_penjualan = "{{session()->get('id')}}";
                var url = "{{url('/admin/services/print/nota_penjualan/').'/'}}"+id_penjualan;
                console.log("Print Page : "+id_penjualan);
                console.log("Url Print : "+url);
                printPage(url);
            }else{
                $.toast({
                    heading: 'Berhasil',
                    text: message,
                    showHideTransition: 'slide',
                    icon: 'error',
                    hideAfter: 3000,
                    position: 'top-right',
                    bgColor: '#FF4859'
                });
            }

        }

        var url_back = "{{url('/admin/transaksi/penjualan')}}";

        $(document).on('click', '.btn-hapus', function(e){
            e.preventDefault();
            var id_jual = $(this).attr('id');
            if(confirm('Apakah anda yakin ingin menghapus data?')){
                $.ajax({
                    url : '/admin/transaksi/penjualan/hapus',
                    type : 'post',
                    data : {id : id_jual},
                    dataType : 'json',
                    success : function(data){
                        if(data == 'sukses'){
                            window.location.replace(url_back);
                        }
                    }

                });
            
            }
        });

        $('.btn-print').on('click', function(e){
            e.preventDefault();
            var id_penjualan = $(this).attr('id');
            var url = "{{url('/admin/services/print/nota_penjualan/').'/'}}"+id_penjualan;
             console.log("Print Page : "+id_penjualan);
                console.log("Url Print : "+url);
            printPage(url);
        });
        jQuery(document).ready(function () {
            DataTableBasic.init();
        });

        $('#tanggal').datepicker({
            format : 'dd-mm-yyyy',
            autoclose : true,
            clearBtn : true,
        });
        
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var tanggal = $('#tanggal').val();

                var tanggal_jual = data[1]; // use data for the age column
        
                if ( (tanggal == tanggal_jual) || tanggal == '' )
                {
                    return true;
                }
                return false;
            }
        );
        
        var table = $('.table-dataTable');
        $('#tanggal').bind('change', function(e){
            
            tabel.draw();

        });

        
    </script>
@endsection