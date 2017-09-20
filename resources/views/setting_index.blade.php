@extends('layouts.server.main')

@section('content')
    <div class="page-header">
        <h1>Setting Toko</h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/home')}}">Dasboard</a></li>
            <li class="active">index</li>
        </ol>
    </div>
    <div class="content-wrap">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-gear"></i>&nbsp;&nbsp;&nbsp;Setting Toko</h3>
                    </div>
                    <div class="panel-body">
                        <form action="{{url('/admin/setting/simpan')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" value="{{$company->id}}">
                            <div class="form-group {{$errors->has('nama_toko') ?'has-error':''}}">
                                <label for="nama_toko">Nama Toko</label>
                                <input type="text" name="nama_toko" class="form-control" value="{{$company->nama_toko}}" >
                                @if($errors->has('nama_toko'))
                                    <span class="help-block">
                                        <strong>{{$errors->first('nama_toko')}}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('telp') ?'has-error':''}}">
                                <label for="telp">Telp/Hp</label>
                                <input type="text" name="telp" class="form-control" value="{{$company->telp}}" >
                                @if($errors->has('telp'))
                                    <span class="help-block">
                                        <strong>{{$errors->first('telp')}}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('alamat') ?'has-error':''}}">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" id="alamat" rows="3" class="form-control">{{$company->alamat}}</textarea>
                                @if($errors->has('alamat'))
                                    <span class="help-block">
                                        <strong>{{$errors->first('alamat')}}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary btn-sm pull-right" value="Simpan">
                            </div>
                        </form>
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
    </script>
@endsection