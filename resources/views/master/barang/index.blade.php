@extends('layouts.server.main')

@section('content')
    <div class="page-header">
        <h1>Data Barang</h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/home')}}">Dasboard</a></li>
            <li class="active">index</li>
        </ol>
    </div>
    <div class="content-wrap">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-gear"></i>&nbsp;&nbsp;&nbsp;Data Barang</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row" style="margin-bottom:20px;">
                            <div class="col-md-6">
                                
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{url('/master/barang/tambah')}}" class="btn btn-primary" style="width:100px;"><i class="fa fa-plus"></i>&nbsp;Tambah</a>

                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-dataTable" id="data_barang">
                                <thead class="warning">                            
                                    <tr>
                                        <th class="text-center" width="10%">Kode Barang</th>
                                        <th class="text-center" width="40%">Nama</th>
                                        <th class="text-center">Kode Tipe</th>
                                        <th class="text-center">Stok</th>
                                        <th width="15%" class="text-center">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @forelse ($data_barang as $barang)
                                        <tr>
                                            
                                            <td align="center" style="vertical-align:middle;">{{$barang->kode}}</td>
                                            <td style="vertical-align:middle;">{{$barang->nama_barang}}</td>
                                            <td align="center" style="vertical-align:middle;">{{$barang->kode_tipe_motor}}</td>
                                            <td align="center" style="vertical-align:middle;">{{$barang->stok_barang}}</td>
                                            <td align="center" style="vertical-align:middle;">
                                                <a href="{{url('/master/barang/edit').'/'.$barang->id}}" class="btn btn-warning btn-xs btn-rounded" ><i class="fa fa-pencil"></i></a>
                                                <a  class="btn btn-danger btn-xs btn-rounded btn-hapus" id="{{$barang->id}}" ><i class="fa fa-trash"></i></a>
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
    var url_back = "{{url('/master/barang')}}";
    $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $(document).on('click', '.btn-hapus', function(e){
            e.preventDefault();
            var id_barang = $(this).attr('id');
            if(confirm('Apakah anda yakin ingin menghapus data?')){
                 $.ajax({
                    url : '/master/barang/hapus',
                    type : 'post',
                    data : {id : id_barang},
                    dataType : 'json',
                    success : function(data){
                        if(data == 'sukses'){
                            window.location.replace(url_back);
                        }
                    }

                });
               
            }
        });
    });

    jQuery(document).ready(function () {
        DataTableBasic.init();
    });
    </script>
@endsection