@extends('layouts.server.main')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-xs-6">
                <h1>Laporan Pembelian</h1>
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
                        <h3 class="panel-title"><i class="fa fa-bar-chart"></i> &nbsp;&nbsp;&nbsp; Laporan Pembelian Bulan : {{date('M', strtotime($tanggal))}} </h3>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="{{url('/admin/laporan/pembelian/print')}}" onclick="event.preventDefault(); document.getElementById('print_laporan').submit();" class="pull-right btn btn-info" style="margin-top:0px;"><i class="fa fa-print"></i>&nbsp; Print Laporan</a>
                                        <form action="{{url('/admin/laporan/pembelian/print')}}" id="print_laporan" target="_blank" method="post">
                                            {{csrf_field()}}
                                            <input type="hidden" name="tanggal" value="{{$tanggal}}">

                                        </form>
                                    </div>
                                </div>
                                <h3 class="text-center">{{\App\CompanyProfile::find(1)->nama_toko}}<br/></h3>
                                <h4 class="text-center">Laporan Pembelian</h4>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-dataTable">
                                                <thead>
                                                    <tr>
                                                        <th width="100px" style="vertical-align:middle; text-align:center;">Nota</th>
                                                        <th width="200px" style="vertical-align:middle; text-align:center;">Tanggal Pembelian</th>
                                                        <th width="150px" style="vertical-align:middle; text-align:center;">Supplier</th>
                                                        <th width="150px" style="vertical-align:middle; text-align:center;">Jumlah Brg</th>
                                                        <th width="100px" style="vertical-align:middle; text-align:center;">Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 0; ?>
                                                    <?php
                                                        use App\TransaksiMember;
                                                        $total = 0;
                                                        $total_sp = 0;
                                                    ?>

                                                    @forelse ($data_pembelian->get() as $pembelian)
                                                        <tr>
                                                            <td align="center">{{$pembelian->kode}}</td>
                                                            <td align="center">{{date('d-m-Y', strtotime($pembelian->tanggal))}}</td>
                                                            <td align="center">
                                                                @if($pembelian->supplier != null)
                                                                    {{$pembelian->supplier->nama_supplier}}
                                                                @endif
                                                            </td>
                                                            <td align="center">
                                                                {{$pembelian->total_sp}}
                                                            </td>
                                                            <td align="right">
                                                                {{$pembelian->detile()->sum('sub_total')}}

                                                            </td>
                                                        </tr>
                                                        <?php
                                                            $total = $total + $pembelian->detile()->sum('sub_total');
                                                            $total_sp = $total_sp + $pembelian->total_sp;
                                                            $i++;
                                                        ?>
                                                    @empty

                                                    @endforelse

                                                </tbody>
                                            </table>
                                        </div>
                                        <br />
                                        <br />
                                        <div class="row">
                                            <div class="col-md-4 pull-right">
                                                <table class="table">
                                                    <tr>
                                                        <th>Total Barang</th>
                                                        <td>:</td>
                                                        <td align="right">{{$total_sp}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total</th>
                                                        <td>: &nbsp;Rp.</td>
                                                        <td align="right">{{number_format($total)}}</td>
                                                    </tr>
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
    </div>
    <script>
        jQuery(document).ready(function () {
            DataTableBasic.init();
        });
    </script>
@endsection
