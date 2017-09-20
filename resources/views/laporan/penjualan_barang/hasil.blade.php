@extends('layouts.server.main')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-xs-6">
                <h1>Laporan Penjualan Per Barang</h1>
                <ol class="breadcrumb">
                    <li><a href="{{url('/home')}}">Dasboard</a></li>
                    <li class="active">Index</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="content-wrap">
        <div class="row">
            <div class="col-md-12 ">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-bar-chart"></i> &nbsp;&nbsp;&nbsp; Laporan Transaksi Bulan : {{$bulan}} </h3>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="{{url('/admin/laporan/penjualan/print')}}" onclick="event.preventDefault(); document.getElementById('print_laporan').submit();" class="pull-right btn btn-info" style="margin-top:0px;"><i class="fa fa-print"></i>&nbsp; Print Laporan</a>
                                        <form action="{{url('/admin/laporan/penjualan/print')}}" id="print_laporan" target="_blank" method="post">
                                            {{csrf_field()}}
                                            <input type="hidden" name="bulan" value="{{$bulan}}">

                                        </form>
                                    </div>
                                </div>
                                <h3 class="text-center">Q'La Computer <br/></h3>
                                <h4 class="text-center">Laporan Penjualan</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <?php
                                                use App\DetilePenjualan;
                                                $i =0;
                                                $count_date = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                                                //$number = cal_days_in_month(CAL_GREGORIAN, 8, 2003); // 31
                                            ?>
                                            <table class="table table-bordered table-dataTable">
                                                <thead>
                                                    <tr>
                                                        <th width="5%" class="text-center">No</th>
                                                        <th width="10%"class="text-center">Kode Barang</th>
                                                        <th class="text-center">Nama Barang</th>
                                                        <th width="30%"  class="text-center">Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        for($i=1; $i<=$count_date; $i++){
                                                            $tanggal = date('Y-m-d', strtotime($tahun.'-'.$bulan.'-'.$i));
                                                            $data_jual = DetilePenjualan::getDataBarang($tanggal);
                                                    ?>

                                                    <tr class="bg-info">
                                                        <td colspan="4">Penjualan Barang Tanggal : <?= $i.'-'.$bulan.'-'.$tahun ?></td>
                                                    </tr>
                                                    @if($data_jual->count() > 0)
                                                        <?php $no = 1; ?>
                                                        @foreach($data_jual as $penjualan)
                                                            <tr>
                                                                <td>{{$no}}</td>
                                                                <td>{{$penjualan->kode}}</td>
                                                                <td>{{$penjualan->nama_barang}}</td>
                                                                <td align="center">{{DetilePenjualan::getJumlahBarang($penjualan->kode, $tanggal)}}</td>
                                                            </tr>
                                                            <?php $no++; ?>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="4">Tidak Ada Transaksi Pada Tanggal Ini</td>
                                                        </tr>
                                                    @endif
                                                    <?php } ?>
                                                </tbody>
                                            </table>
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
    <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Data Detile Transaksi Unit Barang</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $.ajaxSetup({
            headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });
        var bulan = {{$bulan}};

        $('.modal_info').on('click', function(e){
            var id_barang = $(this).attr('id');
            $.ajax({
                url : '/admin/laporan/penjualan_barang/detile',
                type : 'post',
                dataType : 'json',
                data : {id : id_barang, bulan: bulan},
                success : function(data){
                    $('.modal-body').html(data);
                    $('#myModal3').modal('show');
                }
            });

        });

        jQuery(document).ready(function () {
            DataTableBasic.init();
        });
    </script>
@endsection
