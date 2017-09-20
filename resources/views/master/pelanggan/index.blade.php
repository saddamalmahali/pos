@extends('layouts.client.main')
@section('content')
    <div class="page-header">
        <h1>Data Pelanggan</h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/home_client')}}">Dasboard</a></li>
            <li class="active">Index</li>
        </ol>
    </div>

    <div class="content-wrap">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Data Pembeli</h3>
                    </div>
                    <form action="{{url('/master/pembeli/simpan')}}" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="id">
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="no_plat">Nama Pembeli</label>
                                <input type="text" class="form-control" name="no_plat" required placeholder="Nama Pembeli">
                            </div>
                            <div class="form-group">
                                <label for="no_telp">No Telp/HP</label>
                                <input type="text" class="form-control" name="no_telp" required placeholder="Nomor Telepon / HP">
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
                        <h3 class="panel-title">List Data Pelanggan</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover table-dataTable">
                            <thead>
                                <tr>
                                    <th width="10%" style="text-align:center;">#</th>
                                    <th style="text-align:center;">Kode Pembeli</th>
                                    <th style="text-align:center;">Nama Pembeli</th>
                                    <th style="text-align:center;">No Telp</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data_pelanggan as $pelanggan)
                                    <tr>
                                        <td align="center">
                                            <input type="radio" id="{{$pelanggan}}" name="radio">
                                            
                                        </td>
                                        <td align="center">{{$pelanggan->kode_pelanggan}}</td>
                                        <td align="center">{{$pelanggan->no_plat}}</td>
                                        <td align="center">{{$pelanggan->no_telp}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" align="center">Tidak Ada Data</td>
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
            $('select[name="id_tipe_motor"]').val(data1.id_tipe_motor);
            $('input[name="no_plat"]').val(data1.no_plat);
            $('input[name="no_telp"]').val(data1.no_telp);
        }
        var clear_form = function()
        {
            $('input[name="id"]').val('');
            $('select[name="id_tipe_motor"]').val('');
            $('input[name="no_plat"]').val('');
            $('input[name="no_telp"]').val('');
        }

        $('.btn-clear-data').on('click', function(e){
            e.preventDefault();
            $('input[name="radio"]').prop('checked', false);
            clear_form();
        });

        $('input[name="radio"]').on('click', function(e){
            init_form($(this).attr('id'));
        });
        jQuery(document).ready(function () {
            DataTableBasic.init();
        });
    </script>
@endsection
