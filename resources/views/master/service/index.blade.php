@extends('layouts.server.main')
@section('content')
    <div class="page-header">
        <h1>Data Jenis Service</h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/home')}}">Dasboard</a></li>
            <li class="active">Index</li>
        </ol>
    </div>

    <div class="content-wrap">  
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Data Jenis Service</h3>
                    </div>
                    <form action="{{url('/master/service/simpan')}}" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="id">
                        <div class="panel-body">
                            
                            <div class="form-group">
                                <label for="nama">Nama Jenis</label>
                                <input type="text" class="form-control" name="nama" placeholder="Nama Service">
                            </div>
                            <div class="form-group">
                                <label for="tipe_motor">Harga</label>
                                <input type="number" class="form-control" name="harga" >
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-info btn-sm btn-clear-data" >Bersihkan Untuk Tambah Data</button>
                                </div>
                                <div class="col-md-6">
                                    <div class="pull-right">
                                        <input type="submit" class="btn btn-primary btn-sm" value="Simpan">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="kolom">
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">List Data Jenis Service</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="10%" style="text-align:center;">#</th>
                                    <th style="text-align:center;">Kode Service</th>
                                    <th style="text-align:center;">Nama Service</th>
                                    <th style="text-align:center;">Harga</th>
                                    <th style="text-align:center;">Keterangan</th>
                                    <th style="text-align:center;">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data_service as $service)
                                    <tr>
                                        <td align="center"><input type="radio" id="{{$service}}" name="radio"></td>
                                        <td align="center">{{$service->kode}}</td>
                                        <td align="center">{{$service->nama}}</td>
                                        <td align="center">Rp. {{number_format($service->harga)}},-</td>
                                        <td align="center">{{$service->keterangan}}</td>
                                        <td align="center">
                                            <a id="{{$service->id}}" class="btn btn-primary btn-rounded btn-xs btn-hapus"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" align="center">Tidak Ada Data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="text-center">{{$data_service->links()}}</div>
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
        var init_form = function(data)
        {
            var data1= JSON.parse(data);
            $('input[name="id"]').val(data1.id);
            $('input[name="nama"]').val(data1.nama);
            $('input[name="harga"]').val(data1.harga);
            $('textarea[name="keterangan"]').val(data1.keterangan);
        }
        var clear_form = function()
        {
            $('input[name="id"]').val("");
            $('input[name="nama"]').val("");
            $('input[name="harga"]').val("");
            $('textarea[name="keterangan"]').val("");
        }

        $('input[name="radio"]').on('click', function(e){
            init_form($(this).attr('id'));
        });

        $('.btn-clear-data').on('click', function(e){
            e.preventDefault();
            $('input[name="radio"]').prop('checked', false);
            clear_form();
        });

        var url_back = "{{url('/master/service')}}";

        $(document).on('click', '.btn-hapus', function(e){
                e.preventDefault();
                var id_service = $(this).attr('id');
                if(confirm('Apakah anda yakin ingin menghapus data?')){
                    $.ajax({
                        url : '/master/service/hapus',
                        type : 'post',
                        data : {id : id_service},
                        dataType : 'json',
                        success : function(data){
                            if(data == 'sukses'){
                                window.location.replace(url_back);
                            }
                        }

                    });
                
                }
            });
    </script>
@endsection