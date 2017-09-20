@extends('layouts.server.main')
@section('content')
    <div class="page-header">
        <h1>Data Supplier</h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/home')}}">Dasboard</a></li>
            <li><a href="{{url('/master/supplier')}}">Data Supplier</a></li>
            <li class="active">Tambah</li>
        </ol>
    </div>
    <div class="content-wrap">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">Tambah Supplier</h4>
                    </div>
                    <form action="{{url('/master/supplier/simpan')}}" method="post">
                    {{csrf_field()}}
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="form-group{{ $errors->has('kode') ? ' has-error' : '' }}">
                                    <label for="kode">Kode Supplier</label>
                                    <input type="text" name="kode" class="form-control" style="width:50%;" value="{{ old('kode') }}" placeholder="Kode Supplier" >
                                    @if ($errors->has('kode'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('kode') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                                    <label for="nama">Nama Supplier</label>
                                    <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" placeholder="Nama Supplier">
                                    @if ($errors->has('nama'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nama') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('no_telp') ? ' has-error' : '' }}">
                                    <label for="no_telp">No Telp</label>
                                    <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp') }}" placeholder="No Telp Supplier">
                                    @if ($errors->has('no_telp'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('no_telp') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-right">
                                        <a href="{{url('/master/supplier')}}" style="width:100px;" class="btn btn-info btn-sm">Batal</a>
                                        <input type="submit" class="btn btn-primary btn-sm" style="width:100px;" value="Simpan">
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