@extends('layouts.server.main')
@section('content')
    <style>
        .table {
            border-bottom:0px !important;
        }
        .table th, .table td {
            border: 1px !important;
        }
        .fixed-table-container {
            border:0px !important;
        }
    </style>
    <div class="row content-wrap">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Tentang Aplikasi</h3>
                </div>
                <div class="panel-body">
                    <div class="page-header text-center">
                        <div class="row">
                            <div class="col-md-2 col-md-offset-5">
                                <img src="{{url('/img/logo_sttg.png')}}" class="img img-responsive" alt="">
                            </div>
                        </div>
                        <h2>SEKOLAH TINGGI TEKNOLOGI GARUT <br /><small>Alamat : Jl. Mayor Syamsu No. 1, Desa Jayaraga Kec. Tarogong Kidul - Garut</small></h2>

                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table">
                                <tr>
                                    <th>Nama Pembuat</th>
                                    <td>:</td>
                                    <td>{{$author['nama']}}</td>
                                </tr>
                                <tr>
                                    <th>NPM</th>
                                    <td>:</td>
                                    <td>{{$author['npm']}}</td>
                                </tr>
                                <tr>
                                    <th>Dosen Pembimbing</th>
                                    <td>:</td>
                                    <td>{{$author['dosen']}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <img src="{{url('/img/profile.jpg')}}" class="img img-responsive img-thumbnail" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection