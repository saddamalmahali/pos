<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cetak Nota Penjualan</title>

    <style>
        @media print{
            body {
                margin : 0;
                padding : 0;
            }
        }
        body {
            margin : 10px;
            padding : 10px;
            font-family: sans-serif;
            font-size : 14px;

        }
        /*design table 1*/
        .table1 {
            font-family: sans-serif;
            color: #232323;
            border-collapse: collapse;
        }

        .table1, th {

            padding: 2px 10px;
        }
        .table1 thead {
            border-right : 0px;
            border-left : 0px;
        }
         .isiSparepart td{
             border-top : 0px;
             border-bottom : 0px;
             border-right : 0px;
             border-left : 0px;
             padding: 2px 10px;
         }
         .totalKeterangan td{
             border-top : 1px solid #000000;
             border-right : 0px;
             border-left : 0px;
             border-bottom : 0px;
             padding-top : 5px;
             padding-right : 10px;
         }
         .headerTableInvoice th{
            border-top : 1px double #000000;
            border-bottom : 1px double #000000;
            border-right : 0px;
            border-left : 0px;
         }
         .infoDetail td{
            padding-top : 0px;
            padding-bottom : 0px;
         }
    </style>

    <script type="text/javascript" src="{{url('/assets/plugins/lib/jquery-2.2.4.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/plugins/print/jQuery.print.js')}}"></script>

</head>

<body>
<div class="container">
    <table width="100%">
        <tr>
            <?php $company = \App\CompanyProfile::find(1); ?>
            <td width="70%">
                <b>{{$company->nama_toko}}</b><br />

                <small>{{$company->alamat}}</small><br />
                <small>Telp/HP. {{$company->telp}}</small>
            </td>
            <td align="left">
                <b><u>Nota Penjualan</u></b><br />
                {{date('d-m-Y', strtotime($penjualan->tanggal_jual))}} || {{date('H:m:s a', strtotime($penjualan->created_at))}}<br />
                @if($penjualan->transaksi_member()->count() > 0)
                    @if($penjualan->transaksi_member != '')
                        Kepada Yth.<br />
                        {{$penjualan->transaksi_member->member->nama}}<br />
                        di tempat
                    @endif

                @else


                @endif
            </td>
        </tr>
    </table>
    <br />
    <table width="100%">
        <tr>
            <td style="vertical-align: middle; padding: 0px; width :12%;">Nota </td>
            <td style="vertical-align: middle; padding: 0px; "> : </td>
            <td style="vertical-align: middle; padding: 0px;width :25%;">{{$penjualan->nota}}</td>

            <td style="vertical-align: middle; width :12%;">Kasir </td>
            <td style="vertical-align: middle;"> : </td>
            <td style="vertical-align: middle; width :width :25%;">
                <?php
                    use App\Karyawan;
                    use App\User;
                    if($penjualan->tipe_user == 1){
                        echo Karyawan::find($penjualan->id_user)->nama_lengkap;
                    }else{
                        echo User::find($penjualan->id_user)->name;
                    }

                ?>
            </td>



        </tr>
    </table>
    <table class="table1" cellspacing="5px" cellpadding="5px">
        <thead>
            <tr class="headerTableInvoice">
                <th style="text-align:center;" width="10%">No</th>
                <th style="text-align:center;" width="40%">Barang</th>
                <th width="10%" style="text-align:center;">Qty</th>
                <th width="10%" style="text-align:center;">@harga</th>

                <th width="15%" style="text-align:center;">Dis. %</th>
                <th style="text-align:center;">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @if($penjualan->service()->count() > 0)

                @foreach($penjualan->service as $service)
                    <tr class="isiSparepart">
                        <td colspan="3">{{$service->service->kode.' | '.$service->service->nama}}</td>
                        <td align="center">{{$service->harga}}</td>
                        <td align="center">{{$service->discount}}</td>
                        <td align="right">{{number_format($service->harga - (($service->harga*$service->discount)/100)) }}</td>
                    </tr>
                @endforeach
            @endif
            <?php
                $i=0;
            ?>

            @if($penjualan->detile()->count() > 0)
                <tr class="infoDetail">
                    <td colspan="6"><b>Sparepart</b></td>
                </tr>
                @foreach($penjualan->detile as $detile)
                    <tr class="isiSparepart">
                        <td align="center" >{{$i+1}}</td>
                        <td align="left" >{{$detile->nama_sparepart}}</td>
                        <td align="center">{{$detile->jumlah_sp}}</td>
                        <td align="right">{{number_format($detile->harga_jual)}}</td>
                        <td align="center">{{$detile->discount}}</td>
                        <td align="right" width="30%">{{number_format($detile->sub_total)}}</td>

                    </tr>
                    <?php
                        $i++;
                    ?>

                @endforeach
            @endif

            <tr class="totalKeterangan">
                <td colspan="4">
                    Perhatian! <br />
                    BARANG-BARANG YANG SUDAH DIBELI <br />
                    TIDAK BISA DIGANTIKAN ATAU DIKEMBALIKAN!
                </td>
                <td  border="0" style ="border-right:0px;" align="right">

                                <b>Total</b> <br />
                                <b>Bayar</b> <br />
                                <b>Kembali</b>

                </td>
                <td align="right">
                    {{number_format($penjualan->total_harga)}}<br />
                    {{number_format($penjualan->bayar)}}<br />
                    {{number_format($penjualan->kembali) }}
                </td>
            </tr>

        </tbody>
    </table>

    <br />
    @if($penjualan->transaksi_member()->count() > 0)
        <table width="100%">
            <tr>
                <td style="width:20%;">Service Ke</td>
                <td>:</td>
                <td style="width:35%;">
                    <?php

                        echo "".$data_transaksi_member->where('id_member', '=',$penjualan->transaksi_member->member->id)->count('id_member');

                    ?>
                </td>
                <td style="width:20%;">Service Selanjutnya</td>
                <td>:</td>
                <td style="width:35%;">{{date('d-m-Y', strtotime('+2 Months', strtotime($penjualan->tanggal_jual)))}}</td>
            </tr>
        </table>
    @endif

</div>


    <script>
        $(document).ready(function(){
            $('.container').print();
        });
    </script>

</body>
</html>
