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
                        <a href="{{ route('santri.dashboard') }}"
                           class="nav-link {{ Route::is('santri.dashboard') ? 'active' : '' }}">Beranda</a>
                    </li>
                    @if(Auth::user()->santri->kelas)
                        <li class="nav-item">
                            <a href="{{ route('santri.kelas') }}"
                               class="nav-link {{ Route::is('santri.kelas') ? 'active' : '' }}">Kelas</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('santri.spp.index') }}"
                               class="nav-link {{ Route::is('santri.spp.*') ? 'active' : '' }}">SPP</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ route('santri.pengumuman.index') }}"
                           class="nav-link {{ Route::is('santri.pengumuman.*') ? 'active' : '' }}">Pengumuman</a>
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
                             style="width: 35px; height: 35px; background-repeat: no-repeat;background-size: 35px; background-position: center; background-image: url('{{ \App\Helpers\UserHelpers::getAuthSantriImage() }}') ;"></div>
                    </div>
                </li>
                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <span class="font-weight-bold">
                            {{ \Illuminate\Support\Facades\Auth::user()->santri->nama_panggilan }}
                            <i class="fas fa-chevron-down ml-2"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                        <a href="{{ route('santri.akun') }}" class="dropdown-item">Akun</a>
                        <a href="{{ route('santri.profil') }}" class="dropdown-item">Profil</a>
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

