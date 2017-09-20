<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(auth('web')->check()){
        return redirect('/home');
    }else if(auth('karyawan')->check()){
        return redirect('/home_client');
    }else{
        return view('welcome');
    }
    
});

Route::get('/login', function(){
    return redirect('/');
});
Route::get('/login_client', function(){
    return redirect('/');
});
Route::post('/login_applikasi', 'Auth\LoginKaryawanController@login');
Route::post('/logout', 'Auth\LoginController@logout');


Route::group(['middleware'=>['auth']], function(){
    Route::get('/home', 'HomeController@index');
    Route::post('/home/get_data_chart', 'HomeController@get_data_chart');
    //Barang
    Route::get('/master/barang', 'MasterController@index_barang');
    Route::get('/master/barang/tambah', 'MasterController@tambah_barang');
    Route::post('/master/barang/simpan', 'MasterController@simpan_data_barang');
    Route::get('/master/barang/edit/{id}', 'MasterController@edit_form_barang');
    Route::post('/master/barang/simpan_update', 'MasterController@simpan_update_data_barang');
    Route::post('/master/barang/hapus', 'MasterController@hapus_barang');

    //Service 
    Route::group(['prefix'=>'master', 'as'=>'master.'], function(){
        Route::group(['prefix'=>'service', 'as'=>'service'], function(){
            Route::get('/', 'MasterController@index_service');
            Route::post('/simpan', 'MasterController@simpan_service');
            Route::post('/hapus', 'MasterController@hapus_service');
        });
    });
    

    //karyawan
    Route::get('/master/karyawan', 'MasterController@index_karyawan');
    Route::get('/master/karyawan/tambah', 'MasterController@karyawan_form_tambah');
    Route::post('/master/karyawan/simpan', 'MasterController@simpan_karyawan');
    Route::post('/master/karyawan/hapus', 'MasterController@hapus_karyawan');
    Route::get('/master/karyawan/view/{id}', 'MasterController@view_karyawan');

    //Tipe Motor
    Route::get('/master/tipe_motor', 'MasterController@index_tipe_motor');
    Route::post('/master/tipe_motor/tambah', 'MasterController@simpan_tipe_motor');
    Route::post('/master/tipe_motor/hapus', 'MasterController@hapus_tipe_motor');

    //Data Pelanggan
    Route::get('/master/admin/pembeli', 'MasterController@index_admin_pelanggan');
    Route::post('/master/admin/pembeli/simpan', 'MasterController@simpan_admin_pelanggan');
    Route::post('/master/admin/pembeli/hapus', 'MasterController@hapus_admin_pelanggan');

    //Data Member
    Route::get('/master/admin/member', 'MasterController@index_member');
    Route::get('/master/admin/member/tambah', 'MasterController@tambah_member');
    Route::get('/master/admin/member/edit/{id}', 'MasterController@edit_form_member');
    Route::post('/master/admin/member/simpan', 'MasterController@simpan_member');
    Route::post('/master/admin/member/hapus', 'MasterController@hapus_member');

    //Penjualan
    Route::get('/admin/services/print/nota_penjualan/{id}', 'ServicesController@print_admin_nota_penjualan');
    //Penjualan
    Route::get('/admin/transaksi/penjualan', 'TransaksionalAdminController@index_penjualan');
    Route::get('/admin/transaksi/penjualan/tambah', 'TransaksionalAdminController@form_tambah_penjualan');
    Route::post('/admin/transaksi/get_barang', 'TransaksionalAdminController@get_data_barang');
    Route::post('/admin/transaksi/penjualan/simpan', 'TransaksionalAdminController@simpan_penjualan');
    Route::post('/admin/transaksi/penjualan/get_data_barang_from_id', 'TransaksionalAdminController@get_data_barang_from_id');
    Route::post('/admin/transaksi/penjualan/get_data_service', 'TransaksionalAdminController@get_data_service');
    Route::post('/admin/transaksi/penjualan/hapus', 'TransaksionalAdminController@hapus_penjualan');
    Route::post('/admin/transaksi/penjualan/simpan_update', 'TransaksionalAdminController@simpan_update');
    Route::get('/admin/transaksi/penjualan/update/{id}', 'TransaksionalAdminController@update_penjualan');

    //Supplier
    Route::get('/master/supplier', 'MasterController@index_supplier');
    Route::get('/master/supplier/tambah', 'MasterController@tambah_supplier');
    Route::get('/master/supplier/update/{id}', 'MasterController@update_supplier');
    Route::post('/master/supplier/simpan', 'MasterController@simpan_supplier');
    Route::post('/master/supplier/hapus', 'MasterController@hapus_supplier');

    //Pembelian
    Route::get('/admin/transaksi/pembelian', 'TransaksionalAdminController@index_pembelian');
    Route::get('/admin/transaksi/pembelian/tambah', 'TransaksionalAdminController@tambah_pembelian');
    Route::post('/admin/transaksi/pembelian/simpan', 'TransaksionalAdminController@simpan_pembelian');
    Route::post('/admin/transaksi/pembelian/hapus', 'TransaksionalAdminController@hapus_pembelian');
    Route::get('/admin/transaksi/pembelian/view/{id}', 'TransaksionalAdminController@view_pembelian');
    Route::get('/admin/services/print/nota_pembelian/{id}', 'ServicesController@print_admin_nota_pembelian');


    /* Module Laporan */
    //Laporan Stok
    Route::get('/admin/laporan/stok', 'LaporanController@index_stok');
    Route::get('/admin/laporan/stok/print', 'LaporanController@print_page');
    //Laporan Penjualan
    Route::get('/admin/laporan/penjualan', 'LaporanController@index_penjualan');
    Route::post('/admin/laporan/penjualan', 'LaporanController@index_penjualan');
    Route::post('/admin/laporan/penjualan/print', 'LaporanController@laporan_penjualan_tanggal');

    //Laporan Pembelian
    Route::get('/admin/laporan/pembelian', 'LaporanController@index_pembelian');
    Route::post('/admin/laporan/pembelian', 'LaporanController@index_pembelian');
    Route::post('/admin/laporan/pembelian/print', 'LaporanController@laporan_pembelian_tanggal');

    //Riwayat Transaksi Member
    Route::get('/admin/laporan/riwayat_transaksi_member', 'LaporanController@index_riwayat_tm');
    Route::post('/admin/laporan/riwayat_transaksi_member', 'LaporanController@index_riwayat_tm');

    Route::get('/admin/backup', 'BackupController@index');
    Route::get('/admin/file/get/{name}', 'BackupController@get_file');

    //Laporan Per Barang 
    Route::get('/admin/laporan/penjualan_barang', 'LaporanController@index_penjualan_barang');
    Route::post('/admin/laporan/penjualan_barang', 'LaporanController@index_penjualan_barang');
    Route::post('/admin/laporan/penjualan_barang/detile', 'LaporanController@detile_penjualan_barang');

    Route::get('/admin/laporan/index', 'HomeController@tentang_aplikasi');
    Route::get('/admin/setting/index', 'HomeController@setting_index');
    Route::post('/admin/setting/simpan', 'HomeController@simpan_setting');
});

Route::group(['middleware'=>['karyawan']], function(){

    //Data Pelanggan
    Route::get('/master/pembeli', 'MasterController@index_pelanggan');
    Route::post('/master/pembeli/simpan', 'MasterController@simpan_pelanggan');

    //Coba Print
    Route::get('/services/print/nota_penjualan/{id}', 'ServicesController@print_nota_penjualan');
    Route::post('/services/print/nota_penjualan_langsung', 'ServicesController@print_admin_nota_penjualan_langsung');
    //Penjualan
    Route::get('/home_client', 'HomeClientController@index');
    Route::post('/home_client/get_data_chart', 'HomeClientController@get_data_chart');
    Route::get('/transaksi/penjualan', 'TransaksionalController@index_penjualan');
    Route::get('/transaksi/penjualan/tambah', 'TransaksionalController@form_tambah_penjualan');
    Route::post('/transaksi/get_barang', 'TransaksionalController@get_data_barang');
    Route::post('/transaksi/penjualan/simpan', 'TransaksionalController@simpan_penjualan');
    Route::post('/transaksi/penjualan/get_data_barang_from_id', 'TransaksionalController@get_data_barang_from_id');
    Route::post('/transaksi/penjualan/get_data_service', 'TransaksionalController@get_data_service');
    Route::post('/transaksi/penjualan/hapus', 'TransaksionalController@hapus_penjualan');
    Route::get('/transaksi/penjualan/konfirmasi_penjualan/{id}', 'TransaksionalController@konfirmasi_penjualan');
    Route::post('/transaksi/penjualan/simpan_transaksi_penjualan', 'TransaksionalController@simpan_transaksi_penjualan');

    //Data Member
    Route::get('/master/client/member', 'MasterController@index_client_member');
    Route::get('/master/client/member/tambah', 'MasterController@tambah_client_member');
    Route::get('/master/client/member/edit/{id}', 'MasterController@edit_client_form_member');
    Route::post('/master/client/member/simpan', 'MasterController@simpan_client_member');
    Route::post('/master/client/member/hapus', 'MasterController@hapus_client_member');

});