@extends('layouts.client.main')
@section('content')
    <div class="page-header">
        <h1>Dashboard <small>Welcome <span class="text-primary">{{auth('karyawan')->user()->nama_lengkap}}</span></small></h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/')}}">Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </div>
    <div class="content-wrap">
        <div class="row">
            <div class="col-md-4 ">        
                <div class="row">
                    <div class="col-md-12">
                        
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-money"></i>&nbsp;&nbsp;&nbsp;Transaksi Hari Ini</h3>
                        </div>
                        <div class="panel-body">
                            
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="15%" style="text-align:center;">No</th>
                                        <th style="text-align:center;">Nota</th>
                                        <th style="text-align:center;" width="30%">Jumlah SP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @forelse ($data['data_penjualan'] as $penjualan)
                                        <tr>
                                            <td align="center">{{$i+1}}</td>
                                            <td align="center"><a href="#">{{$penjualan->nota}}</a></td>
                                            <td align="center">{{$penjualan->total_sp}}</td>
                                        </tr>
                                        <?php $i++; ?>
                                    @empty
                                        <tr>
                                            <td colspan="3" align="center">Tidak Ada Transaksi Penjualan Hari Ini</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Grafik Penjualan</h3>
                        <div class="tools">
                            <a class="btn-link reload" href="javascript:;"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="chaerSales" style="height: 250px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            url : '/home_client/get_data_chart',
            type : 'post',
            dataType : 'json',
            success : function(data){
                //console.log(data);
                createChart(data);
            }
        });
        
        function createChart(data){
            Morris.Line({
                element: 'chaerSales',
                data: data,
                xkey: 'tanggal',
                ykeys: ['data'],
                labels: ['Penjualan'],
                resize: true,
                hideHover: true,
                xLabels: 'day',
                gridTextSize: '10px',
                lineColors: ['#00C9E6', '#FFC017'],
                gridLineColor: '#E5E5E5'
            });
        }
    </script>
@endsection