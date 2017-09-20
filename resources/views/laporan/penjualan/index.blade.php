@extends('layouts.server.main')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-xs-6">
                <h1>Laporan Penjualan</h1>
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
                        <h3 class="panel-title"><i class="fa fa-calendar"></i> &nbsp;&nbsp;&nbsp; Masukan Tanggal Transaksi</h3>
                    </div>
                    <form action="{{url('/admin/laporan/penjualan')}}" class='form-horizontal' method="post">
                    <div class="panel-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="bulan" class="col-md-2 col-xs-4 control-label">Tanggal</label>
                            <div class="col-md-10 col-xs-8">
                                <input type="text" name="tanggal" data-autoclose="1" class="form-control date-picker">
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