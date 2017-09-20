@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h4 class="panel-title">Selamat Datang Di Sistem Service Information System</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8 info-welcome">
                            <h3 class="text-center ">
                            Sistem Informasi Service
                            </h3>
                            <p>
                                Selamat Datang, Silahkan Login ke Menu Admin atau Karyawan!
                                <br />

                                Sistem Informasi ini masih dalam tahap Pengembangan, mohon maaf apabila masih terdapat bug error
                            </p>
                        </div>
                        <div class="col-md-4">
                            <div class="panel">
                                <div class="panel-body">
                                    <div class="text-center">
                                        <a href="{{url('/login')}}" class="btn btn-success" style="margin-bottom:10px; width: 150px;"><i class="fa fa-user-circle"></i> &nbsp; Login Admin</a> <br />
                                        <a href="{{url('/login_karyawan')}}" class="btn btn-primary" style="margin-bottom:10px; width: 150px;"><i class="fa fa-vcard-o"></i> &nbsp; Login Karyawan</a>
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