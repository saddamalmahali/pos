@extends('layouts.server.main')
@section('content')
<style>
    .top-fixed{
        position : fixed;
        z-index:1;
        margin-top : 0;
        height : 60px;
        margin-bottom:50px;
        width:83%;
        background : #ffffff;
    }

</style>
<form action="{{url('/admin/transaksi/penjualan/simpan')}}" class="form-penjualan" method="POST">
{{csrf_field()}}
    <div class="row">
        <div class="col-md-12">
            <div class="page-header top-fixed" >
                <div class="row ">

                    <div class="col-md-8">
                        <div class="form-inline" style="margin-top:10px;">
                            <div class="form-group">
                                <label for="jumlah_bayar" class="label-control">Total</label>
                                <input type="text" id="jumlah_bayar" name="jumlah_bayar" readonly class="form-control" >

                            </div>
                            <div class="form-group">
                                &nbsp;&nbsp;&nbsp;&nbsp;<label for="bayar" class="label-control">Bayar</label>
                                <input type="text" id="bayar" name="bayar" required class="form-control required bayar">
                            </div>
                            <div class="form-group">
                                &nbsp;&nbsp;&nbsp;&nbsp;<label for="kembali" class="label-control">Kembali</label>
                                <input type="text" id="kembali" name="kembali" readonly class="form-control kembali" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="pull-right" style="margin-top:10px; ">
                            <a href="{{url('/admin/transaksi/penjualan')}}" style="width:100px;" class="btn btn-info ">Batal</a>
                            <input type="submit" class="btn btn-success btn-submit" style="width:100px;" value="simpan">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br />
    <br />
    <br />
    <div class="content-wrap">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Data Pokok Penjualan</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th>No Nota</th>
                                <td>:</td>
                                <td><input type="text" name="nota" class="form-control" value="{{$no_nota}}" readonly></td>
                            </tr>
                            <tr>
                                <th>Pelanggan</th>
                                <td>:</td>
                                <td>
                                    <select name="pelanggan" class="form-control select2Search">
                                        <option value="" selected disabled>Pilih Pelanggan</option>
                                        @foreach($data_pelanggan as $pelanggan)
                                            <option value="{{$pelanggan->id}}">{{$pelanggan->kode.' | '.$pelanggan->nama}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <th>Tanggal Transaksi</th>
                                <td>:</td>
                                <td><input type="text" name="tanggal_jual" id="tanggal_jual" class="form-control" value="{{date('d-m-Y')}}"></td>
                            </tr>
                            <tr>
                                <th style="vertical-align:top;">Keterangan</th>
                                <td style="vertical-align:top;">:</td>
                                <td><textarea name="keterangan" class="form-control" rows="4"></textarea></td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
            <div class="col-md-8">

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Detile Barang</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    <a class="btn btn-success btn-sm btn-tambah-detail">Tambah Barang</a>
                                </div>
                            </div>
                        </div>
                        <table class="table" >
                            <thead>
                                <tr>
                                    <th width="40%" style="text-align:center;">Nama Barang</th>
                                    <th style="text-align:center;">Harga</th>
                                    <th width="10%" style="text-align:center;">Jumlah</th>
                                    <th width="10%" style="text-align:center;">Disc</th>
                                    <th style="text-align:center;">Total Harga</th>
                                </tr>
                            </thead>
                            <tbody class="form-dynamic ">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var dynamic_form = $('.form-dynamic');
        var input_jumlah_bayar = $('#jumlah_bayar');

        var jumlah_barang = 0;
        var jumlah_bayar = 0;
        var total_barang = 0;
        var temp_total_barang = 0;

        var count_row = 0;
        var max_count_row = 0;


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#tanggal_jual').datepicker({
            format : 'dd-mm-yyyy',
            autoclose : true
        });

        $('.form-penjualan').submit( function(e){

            if(confirm("Apakah Anda Yakin Akan Menyimpan dan Mencetak Transaksi?")){
                return true;

            }
        });
        $('.detile_harga_jual_0').number(true, 2);
        //$('.detile_jumlah_harga_0').number(true, 2);
        //$('#jumlah_bayar').number(true, 2);
        //$('.bayar').number(true, 2);
        //$('.kembali').number(true, 2);

        $(document).on('change', '.select_detile_barang', function(e){

            var id_barang = $(this).val();
            var id_row = $(this).attr('id');
            console.log(id_row);
            $.ajax({
                url : '/admin/transaksi/penjualan/get_data_barang_from_id',
                type : 'post',
                data : {id : id_barang},
                dataType : 'json',
                success : function(data){

                    $('.detile_harga_jual_'+id_row).val(data.harga_jual);

                }

            });


        });

        function addEventListener(id_row)
        {
            $('.detile_disc_'+id_row).bind('keydown', function(){
                var harga_jual = $('.detile_harga_jual_'+id_row).val();
                var jumlah_barang = $('.row_jumlah_'+id_row).val();
                var jumlah_bayar_barang = harga_jual*jumlah_barang;
                var diskon = $(this).val();
                var hasil = (jumlah_bayar_barang*diskon)/100;
                var jumlah_bayar_unit = jumlah_bayar_barang - hasil;

            });

            $('.detile_disc_'+id_row).bind('keyup', function(){
                var harga_jual = $('.detile_harga_jual_'+id_row).val();
                var jumlah_barang = $('.row_jumlah_'+id_row).val();
                var jumlah_bayar_barang = harga_jual*jumlah_barang;
                var diskon = $(this).val();
                var hasil = (jumlah_bayar_barang*diskon)/100;
                var jumlah_bayar_unit = jumlah_bayar_barang - hasil;
                $('.detile_jumlah_harga_'+id_row).val(jumlah_bayar_unit);
                jumlahSemua();
            });
        }


        function addJumlahEventListener(id_row){
            $('.row_jumlah_'+id_row).bind('keydown',  function(e){

                var row = $(this).attr('id');
                var jumlah_harga = $('.detile_jumlah_harga_'+row).val();

                var harga_jual = $('.detile_harga_jual_'+row).val();
                var total = harga_jual* $(this).val();
                total_barang = total_barang - $(this).val();

                $('.detile_jumlah_harga_'+row).val(total);

            });
            $('.row_jumlah_'+id_row).bind('keyup',  function(e){

                var row = $(this).attr('id');
                var jumlah_harga = $('.detile_jumlah_harga_'+row).val();
                var harga_jual = $('.detile_harga_jual_'+row).val();
                var total = harga_jual* $(this).val();

                total_barang = total_barang + $(this).val();
                $('.detile_jumlah_harga_'+row).val(total);
                jumlahSemua();
                $('.detile_disc_'+row).attr('disabled', false);
                addEventListener(row);
            });
        }

        function jumlahSemua(){
            var total_bayar = 0;

            $('.detile_jumlah_harga').each(function(index, value){
                total_bayar = total_bayar+Number($(value).val());
            });

            input_jumlah_bayar.val(total_bayar);
        }


        $(document).on('keyup', '#bayar', function(e){
            var bayar = $("#bayar").val();
            console.log("jumlah Bayar : "+bayar);
            var total_bayar = $('#jumlah_bayar').val();
            console.log("Total Bayar : "+total_bayar);
            var kembali = Number(bayar) - Number(total_bayar);
            $('#kembali').val(kembali);
        });

        $(document).on('click', '.btn-tambah-detail', function(e){

            dynamic_form.append(
                '<tr id="detile_penjualan_'+count_row+'">'+
                    '<td>'+
                        '<select name="detile_penjualan['+count_row+'][barang]" id="'+count_row+'" class="form-control select_detile_barang select2Search">'+
                            '<option value="" selected disabled>Pilih Barang</option>'+
                            '@forelse ($data_barang as $barang)'+
                                '<option value="{{$barang->id}}">{{$barang->kode_tipe_motor." | ".$barang->nama_barang}}</option>'+
                            '@empty'+
                            '@endforelse'+
                        '</select>'+
                    '</td>'+
                    '<td><input name="detile_penjualan['+count_row+'][harga_jual]" id="'+count_row+'" type="text" class="form-control text-center detile_harga_jual_'+count_row+'" readonly></td>'+
                    '<td><input type="number" name="detile_penjualan['+count_row+'][jumlah]" id="'+count_row+'" class="form-control text-center detile_jumlah row_jumlah_'+count_row+'"></td>'+
                    '<td><input type="text" name="detile_penjualan['+count_row+'][disc]" id="'+count_row+'"  class="form-control detile_disc_'+count_row+'" disabled></td>'+
                    '<td><input type="text" name="detile_penjualan['+count_row+'][jumlah_harga]" id="'+count_row+'" class="form-control detile_jumlah_harga_'+count_row+' detile_jumlah_harga" readonly></td>'+

                '</tr>'
            );
            addJumlahEventListener(count_row);
            //$('.detile_harga_jual_'+count_row+'').number(true, 2);
            //$('.detile_jumlah_harga_'+count_row+'').number(true, 2);


            $(".select2Search").each(function() {
                $(this).select2({});
            });
            count_row++;
        });
    </script>
</form>
@endsection
