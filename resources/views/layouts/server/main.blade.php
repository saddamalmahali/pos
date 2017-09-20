<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Service Information System AHASS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="author" content="Ruslan">
        <meta name="description" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

        <script type="text/javascript" src="{{url('/assets/plugins/lib/modernizr.js')}}"></script>
        

        <link rel="stylesheet" type="text/css" href="{{url('/assets/plugins/bootstrap/bootstrap.css')}}">
        <link href="{{url('/plugins/datepicker/bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{url('/assets/plugins/toast/jquery.toast.min.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{url('/assets/plugins/lib/jquery-ui.css')}}" />

        <link rel="stylesheet" type="text/css" href="{{url('/assets/css/style-default.css')}}">
        <link rel="stylesheet" type="text/css" href="{{url('/assets/plugins/select2/css/select2.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{url('/assets/plugins/datatable/dataTables.bootstrap.min.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{url('/assets/plugins/morris/morris.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{url('/assets/css/main.css')}}">

        <script type="text/javascript" src="{{url('/assets/plugins/lib/jquery-2.2.4.min.js')}}"></script>
        <script type="text/javascript" src="{{url('/assets/plugins/lib/jquery-ui.min.js')}}"></script>
        <script type="text/javascript" src="{{url('/assets/plugins/bootstrap/bootstrap.min.js')}}"></script>
        <script src="{{url('/plugins/datepicker/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{url('/plugins/datepicker/bootstrap-datepicker-master/dist/locales/bootstrap-datepicker.id.min.js')}}"></script>
        <script type="text/javascript" src="{{url('/assets/plugins/toast/jquery.toast.min.js')}}"></script>
        <script type="text/javascript" src="{{url('/assets/plugins/select2/js/select2.full.min.js')}}"></script>
        <script type="text/javascript" src="{{url('/assets/plugins/morris/raphael-min.js')}}"></script>
        <script type="text/javascript" src="{{url('/assets/plugins/morris/morris.min.js')}}"></script>
        <script type="text/javascript" src="{{url('/plugins/currency/jquery.number.min.js')}}"></script>
        <script type="text/javascript" src="{{url('/assets/plugins/datatable/jquery.dataTables.min.js')}}"></script>
        <script type="text/javascript" src="{{url('/assets/plugins/datatable/dataTables.bootstrap.min.js')}}"></script>
    </head>

    <body>
        <div class="wrapper has-footer">

            <!-- header -->
            @include('layouts.server.header')
            <!-- sidebar -->
            @include('layouts.server.sidebar')
            <!-- main-containe -->
            <div class="main-container">
                @yield('content')
            </div>
            <!-- footer -->
            @include('layouts.server.footer')
        </div> <!-- END: wrapper -->
    </body>

</html>
