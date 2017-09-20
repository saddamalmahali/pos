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
<form action="{{url('/admin/transaksi/pembelian/simpan')}}" class="form-pembelian" method="POST">
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
                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="pull-right" style="margin-top:10px; ">
                            <a href="{{url('/transaksi/penjualan')}}" style="width:100px;" class="btn btn-info ">Batal</a>
                            <input type="submit" class="btn btn-success btn-submit " style="width:100px;" value="simpan">
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
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Data Pokok Pembelian</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th>No Nota</th>
                                <td>:</td>
                                <td><input type="text" name="kode_pembelian" required class="form-control" placeholder="No Nota"></td>
                            </tr>
                            <tr>
                                <th>Supplier</th>
                                <td>:</td>
                                <td>
                                    <select name="supplier" required class="form-control select2Search">
                                        <option value="" selected disabled>Pilih Supplier</option>
                                        @foreach($data_supplier as $supplier)
                                            <option value="{{$supplier->id}}">{{$supplier->nama_supplier}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            
                            <tr>
                                <th>Tanggal Beli</th>
                                <td>:</td>
                                <td><input type="text" required name="tanggal_beli" id="tanggal_beli" class="form-control date-picker" data-autoclose="1" required placeholder="Pilih Tanggal"></td>
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
                        <h3 class="panel-title">Detile Pembelian</h3>
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
        var dynamic_form_service = $('.form_dynamic_service');

        var jumlah_barang = 0;
        var jumlah_bayar = 0;
        var total_barang = 0;
        var temp_total_barang = 0;

        var count_row = 0;        
        var max_count_row = 0;
        var count_row_service = 0;
        var max_count_row_service = 0;
        

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.form-pembelian').submit(function(e){
            if(confirm('Apakah Anda Yakin Akan Menyimpan transaksi?')){
                return true;
            }
        });

        $('.detile_harga_beli_0').number(true, 2);
        //$('.detile_jumlah_harga_0').number(true, 2);
        //$('#jumlah_bayar').number(true, 2);
        //$('.bayar').number(true, 2);
        //$('.kembali').number(true, 2);
        
        var parseService = function(id_row, data){

            $('#nama_service').val(data.nama);
            $('#harga_service').val(data.harga);
            var harga_parse = data.harga;
            $('.service_harga_'+id_row).val(data.harga);
            jumlah_bayar = parseInt(jumlah_bayar) + parseInt(harga_parse);
            $('.detile_service_jumlah_harga_'+id_row).val(data.harga);
            input_jumlah_bayar.val(jumlah_bayar);
            
        }


        $('#kode_service').on('change', function(e){
            e.preventDefault();
            var id_service = $(this).val();
            $.ajax({
                url : '/admin/transaksi/penjualan/get_data_service',
                data : {id : id_service},
                dataType : 'json',
                type : 'post',
                success : function(data){
                    parseService(data);
                }
            });
        });
        
        $(document).on('change', '.select_service', function(e){
            
            var id_service = $(this).val();
            var id_row = $(this).attr('id');
            $.ajax({
                url : '/admin/transaksi/penjualan/get_data_service',
                data : {id : id_service},
                dataType : 'json',
                type : 'post',
                success : function(data){
                    parseService(id_row, data);
                    addEventListenerDiscService(id_row, e);
                }
            });
        });

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

                    $('.detile_harga_beli_'+id_row).val(data.harga_beli);
                    
                }

            });

            
        });

        function addEventListenerDiscService(id_row, evt)
        {
            evt.preventDefault();
            $('.service_discount_'+id_row).attr('disabled', false);
            $('.service_discount_'+id_row).bind('keydown', function(){
                var harga = $('.service_harga_'+id_row).val();
                var satuan = $(this).val();
                var diskon = (harga*satuan)/100;

                jumlah_bayar = jumlah_bayar+diskon;
                console.log('Satuan : '+satuan);
                console.log('Jumlah Bayar : '+jumlah_bayar);
                console.log('Diskon :'+diskon);
            });

            $('.service_discount_'+id_row).bind('keyup', function(){
                var harga = $('.service_harga_'+id_row).val();
                var satuan = $(this).val();
                var diskon = (harga*satuan)/100;
                var jumlah_harga = harga-diskon;
                $('.detile_service_jumlah_harga_'+id_row).val(jumlah_harga);
                jumlah_bayar = jumlah_bayar-diskon;
                input_jumlah_bayar.val(jumlah_bayar);
            });
        }
        
        function addEventListener(id_row, e)
        {
            $('.detile_disc_'+id_row).bind('keydown', function(){                
                var harga_jual = $('.detile_harga_beli_'+id_row).val();
                var jumlah_barang = $('.row_jumlah_'+id_row).val();
                var jumlah_bayar_barang = harga_jual*jumlah_barang;
                var diskon = $(this).val();
                console.log('diskon : '+$(this).val());
                var hasil = (jumlah_bayar_barang*diskon)/100;  
                var jumlah_bayar_unit = jumlah_bayar_barang - hasil;
                console.log('keydown');
                jumlah_bayar = jumlah_bayar+hasil;

                input_jumlah_bayar.val(jumlah_bayar);
            });

            $('.detile_disc_'+id_row).bind('keyup', function(){
                var harga_jual = $('.detile_harga_beli_'+id_row).val();
                var jumlah_barang = $('.row_jumlah_'+id_row).val();
                var jumlah_bayar_barang = harga_jual*jumlah_barang;
                var diskon = $(this).val();
                var hasil = (jumlah_bayar_barang*diskon)/100;  
                var jumlah_bayar_unit = jumlah_bayar_barang - hasil;
                console.log('keyup');
                console.log('diskon : '+$(this).val());
                $('.detile_jumlah_harga_'+id_row).val(jumlah_bayar_unit);
                jumlah_bayar = jumlah_bayar-hasil;
                input_jumlah_bayar.val(jumlah_bayar);
                
            });
        }


        $(document).on('keyup', '.detile_jumlah', function(e){
            console.log('keyup');
            e.preventDefault();
            var row = $(this).attr('id');
            var jumlah_harga = $('.detile_jumlah_harga_'+row).val();
            
            var harga_jual = $('.detile_harga_beli_'+row).val();
            if(jumlah_harga != null || jumlah_harga != ''){
                jumlah_bayar = jumlah_bayar - jumlah_harga;
            }
            var total = harga_jual* $(this).val();
            total_barang = total_barang + $(this).val();
            
            $('.detile_jumlah_harga_'+row).val(total);
            jumlah_bayar = jumlah_bayar + total;

            input_jumlah_bayar.val(jumlah_bayar);
            $('.detile_disc_'+row).attr('disabled', false);
            addEventListener(row, e);
        });


        $(document).on('keyup', '#bayar', function(e){
            e.preventDefault();
            var bayar = $('#bayar').val();
            var kembali = bayar - jumlah_bayar;
            $('#kembali').val(kembali);
        });
        

        
        

        $(document).on('click', '.btn-tambah-detail', function(e){
            
            dynamic_form.append(
                '<tr id="detile_pembelian_'+count_row+'">'+
                    '<td>'+
                        '<select name="detile_pembelian['+count_row+'][barang]" required id="'+count_row+'" class="form-control select_detile_barang select2Search">'+
                            '<option value="" selected disabled>Pilih Barang</option>'+
                            '@forelse ($data_barang as $barang)'+
                                '<option value="{{$barang->id}}">{{$barang->kode_tipe_motor." | ".$barang->nama_barang}}</option>'+
                            '@empty'+                                
                            '@endforelse'+
                        '</select>'+
                    '</td>'+
                    '<td><input name="detile_pembelian['+count_row+'][harga_beli]" id="'+count_row+'" type="number" class="form-control text-center detile_harga_beli_'+count_row+'" ></td>'+
                    '<td><input type="number" required name="detile_pembelian['+count_row+'][jumlah]" id="'+count_row+'" class="form-control text-center detile_jumlah row_jumlah_'+count_row+'"></td>'+
                    
                    '<td><input type="text" name="detile_pembelian['+count_row+'][jumlah_harga]" id="'+count_row+'" class="form-control detile_jumlah_harga_'+count_row+'" readonly></td>'+
                    
                '</tr>'
            );

            //$('.detile_harga_beli_'+count_row+'').number(true, 2);
            //$('.detile_jumlah_harga_'+count_row+'').number(true, 2);
            

            $(".select2Search").each(function() {
                $(this).select2({});
            });
            count_row++;
        });
    </script>
</form>
@endsection