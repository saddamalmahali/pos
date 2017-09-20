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
                    <a href="{{url('/admin/transaksi/pembelian/tambah')}}" class="btn btn-success" style="width:100px;"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Tambah</a>
                </div>
            </div>
        </div>
    </div>
    <div class="content-wrap">
       
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-book"></i>&nbsp;&nbsp;&nbsp;List Data Pembelian</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-dataTable">
                                        <thead>
                                            <tr>
                                                <th width="5%" style="text-align : center;">No</th>
                                                <th style="text-align : center;">No Pembelian</th>
                                                <th style="text-align : center;">Supplier</th>
                                                <th style="text-align : center;">Tanggal Jual</th>
                                                <th style="text-align : center;">Total SP</th>
                                                
                                                <th style="text-align : center;">Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0; ?>
                                            @forelse ($data_pembelian as $pembelian)
                                                <tr>
                                                    <td align="center">{{$i+1}}</td>
                                                    <td align="center">{{$pembelian->kode}}</td>
                                                    <td align="center">{{$pembelian->supplier->nama_supplier}}</td>
                                                    <td align="center">{{date('d-m-Y', strtotime($pembelian->tanggal))}}</td>
                                                    <td align="center">{{$pembelian->total_sp}}</td>
                                                    <td align="center">
                                                        <a class="btn btn-info btn-rounded btn-print btn-xs" id="{{$pembelian->id}}"><i class="fa fa-print"></i></a>
                                                        <a href="{{url('/admin/transaksi/pembelian/view').'/'.$pembelian->id}}" class="btn btn-success btn-rounded btn-xs"><i class="fa fa-search"></i></a> 
                                                        <a id="{{$pembelian->id}}" class="btn btn-primary btn-rounded btn-xs btn-hapus"><i class="fa fa-trash"></i></a> 

                                                    </td>
                                                </tr>
                                                <?php $i++; ?>
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
        var jenis = "{{session()->has('sukses') == 1 ? 'info' : 'error'}}";
        console.log(jenis);
        var message = "{{session()->has('sukses') == 1 ? session()->get('sukses') : session()->get('error')}}";
        console.log(message);
        if(message != ""){
            if(jenis == 'info'){
                $.toast({
                    heading: 'Sukses!',
                    text: message,
                    showHideTransition: 'slide',
                    icon: 'info',
                    hideAfter: 3000,
                    position: 'top-right',
                    bgColor: '#00C9E6'
                });
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var url_back = "{{url('/admin/transaksi/pembelian')}}";
        $(document).on('click', '.btn-hapus', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            if(confirm('Apakah anda yakin ingin menghapus data?')){
                 $.ajax({
                    url : '/admin/transaksi/pembelian/hapus',
                    type : 'post',
                    data : {id : id},
                    dataType : 'json',
                    success : function(data){
                        if(data == 'sukses'){
                            window.location.replace(url_back);
                        }
                    }

                });
               
            }
        });

        jQuery(document).ready(function () {
            DataTableBasic.init();
        });
        function printPage(url){
            window.open(url, "", "width=800,height=600", false);
        }
        $('.btn-print').on('click', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{url('/admin/services/print/nota_pembelian/').'/'}}"+id;
            
            printPage(url);
        });
    </script>
@endsection