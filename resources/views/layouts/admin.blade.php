@extends('layouts.backend-admin')

@section('sidebar')
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
                    <span class="font-weight-bold">{{ Auth::user()->administrator->jabatan  }}<i
                            class="fas fa-chevron-down ml-2"></i></span>
                </a>
                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                    <a href="{{ route('admin.akun') }}" class="dropdown-item">Akun</a>
                    <a href="{{ route('admin.profil') }}" class="dropdown-item">Profil</a>
                    <a href="{{ route('logout') }}" class="dropdown-item" id="logout-button">Keluar</a>
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
        <a href=" {{ route('admin.dashboard') }}" class="brand-link navbar-light">
            <img src="{{ asset('logo.png') }}" alt="{{ env('APP_NAME') }}" class="brand-image">
            <span class="brand-text text-maroon">TPQ Imam Syafi'i</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <div class="img-circle"
                         style="width: 35px; height: 35px; background-repeat: no-repeat;background-size: 35px; background-position: center; background-image: url('{{ \App\Helpers\UserHelpers::getAuthImage() }}') ;"></div>
                </div>
                <div class="info">
                    <a href="{{ route('admin.profil') }}" class="d-block">{{ Auth::user()->administrator->nama  }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-compact nav-child-indent nav-collapse-hide-child"
                    data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                           class="nav-link {{ Route::is('admin.dashboard') ? 'active': '' }}">
                            <i class="nav-icon fas fa-desktop"></i>
                            <p>Dasbor</p>
                        </a>
                    </li>

                    <li class="nav-header">ENTITAS PENGGUNA</li>

                    <li class="nav-item">
                        <a href="{{ route('admin.pengajar.index') }}"
                           class="nav-link {{ Route::is('admin.pengajar.*') ? 'active': '' }}">
                            <i class="nav-icon fas fa-chalkboard-teacher"></i>
                            <p>Pengajar</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.santri.index') }}"
                           class="nav-link {{ Route::is('admin.santri.*') ? 'active': '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Santri</p>
                        </a>
                    </li>

                    <li class="nav-header">PENDIDIKAN DAN KURIKULUM</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.kalender.index') }}" class="nav-link {{ Route::is('admin.kalender.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>Kalender Pendidikan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.kurikulum.index') }}"
                           class="nav-link {{ Route::is('admin.kurikulum.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Kurikulum</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.kelas.index') }}"
                           class="nav-link {{ Route::is('admin.kelas.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chalkboard"></i>
                            <p>Kelas</p>
                        </a>
                    </li>

                    <li class="nav-header">ADMINISTRASI</li>
                    <li class="nav-item {{ Route::is('admin.keuangan.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Route::is('admin.keuangan.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-coins"></i>
                            <p> Keuangan <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.keuangan.kas.index') }}"
                                   class="nav-link {{ Route::is('admin.keuangan.kas.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Kas</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.keuangan.honor.index') }}"
                                   class="nav-link {{ Route::is('admin.keuangan.honor.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Honor</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.keuangan.donasi.index') }}"
                                   class="nav-link {{ Route::is('admin.keuangan.donasi.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Donasi</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {{ Route::is('admin.spp.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Route::is('admin.spp.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-invoice-dollar"></i>
                            <p> SPP <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.spp.opsi.index') }}"
                                   class="nav-link {{ Route::is('admin.spp.opsi.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Opsi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('kepala.keuangan.honor') }}"
                                   class="nav-link {{ Route::is('kepala.keuangan.honor') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pembayaran</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {{ Route::is('admin.kehadiran.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Route::is('admin.kehadiran.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-table"></i>
                            <p> Kehadiran <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.kehadiran.pengajar.index') }}" class="nav-link {{ Route::is('admin.kehadiran.pengajar.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pengajar</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.kehadiran.santri.index') }}" class="nav-link {{ Route::is('admin.kehadiran.santri.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Santri</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.inventaris.index') }}"
                           class="nav-link {{ Route::is('admin.inventaris.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-boxes"></i>
                            <p>Inventaris Barang</p>
                        </a>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a href="#" class="nav-link">--}}
{{--                            <i class="nav-icon fas fa-handshake"></i>--}}
{{--                            <p>Rapat</p>--}}
{{--                        </a>--}}
{{--                    </li>--}}

                    <li class="nav-header">HALAMAN WEB</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.fasilitas.index') }}" class="nav-link {{ Route::is('admin.fasilitas.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-toolbox"></i>
                            <p>Fasilitas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.pesan.index') }}" class="nav-link {{ Route::is('admin.pesan.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-mail-bulk"></i>
                            <p>Pesan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.pengumuman.index') }}" class="nav-link {{ Route::is('admin.pengumuman.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-info"></i>
                            <p>Pengumuman</p>
                        </a>
                    </li>
                    <li class="nav-item {{ Route::is('admin.galeri.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Route::is('admin.galeri.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-images"></i>
                            <p> Galeri Kegiatan <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.galeri.kategori.index') }}" class="nav-link {{ Route::is('admin.galeri.kategori.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Kategori</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.galeri.index') }}" class="nav-link {{ Route::is('admin.galeri.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Galeri</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header">PENGATURAN</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.akun') }}" class="nav-link {{ Route::is('admin.akun') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>Akun</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.profil') }}" class="nav-link {{ Route::is('admin.profil') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-cog"></i>
                            <p>Profil</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.lembaga.index') }}" class="nav-link {{ Route::is('admin.lembaga.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-building"></i>
                            <p>Lembaga</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
@endsection

