<header class="header-top navbar fixed-top">
    
    <div class="top-bar">   <!-- START: Responsive Search -->
        <div class="container">
            <div class="main-search">
                <div class="input-wrap">
                    <input class="form-control" type="text" placeholder="Search Here...">
                    <a href="page-search.php"><i class="sli-magnifier"></i></a>
                </div>
                <span class="close-search search-toggle"><i class="ti-close"></i></span>
            </div>
        </div>
    </div>  <!-- END: Responsive Search -->


    <div class="navbar-header">
        <button type="button" class="navbar-toggle side-nav-toggle">
            <i class="ti-align-left"></i>
        </button>


        <a class="navbar-brand" href="{{url('/')}}">
            <span class="text-center">&nbsp;&nbsp;&nbsp;<b>Q'La Computer</b></span>
        </a>


        <ul class="nav navbar-nav-xs">  <!-- START: Responsive Top Right tool bar -->
            <li>
                <a href="javascript:;" class="collapse" data-toggle="collapse" data-target="#headerNavbarCollapse">
                    <i class="sli-user"></i>
                </a>
            </li>
            
        </ul>   <!-- END: Responsive Top Right tool bar -->
        
    </div>
    
    <div class="collapse navbar-collapse" id="headerNavbarCollapse">
        
        <ul class="nav navbar-nav">
            <li class="hidden-xs">
                <a href="javascript:;" class="sidenav-size-toggle">
                    <i class="ti-align-left"></i>
                </a>
            </li>
        </ul>
        
        <ul class="nav navbar-nav navbar-right">
            
            
            <li class="user-profile dropdown">
                <a href="javascript:;" class="clearfix dropdown-toggle" data-toggle="dropdown">
                    <?php 
                        $img = '';
                        if(auth('karyawan')->user()->foto != null || auth('karyawan')->user()->foto != ''){
                            $img = auth('karyawan')->user()->foto;
                        }else{
                            $img = 'img/blank-user-medium.png';
                        }
                    ?>
                    <img src="{{url($img)}}" alt="" class="hidden-sm">
                    <div class="user-name">{{auth('karyawan')->user()->nama_lengkap}} <small class="fa fa-angle-down"></small></div>
                </a>
                <ul class="dropdown-menu dropdown-animated pop-effect" role="menu">
                    <li><a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="sli-logout"></i> Logout</a></li>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </ul>
            </li>
            
        </ul>
        
    </div><!-- END: Navbar-collapse -->
    
</header>   <!-- END: Header -->