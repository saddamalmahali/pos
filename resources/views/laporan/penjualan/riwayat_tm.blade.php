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
                        <h3 class="panel-title"><i class="fa fa-calendar"></i> &nbsp;&nbsp;&nbsp; Tentukan Member</h3>
                    </div>
                    <form action="{{url('/admin/laporan/riwayat_transaksi_member')}}" class='form-horizontal' method="post">
                    <div class="panel-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="bulan" class="col-md-4 col-xs-6 control-label">Pilih Member</label>
                            <div class="col-md-8 col-xs-6">
                                <select name="member" required id="member" class="form-control select2Search">
                                    <option value="" disabled selected>Pilih Member</option>
                                    @forelse ($data_member as $member)
                                        <option value="{{$member->id}}">{{$member->kode.' | '.$member->nama}}</option>
                                    @empty
                                        
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    <input type="submit" class="btn btn-primary btn-sm" value="Tampilkan">
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