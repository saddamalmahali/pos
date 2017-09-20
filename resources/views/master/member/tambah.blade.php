@extends('layouts.server.main')

@section('content')
    <div class="page-header">
        <h1>Tambah Member</h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/home')}}">Dasboard</a></li>
            <li><a href="{{url('/master/admin/member')}}">Data Member</a></li>
            <li class="active">index</li>
        </ol>
    </div>
    <div class="content-wrap">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title text-center">Tambah Data Member</h4>
                    </div>
                    <form action="{{url('/master/admin/member/simpan')}}" method="post">
                        {{csrf_field()}}
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="">Kode Member</label>
                                <input type="text" name="kode" class="form-control" readonly value="{{$kode}}" placeholder="ini kosong">
                            </div>
                            <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                                <label for="">Nama Member</label>
                                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" placeholder="Nama Member">
                                @if ($errors->has('nama'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="">Plat No</label>
                                <input type="text" name="no_plat" class="form-control" placeholder="Contoh : z 100 mk">
                            </div>
                            <div class="form-group{{ $errors->has('no_telp') ? ' has-error' : '' }}">
                                <label for="">No Telp</label>
                                <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp') }}" placeholder="No HP Member Aktif">
                                @if ($errors->has('no_telp'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('no_telp') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="">Alamat</label>
                                <textarea name="alamat" rows="4" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-right">
                                        <input type="submit" class="btn btn-success" value="Simpan">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection