<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{url('/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('/plugins/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{url('/plugins/datepicker/bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet">
    <link href="{{url('/css/style.css')}}" rel="stylesheet">
    <script src="{{url('/js/jquery.min.js')}}"></script>
    <script src="{{url('/js/notify.min.js')}}"></script>
    <script src="{{url('/plugins/datepicker/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{url('/plugins/datepicker/bootstrap-datepicker-master/dist/locales/bootstrap-datepicker.id.min.js')}}"></script>
    
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    
    <div id="app">
        <nav class="navbar navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guard('web')->check())
                            <li><a href="{{url('/home')}}"><i class="fa fa-home"></i>&nbsp; Dasboard</a><li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <i class="fa fa-database"></i>&nbsp; Master Data <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{url('/master/karyawan')}}"><i class="fa fa-address-card"></i>&nbsp; Data Karyawan</a><li>
                                    <li class="divider"></li>
                                    <li><a href="{{url('/master/data_jenis')}}"><i class="fa fa-server"></i>&nbsp; Data Jenis</a><li>
                                </ul>
                            </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>
    <footer class="footer">
      <div class="container">
        <p class="text-muted">&copy; {{date('Y')}} Saddam Almahali</p>
      </div>
    </footer>
    <!-- Scripts -->
    <script src="{{url('/js/app.js')}}"></script>
</body>
</html>
