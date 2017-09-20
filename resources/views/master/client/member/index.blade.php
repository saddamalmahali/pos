@extends('layouts.client.main')
@section('content')
    <div class="page-header">
        <h1>Data Member</h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/home_client')}}">Dasboard</a></li>
            <li class="active">Index</li>
        </ol>
    </div>
    <div class="content-wrap">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">Data Member</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    <a href="{{url('/master/client/member/tambah')}}" style="margin-bottom:10px;" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>&nbsp;&nbsp; Tambah Data</a>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-dataTable">
                            <thead>
                                <tr>
                                    <th width="10%" class="text-center">No</th>
                                    <th width="15%" class="text-center">Kode</th>
                                    <th class="text-center">Nama</th>
                                    <th width="15%" class="text-center">No Plat</th>
                                    <th width="20%" class="text-center">Telepon</th>
                                    <th width="15%" class="text-center">Opsi</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @forelse ($data_member as $member)
                                    <tr>
                                        <td align="center">{{$i+1}}</td>
                                        <td align="center">{{$member->kode}}</td>
                                        <td align="center">{{$member->nama}}</td>
                                        <td align="center">{{$member->no_plat}}</td>
                                        <td align="center">{{$member->no_telp}}</td>
                                        <td align="center">
                                            <a href="{{url('/master/client/member/edit').'/'.$member->id}}" class="btn btn-rounded btn-warning btn-xs"><i class="fa fa-pencil"></i></a>
                                            
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                @empty
                                    <tr>
                                        <td colspan="6" align="center">Tidak Ada Data Member</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
        var url_back = "{{url('/master/client/member')}}";
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
           
        });
        jQuery(document).ready(function () {
            DataTableBasic.init();
        });
    </script>
@endsection
