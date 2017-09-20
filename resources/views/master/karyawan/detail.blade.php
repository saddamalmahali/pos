@extends('layouts.server.main')
@section('content')
    <div class="page-header">
        <h1>Data Karyawan : {{$karyawan->kode_karyawan." | ".$karyawan->nama_lengkap}}</h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/home')}}">Dasboard</a></li>
            <li><a href="{{url('/master/karyawan')}}">Data Karyawan</a></li>
            <li class="active">Detail Karyawan</li>
        </ol>
    </div>
    <div class="content-wrap">
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="{{$karyawan->foto =="" ? '/img/blank-user-medium.png':'/'.$karyawan->foto}}" alt="Image" class="img-responsive img-thumbnail">
                                <div class="text-center">
                                    {{$karyawan->kode_karyawan}} | {{$karyawan->nama_lengkap}}
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="fa fa-user"></i>&nbsp;&nbsp;Detile Karyawan</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <label for="kode_karyawan" class="col-md-4 control-label">Kode Karyawan</label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="kode_karyawan" class="form-control text-center" style="width:40%;" readonly value="{{$karyawan->kode_karyawan}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="nama_lengkap" class="col-md-4 control-label">Nama Lengkap</label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="nama_lengkap" class="form-control " readonly value="{{$karyawan->nama_lengkap}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="jenis_kelamin" class="col-md-4 control-label">Jenis Kelamin</label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="jenis_kelamin" class="form-control " style="width:40%;" readonly value="{{$karyawan->jenis_kelamin == 'l' ? 'Laki-Laki' : 'Perempuan'}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tempat_lahir" class="col-md-4 control-label">Tempat Lahir</label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="tempat_lahir" class="form-control " readonly value="{{$karyawan->tempat_lahir}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <label for="tanggal_lahir" class="col-md-4 control-label">Tanggal Lahir</label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="tanggal_lahir" class="form-control" readonly value="{{date('d-m-Y', strtotime($karyawan->tangal_lahir))}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="alamat" class="col-md-4 control-label">Alamat</label>
                                                        <div class="col-md-8">
                                                            <textarea name="alamat" class="form-control"  rows="3" readonly>{{$karyawan->alamat}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection