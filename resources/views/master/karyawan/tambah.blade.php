@extends('layouts.server.main')
@section('content')
    <div class="page-header">
        <h1>Data Karyawan</h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/home')}}">Dasboard</a></li>
            <li><a href="{{url('/master/karyawan')}}">Data Karyawan</a></li>
            <li class="active">Tambah</li>
        </ol>
    </div>
    <div class="content-wrap">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">Tambah Karyawan</h4>
                    </div>
                    <form action="{{url('/master/karyawan/simpan')}}" enctype="multipart/form-data" method="post">
                    {{csrf_field()}}
                    <div class="panel-body">
                        <div class="content-wrap">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_karyawan">Nomor Karyawan</label>
                                        <input type="text" name="no_karyawan" class="form-control" readonly value="{{ $id_karyawan }}" placeholder="Masukan Nama Lengkap"  autofocus/>
                                        
                                    </div>
                                    <div class="form-group{{ $errors->has('nama_lengkap') ? ' has-error' : '' }}">
                                        <label for="nama_lengkap">Nama Lengkap</label>
                                        <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" placeholder="Masukan Nama Lengkap"  autofocus/>
                                        @if ($errors->has('nama_lengkap'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('nama_lengkap') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('jenis_kelamin') ? ' has-error' : '' }}">
                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" id="jenis_kelamin" class='form-control'  autofocus>
                                            <option value="" selected disabled>Pilih Jenis Kelamin</option>
                                            <option value="l" {{old('jenis_kelamin')=='l' ? 'selected':''}}>Laki-Laki</option>
                                            <option value="p" {{old('jenis_kelamin')=='p' ? 'selected':''}}>Perempuan</option>
                                        </select>
                                        @if ($errors->has('jenis_kelamin'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('jenis_kelamin') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('tempat_lahir') ? ' has-error' : '' }}">
                                        <label for="tempat_lahir">Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" class="form-control" value="{{old('tempat_lahir')}}" placeholder="Masukan Tempat Lahir"  autofocus/>
                                        @if ($errors->has('tempat_lahir'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('tempat_lahir') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('tanggal_lahir') ? ' has-error' : '' }}">
                                        <label for="tanggal_lahir">Tanggal Lahir</label>
                                        <input type="text" name="tanggal_lahir" id="tanggal_lahir" value="{{old('tanggal_lahir')}}" class="form-control" placeholder="Pilih Tanggal Lahir"/>
                                        @if ($errors->has('tanggal_lahir'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('tanggal_lahir') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea name="alamat" id="alamat" rows="6" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="foto">Foto</label>
                                        <input type="file" name="foto" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <div class="mk-trc" data-text="true" data-radius="true">
                                                <input id="kasir" type="checkbox" name="kasir">
                                                <label for="kasir"><i></i> Ingin Jadikan Karyawan sebagai Kasir?</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-login">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" name="username" class="form-control" placeholder="Masukan Username"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" class="form-control" placeholder="Masukan Password"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                                            
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    <a href="{{url('/master/karyawan')}}" style="width:100px;" class="btn btn-info btn-sm">Batal</a>
                                    <input type="submit" style="width:100px;" class="btn btn-primary btn-sm" value="Simpan">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        $(function(){
            $('.form-login').hide();
        });
        $('#tanggal_lahir').datepicker({
            format : 'dd-mm-yyyy',
            autoclose : true
        });
        $('input[name="kasir"]').on('click',function(){
            if($('input[name="kasir"]:checked').val() === "on"){
                $('.form-login').show(1000);
            }else{
                $('.form-login').hide(1000);
            }

        });
    </script>
@endsection