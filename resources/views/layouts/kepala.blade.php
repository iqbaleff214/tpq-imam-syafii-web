<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Beranda | TPQ Imam Syafi'i Banjarmasin</title>

	<link rel="shortcut icon" type="image/x-icon" href="" />

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome Icons -->
	<script src="https://kit.fontawesome.com/b8cc568f15.js" crossorigin="anonymous"></script>
    @stack('link')
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
</head>
<body class="sidebar-mini accent-maroon" style="height: auto;">
    <!-- Site wrapper -->
    <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand border-bottom-0 navbar-dark navbar-maroon">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item d-none d-md-block">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <span class="font-weight-bold">{{ Auth::user()->administrator->jabatan  }}<i class="fas fa-chevron-down ml-2"></i></span>
                </a>
                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                    <a href="{{ route('kepala.profil') }}" class="dropdown-item">Profil</a>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar elevation-4 sidebar-no-expand sidebar-light-maroon">
        <!-- Brand Logo -->
        <a href=" {{ route('kepala.dashboard') }}" class="brand-link navbar-light">
            <img src="{{ asset('logo.png') }}" alt="{{ env('APP_NAME') }}" class="brand-image">
            <span class="brand-text text-maroon">TPQ Imam Syafi'i</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <div class="img-circle" style="width: 35px; height: 35px; background-repeat: no-repeat;background-size: 35px; background-position: center; background-image: url('{{ Auth::user()->administrator->foto ? asset('storage/'.Auth::user()->administrator->foto) : asset('images/ikhwan.jpg') }}') ;"></div>
                </div>
                <div class="info">
                    <a href="{{ route('kepala.profil') }}" class="d-block">{{ Auth::user()->administrator->nama  }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-compact nav-child-indent nav-collapse-hide-child"
                    data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ route('kepala.dashboard') }}" class="nav-link {{ Route::is('kepala.dashboard') ? 'active': '' }}">
                            <i class="nav-icon fas fa-desktop"></i>
                            <p>Dasbor</p>
                        </a>
                    </li>

                    <li class="nav-header">PENGELOLA DAN PENGAJAR</li>

                    <li class="nav-item">
                        <a href="{{ route('kepala.admin.index') }}" class="nav-link {{ Route::is('kepala.admin.*') ? 'active': '' }}">
                            <i class="nav-icon fas fa-user-cog"></i>
                            <p>Administrator</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('kepala.pengajar.index') }}" class="nav-link {{ Route::is('kepala.pengajar.*') ? 'active': '' }}">
                            <i class="nav-icon fas fa-chalkboard-teacher"></i>
                            <p>Pengajar</p>
                        </a>
                    </li>

                    <li class="nav-header">PENDIDIKAN DAN KURIKULUM</li>

                    <li class="nav-item">
                        <a href="{{ route('kepala.kalender.index') }}" class="nav-link {{ Route::is('kepala.kalender.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>Kalender Pendidikan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('kepala.kurikulum.index') }}" class="nav-link {{ Route::is('kepala.kurikulum.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Kurikulum</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('kepala.kelas.index') }}" class="nav-link {{ Route::is('kepala.kelas.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chalkboard"></i>
                            <p>Kelas</p>
                        </a>
                    </li>

                    <li class="nav-header">LAPORAN</li>
                    <li class="nav-item {{ Route::is('kepala.keuangan.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Route::is('kepala.keuangan.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-coins"></i>
                            <p> Keuangan <i class="fas fa-angle-left right"></i> </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('kepala.keuangan.kas') }}" class="nav-link {{ Route::is('kepala.keuangan.kas') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kas</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('kepala.keuangan.honor') }}" class="nav-link {{ Route::is('kepala.keuangan.honor') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Honor Pengajar</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>SPP Santri</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p> Kehadiran <i class="fas fa-angle-left right"></i> </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="pages/tables/simple.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengajar</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/tables/data.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Santri</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Santri</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-boxes"></i>
                            <p>Inventaris Barang</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-handshake"></i>
                            <p>Rapat</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    @yield('body')

    <footer class="main-footer text-sm">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 1.0
        </div>
        <strong>Copyright © {{ date('Y')=='2021' ? '2021' : '2021-'.date('Y') }} <a href="#">{{ env('APP_NAME') }}.</strong> All rights reserved.
    </footer>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
            crossorigin="anonymous"></script>
    <!--Sweet alert 2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>
    @include('sweetalert::alert')
    @stack('script')
    </body>
    </html>


