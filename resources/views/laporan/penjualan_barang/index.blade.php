@extends('layouts.server.main')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-xs-6">
                <h1>Laporan Barang Keluar</h1>
                <ol class="breadcrumb">
                    <li><a href="{{url('/home')}}">Dasboard</a></li>
                    <li class="active">Index</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-wrap">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-calendar"></i> &nbsp;&nbsp;&nbsp; Masukan Bulan & Tahun Transaksi</h3>
                    </div>
                    <form action="{{url('/admin/laporan/penjualan_barang')}}" class='form-horizontal' method="post">
                    <div class="panel-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="bulan" class="col-md-2 col-xs-4 control-label">Tanggal</label>
                            <div class="col-md-10 col-xs-8">
                                <select name="bulan" class="form-control" required>
                                    <option value="" disabled selected>Pilih Bulan</option>
                                    <option value="1" {{(int) date('m') == 1 ? 'selected' : ''}}>Januari</option>
                                    <option value="2" {{(int) date('m') == 2 ? 'selected' : ''}}>Februari</option>
                                    <option value="3" {{(int) date('m') == 3 ? 'selected' : ''}}>Maret</option>
                                    <option value="4" {{(int) date('m') == 4 ? 'selected' : ''}}>April</option>
                                    <option value="5" {{(int) date('m') == 5 ? 'selected' : ''}}>Mei</option>
                                    <option value="6" {{(int) date('m') == 6 ? 'selected' : ''}}>Juni</option>
                                    <option value="7" {{(int) date('m') == 7 ? 'selected' : ''}}>Juli</option>
                                    <option value="8" {{(int) date('m') == 8 ? 'selected' : ''}}>Agustus</option>
                                    <option value="9" {{(int) date('m') == 9 ? 'selected' : ''}}>September</option>
                                    <option value="10" {{(int) date('m') == 10 ? 'selected' : ''}}>Oktober</option>
                                    <option value="11" {{(int) date('m') == 11 ? 'selected' : ''}}>November</option>
                                    <option value="12" {{(int) date('m') == 12 ? 'selected' : ''}}>Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tahun" class="col-md-2 col-xs-4 control-label">Tahun</label>
                            <div class="col-md-10 col-xs-8">
                                <input type="text" name="tahun" class="form-control" value="{{date('Y')}}" placeholder="Masukan Tahun, Contoh : '2017'">
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    <input type="submit" class="btn btn-success btn-sm" value="Simpan">
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