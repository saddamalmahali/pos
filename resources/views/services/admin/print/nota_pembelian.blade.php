<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cetak Nota Pembelian</title>

    <style>
        @media print{
            html {
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
    <script type="text/javascript" src="{{url('/js/jquery3.min.js')}}"></script>

    <script type="text/javascript" src="{{url('/plugins/print/html5-3.6-respond-1.1.0.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/plugins/print/jQuery.print.js')}}"></script>
    <style>

    </style>
</head>

<body>
<?php $company = \App\CompanyProfile::find(1); ?>
    <div class="container">
        <table width="100%">
            <tr>
                <td width="70%">
                    <b>{{$company->nama_toko}}</b><br />
                    <small>{{$company->alamat}}</small><br />
                    <small>Telp/HP. {{$company->telp}}</small>
                </td>
                <td align="left">
                    <b><u>Nota Pembelian</u></b><br />
                    {{date('d-m-Y', strtotime($pembelian->tanggal))}} || {{date('H:m:s a', strtotime($pembelian->created_at))}}

                </td>
            </tr>
        </table>
        <br />
        <table width="100%">
            <tr>
                <td style="vertical-align: middle; padding: 0px; width :12%;">Nota </td>
                <td style="vertical-align: middle; padding: 0px; "> : </td>
                <td style="vertical-align: middle; padding: 0px;width :25%;">{{$pembelian->kode}}</td>

                <td style="vertical-align: middle; width :12%;">Supplier </td>
                <td style="vertical-align: middle;"> : </td>
                <td style="vertical-align: middle; width :width :25%;">{{$pembelian->supplier == '' ? 'null' : $pembelian->supplier->nama_supplier}}</td>

                <td style="vertical-align: middle; padding: 0px; width :12%;">Telp </td>
                <td style="vertical-align: middle; padding: 0px;"> : </td>
                <td style="vertical-align: middle; padding: 0px;">{{$pembelian->supplier == '' ? 'null' : $pembelian->supplier->no_telp}}</td>

            </tr>
        </table>
        <table class="table1" cellspacing="5px" cellpadding="5px">
            <thead>
                <tr class="headerTableInvoice">
                    <th style="text-align:center;" width="10%">No</th>
                    <th style="text-align:center;" width="20%">Kode</th>
                    <th style="text-align:center;" width="35%">Barang</th>
                    <th width="10%" style="text-align:center;">Qty</th>
                    <th width="10%" style="text-align:center;">@harga</th>
                    <th style="text-align:center;">Jumlah</th>
                </tr>
            </thead>
            <tbody>

                <?php
                    $i=0;
                    $total_harga = 0;
                ?>

                @if($pembelian->detile()->count() > 0)
                    @foreach($pembelian->detile as $detile)
                        <tr class="isiSparepart">
                            <td align="center" >{{$i+1}}</td>
                            <td align="center">{{$detile->barang->kode}}</td>
                            <td align="left" >{{$detile->barang->nama_barang}}</td>
                            <td align="center">{{$detile->jumlah_sp}}</td>
                            <td align="right">{{number_format($detile->harga_beli)}}</td>
                            <td align="right" width="30%">{{number_format($detile->sub_total)}}</td>

                        </tr>
                        <?php
                            $total_harga = $total_harga+$detile->sub_total;
                            $i++;
                        ?>

                    @endforeach
                @endif

                <tr class="totalKeterangan">
                    <td colspan="4">

                    </td>
                    <td  border="0" style ="border-right:0px;" align="right">

                                    <b>Total</b>
                    </td>
                    <td align="right">
                        {{number_format($total_harga)}}
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

<script>
    $(document).ready(function(){
        $('.container').print();
    });
</script>
</body>
</html>
