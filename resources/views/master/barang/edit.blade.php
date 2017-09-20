@extends('layouts.server.main')
@section('content')
    <div class="page-header">
        <h1>Data Karyawan</h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/home')}}">Dasboard</a></li>
            <li><a href="{{url('/master/barang')}}">Data Barang</a></li>
            <li class="active">Edit</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title">Edit Jenis Barang</h4>
                </div>
                <form action="{{url('/master/barang/simpan_update')}}" method="post">
                {{csrf_field()}}
                <input type="hidden" name="id" value="{{$barang->id}}">
                    <div class="panel-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kode">Kode Barang</label>
                                <input type="text" name="kode" class="form-control" style="width:50%;" readonly value="{{$barang->kode}}">
                            </div>
                            <div class="form-group{{ $errors->has('nama_barang') ? ' has-error' : '' }}">
                                <label for="nama_barang">Nama Barang</label>
                                <input type="text" name="nama_barang" class="form-control" value="{{ $barang->nama_barang }}" placeholder="Masukan Nama Barang Dengan Spesifikasi">
                                @if ($errors->has('nama_barang'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama_barang') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('kode_tipe_motor') ? ' has-error' : '' }}">
                                <label for="kode_tipe_motor">Kode Tipe</label>
                                <input type="text" name="kode_tipe_motor" class="form-control" value="{{ $barang->kode_tipe_motor }}" placeholder="Kode Tipe Motor">
                                @if ($errors->has('kode_tipe_motor'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('kode_tipe_motor') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="harga_beli">Harga Beli</label>
                                <input type="number" name="harga_beli" class="form-control" placeholder="Harga Saat Pembelian" value="{{$barang->harga_beli}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="harga_jual">Harga Jual</label>
                                <input type="number" name="harga_jual" class="form-control" placeholder="Harga Untuk Penjualan" value="{{$barang->harga_jual}}">
                            </div>
                            <div class="form-group">
                                <label for="stok_barang">Stok Barang</label>
                                <input type="text" name="stok_barang" class="form-control" placeholder="Stok Dapat Dikosongkan" value="{{$barang->stok_barang}}">
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="4">{{$barang->keterangan}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    <a href="{{url('/master/barang')}}" style="width:100px;" class="btn btn-info btn-sm">Batal</a>
                                    <input type="submit" class="btn btn-primary btn-sm" style="width:100px;" value="Simpan">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection