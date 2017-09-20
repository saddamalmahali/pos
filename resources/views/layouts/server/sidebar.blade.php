<aside class="side-navigation-wrap sidebar-fixed">  <!-- START: Side Navigation -->
    <div class="sidenav-inner">

        <ul class="side-nav magic-nav">

            <li class="side-nav-header">Navigation</li>

            <li>
                <a href="{{url('/home')}}"><i class="sli-dashboard"></i> <span class="nav-text">Dashboard</span></a>
            </li>


            <li class="has-submenu">
                <a href="#submenuOne" data-toggle="collapse" aria-expanded="false">
                    <i class="fs-grid-6"></i>
                    <span class="nav-text">Master Data</span>
                </a>
                <div class="sub-menu collapse secondary" id="submenuOne">
                    <ul>
                        <li><a href="{{url('/master/karyawan')}}" {{url()->full() == url('/master/karyawan') ? 'active' : ''}}>Karyawan</a></li>
                        <li><a href="{{url('/master/barang')}}">Master Barang</a></li>
                        <li><a href="{{url('/master/admin/pembeli')}}">Data Pembeli</a></li>
                        <li><a href="{{url('/master/supplier')}}">Data Supplier</a></li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-header">Transaksi</li>
            <li>
                <a href="{{url('/admin/transaksi/penjualan')}}" >
                    <i class="fa fa-money"></i>
                    <span class="nav-text">Penjualan</span>
                </a>

            </li>
            <li>
                <a href="{{url('/admin/transaksi/pembelian')}}" >
                    <i class="fa fa-cart-arrow-down"></i>
                    <span class="nav-text">Pembelian</span>
                </a>

            </li>
            <li class="side-nav-header">Laporan</li>
            <li>
                <a href="{{url('/admin/laporan/stok')}}" >
                    <i class="fa fa-cubes"></i>
                    <span class="nav-text">Stok Barang</span>
                </a>
            </li>
            <li>
                <a href="{{url('/admin/laporan/penjualan')}}" >
                    <i class="fa fa-bar-chart"></i>
                    <span class="nav-text">Laporan Penjualan</span>
                </a>
            </li>
            <li>
                <a href="{{url('/admin/laporan/pembelian')}}" >
                    <i class="fa fa-bar-chart"></i>
                    <span class="nav-text">Laporan Pembelian</span>
                </a>
            </li>

            <li class="side-nav-header">Help</li>
            <li>
                <a href="{{url('/admin/setting/index')}}" >
                    <i class="fa fa-gear"></i>
                    <span class="nav-text">Setting Toko</span>
                </a>
                <a href="{{url('/admin/laporan/index')}}" >
                    <i class="fa fa-info-circle"></i>
                    <span class="nav-text">Tentang</span>
                </a>
            </li>
        </ul>

    </div><!-- END: sidebar-inner -->

</aside>    <!-- END: Side Navigation -->
