@extends('layouts.server.main')
@section('content')
    <div class="page-header">
        <h1>Data Tipe Motor</h1>
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
                        <h3 class="panel-title">Data Tipe</h3>
                    </div>
                    <form action="{{url('/master/tipe_motor/tambah')}}" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="id">
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="kode">Kode Tipe</label>
                                <input type="text" class="form-control" name="kode" placeholder="Kode Tipe Motor">
                            </div>
                            <div class="form-group">
                                <label for="tipe_motor">Nama Tipe</label>
                                <input type="text" class="form-control" name="tipe_motor" placeholder="Nama Tipe">
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
                        <h3 class="panel-title">List Data Tipe</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="10%" style="text-align:center;">#</th>
                                    <th style="text-align:center;">Kode Tipe</th>
                                    <th style="text-align:center;">Nama Tipe</th>
                                    <th style="text-align:center;">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data_tipe as $tipe)
                                    <tr>
                                        <td align="center"><input type="radio" id="{{$tipe}}" name="radio"></td>
                                        <td align="center">{{$tipe->kode}}</td>
                                        <td align="center">{{$tipe->tipe_motor}}</td>
                                        <td align="center">
                                            <a class="btn btn-danger btn-xs btn-rounded btn-hapus" id="{{$tipe->id}}"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="4" align="center">Tidak Ada Data</td>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="text-center">{{$data_tipe->links()}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var jenis = "{{session()->has('sukses') == 1 ? 'info' : 'error'}}";
        
        var message = "{{session()->has('sukses') == 1 ? session()->get('sukses') : session()->get('error')}}";
        
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
            $('input[name="kode"]').val(data1.kode);
            $('input[name="tipe_motor"]').val(data1.tipe_motor);
        }
        var clear_form = function()
        {
            $('input[name="id"]').val('');
            $('input[name="kode"]').val('');
            $('input[name="tipe_motor"]').val('');
        }

        var url_back = "{{url('/master/tipe_motor')}}";
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.btn-clear-data').on('click', function(e){
                e.preventDefault();
                $('input[name="radio"]').prop('checked', false);
                clear_form();
            });
            $('input[name="radio"]').on('click', function(e){
                init_form($(this).attr('id'));
            });
            $(document).on('click', '.btn-hapus', function(e){
                e.preventDefault();
                var id_tipe = $(this).attr('id');
                if(confirm('Apakah anda yakin ingin menghapus data?')){
                    $.ajax({
                        url : '/master/tipe_motor/hapus',
                        type : 'post',
                        data : {id : id_tipe},
                        dataType : 'json',
                        success : function(data){
                            if(data == 'sukses'){
                                window.location.replace(url_back);
                            }
                        }

                    });
                
                }
            });

            
        })
    </script>
@endsection