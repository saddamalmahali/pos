
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login Aplikasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="author" content="Prakasam Mathaiyan">
    <meta name="description" content="">

    <!--[if IE]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="{{url('/assets/plugins/lib/modernizr.js')}}"></script>

    <link rel="stylesheet" type="text/css" href="{{url('/assets/plugins/bootstrap/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('/assets/plugins/animate-it/animate.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('/assets/css/lib/cmp-bs-checkbox.css')}}">

    <link rel="stylesheet" type="text/css" href="{{url('/assets/css/lib/page-login.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('/assets/css/style-default.css')}}">
</head>

<body>

    <div class="container">

        <div class="animatedParent">
            <div class="row">


                <?php $company = \App\CompanyProfile::find(1); ?>
                <div class="col-xs-12 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-lg-4 col-lg-offset-4">

                    <div class="blue-line sm normal"></div>

                    <div class="signup-box">
                        <div class="logo">
                            <h3>{{$company->nama_toko}} <br /> <small>Alamat : {{$company->alamat}}</small></h3>
                        </div>

                        <form action="{{url('/login_applikasi')}}" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="text" maxlength="20" name="username" class="form-control" placeholder="Username">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="Password">
                                <i class="fa fa-lock" aria-hidden="true"></i>

                            </div>
                            <div class="form-group">
                                <select name="hak_akses" required class="form-control">
                                    <option value="" selected disabled>Pilih Hak Akses</option>
                                    <option value="1">Admin</option>
                                    <option value="2">Karyawan</option>
                                </select>
                                <i class="fa fa-lock" aria-hidden="true"></i>

                            </div>

                            <button href="#" type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>


                    <div class="blue-line lg normal"></div>
                </div>
            </div>
        </div>
    </div>  <!-- Container End -->


    <script type="text/javascript" src="{{url('/assets/plugins/lib/jquery-2.2.4.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/plugins/lib/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/plugins/bootstrap/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/plugins/animate-it/animate-it.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/plugins/animate-it/arrow-line.js')}}"></script>
</body>
</html>
