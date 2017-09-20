@extends('layouts.server.main')

@section('content')
    <div class="page-header">
        <h1>Data Karyawan</h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/home')}}">Dasboard</a></li>
            <li class="active">Index</li>
        </ol>
    </div>
    <div class="content-wrap">
        
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h4 class="panel-title"><i class="fa fa-users"></i>&nbsp;&nbsp;&nbsp;Data Karyawan</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-6 text-right" style="margin-bottom:10px;">
                                <a href="{{url('/master/karyawan/tambah')}}" class="btn btn-primary" style="width:100px;"><i class="fa fa-plus "></i>&nbsp;&nbsp;&nbsp;Tambah</a> &nbsp;

                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead >                            
                                            <tr>
                                                <th class="text-center" width="5%">No</th>
                                                <th class="text-center">Kode Karyawan</th>
                                                <th class="text-center">Nama Lengkap</th>
                                                <th class="text-center">Jenis Kelamin</th>
                                                <th class="text-center">Tempat Lahir</th>
                                                <th class="text-center">Tanggal Lahir</th>
                                                <th class="text-center">Jabatan</th>
                                                <th width="15%" class="text-center">Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0; ?>
                                            @forelse ($data_karyawan as $karyawan)
                                                <tr>
                                                    <td align="center" style="vertical-align:middle;">{{$i+1}}</td>
                                                    <td align="center" style="vertical-align:middle;">{{$karyawan->kode_karyawan}}</td>
                                                    <td align="center" style="vertical-align:middle;">{{$karyawan->nama_lengkap}}</td>
                                                    <td align="center" style="vertical-align:middle;">{!!$karyawan->jenis_kelamin == 'l' ? "Laki-Laki" : "Perempuan"  !!}</td>
                                                    <td align="center" style="vertical-align:middle;">{{$karyawan->tempat_lahir}}</td>
                                                    <td align="center" style="vertical-align:middle;">{{date('d-m-Y', strtotime($karyawan->tanggal_lahir))}}</td>
                                                    <td align="center" style="vertical-align:middle;">{!!$karyawan->username == '' ?  "<span class='label label-primary'><i class='fa fa-user'></i>&nbsp; Teknisi</span>" : "<span class='label label-success'><i class='fa fa-television'></i>&nbsp; Kasir</span>"!!}</td>
                                                    <td align="center" style="vertical-align:middle;">
                                                        <a href="{{url('/master/karyawan/view').'/'.$karyawan->id}}" class="btn btn-success btn-xs btn-rounded"><i class="fa fa-search"></i></a>
                                                        <a href="#" class="btn btn-danger btn-xs btn-rounded btn-hapus" id="{{$karyawan->id}}"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                                <?php $i++ ?>
                                            @empty
                                                <tr>
                                                    <td colspan="8" align="center">Tidak Ada Data</td>
                                                </tr>
                                            @endforelse
                                            
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

    <script>
    var jenis = "{{session()->has('sukses') == 1 ? 'info' : 'error'}}";
    console.log(jenis);
    var message = "{{session()->has('sukses') == 1 ? session()->get('sukses') : session()->get('error')}}";
    console.log(message);
    if(message != ""){
        if(jenis == 'info'){
            $.toast({
                heading: 'Sukses!',
                text: message,
                showHideTransition: 'slide',
                icon: 'info',
                hideAfter: 3000,
                position: 'top-right',
                bgColor: '#00C9E6'
            });
        }else{
            $.toast({
                heading: 'Berhasil',
                text: message,
                showHideTransition: 'slide',
                icon: 'error',
                hideAfter: 3000,
                position: 'top-right',
                bgColor: '#FF4859'
            });
        }

    }
    var url_back = "{{url('/master/karyawan')}}";
    $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $(document).on('click', '.btn-hapus', function(e){
            e.preventDefault();
            var id_karyawan = $(this).attr('id');
            if(confirm('Apakah anda yakin ingin menghapus data?')){
                 $.ajax({
                    url : '/master/karyawan/hapus',
                    type : 'post',
                    data : {id : id_karyawan},
                    dataType : 'json',
                    success : function(data){
                        if(data == 'sukses'){
                            window.location.replace(url_back);
                        }
                    }

                });
               
            }
        });
    })
        
    </script>
@endsection