@extends('layouts.backend-user')

@section('navbar')


    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand-md navbar-dark navbar-maroon">
        <div class="container">
            <a href="{{ route('beranda') }}" class="navbar-brand text-white">
                <img src="{{ asset('logo.png') }}" alt="{{ config('app.name') }}" class="brand-image">
                <span class="brand-text">TPQ Imam Syafi'i</span>
            </a>

            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="{{ route('pengajar.dashboard') }}" class="nav-link {{ Route::is('pengajar.dashboard') ? 'active' : '' }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pengajar.pengumuman.index') }}" class="nav-link {{ Route::is('pengajar.pengumuman.*') ? 'active' : '' }}">Pengumuman</a>
                    </li>
                    @if(Auth::user()->pengajar->kelas)
                    <li class="nav-item">
                        <a href="{{ route('pengajar.santri.index') }}" class="nav-link {{ Route::is('pengajar.santri.*') ? 'active' : '' }}">Santri</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pengajar.kurikulum') }}" class="nav-link {{ Route::is('pengajar.kurikulum') ? 'active' : '' }}">Kurikulum</a>
                    </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false" class="nav-link dropdown-toggle {{ (Route::is('pengajar.kehadiran.*') or Route::is('pengajar.honor.*')) ? 'active' : '' }}">Lainnya</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="{{ route('pengajar.kehadiran.index') }}" class="dropdown-item">Kehadiran</a></li>
                            <li><a href="{{ route('pengajar.honor.index') }}" class="dropdown-item">Honor</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <!-- Right navbar links -->
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">

                <li class="nav-item d-none d-md-block">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-md-block">
                    <div class="image">
                        <div class="img-circle"
                             style="width: 35px; height: 35px; background-repeat: no-repeat;background-size: 35px; background-position: center; background-image: url('{{ \App\Helpers\UserHelpers::getAuthImage() }}') ;"></div>
                    </div>
                </li>
                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <span class="font-weight-bold">{{ \Illuminate\Support\Facades\Auth::user()->pengajar->nama }}<i
                                class="fas fa-chevron-down ml-2"></i></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                        <a href="{{ route('pengajar.akun') }}" class="dropdown-item">Akun</a>
                        <a href="{{ route('pengajar.profil') }}" class="dropdown-item">Profil</a>
                        <a href="{{ route('logout') }}" class="dropdown-item" id="logout-button">Keluar</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                </li>
            </ul>
        </div>
    </nav>
    <!-- /.navbar -->

@endsection

