@extends('layouts.server.main')

@section('content')
    <div class="page-header">
        <h1>Data Supplier</h1>
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
                        <h3 class="panel-title"><i class="fa fa-gear"></i>&nbsp;&nbsp;&nbsp;List Data Supplier</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row" style="margin-bottom:20px;">
                            <div class="col-md-6">
                                
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{url('/master/supplier/tambah')}}" class="btn btn-primary" style="width:100px;"><i class="fa fa-plus"></i>&nbsp;Tambah</a>

                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-dataTable" id="data_supplier">
                                <thead class="warning">                            
                                    <tr>
                                        <th class="text-center" width="10%">No</th>
                                        <th class="text-center" width="10%">Kode Supplier</th>
                                        <th class="text-center" width="20%">Nama Supplier</th>                                        
                                        <th class="text-center" width="30%">Alamat</th>
                                        <th class="text-center" width="15%">kontak</th>
                                        <th width="15%" class="text-center" width="15%">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @forelse ($data_supplier as $supplier)
                                        <tr>
                                            <td align="center">{{$i+1}}</td>
                                            <td align="center">{{$supplier->kode}}</td>
                                            <td align="center">{{$supplier->nama_supplier}}</td>
                                            <td align="center">{{$supplier->alamat}}</td>
                                            <td align="center">{{$supplier->no_telp}}</td>
                                            <td align="center">
                                                <a href="{{url('/master/supplier/update').'/'.$supplier->id}}" class="btn btn-info btn-xs btn-rounded">Update</a> &nbsp;
                                                <a href="" id="{{$supplier->id}}" class="btn btn-primary btn-xs btn-rounded btn-hapus">Hapus</a>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    @empty
                                        
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
    var url_back = "{{url('/master/supplier')}}";
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
                    url : '/master/supplier/hapus',
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