@extends('layouts.frontend')

@section('body')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content left">
                        <h1 class="page-title">Struktur Organisasi</h1>
                        <p>Berikut adalah struktur organisasi serta pengajar di TPQ Imam Syafi'i Banjarmasin.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content right">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('beranda') }}">Beranda</a></li>
                            <li>Struktur</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-area section">
        <div class="container">

            @isset($pengelola)
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 col-12">
                        <div class="section-title">
                            <h2 class="wow fadeInUp" data-wow-delay=".4s">
                                Administrator
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($pengelola as $item)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="team-card wow fadeInUp" data-wow-delay=".3s">
                                <div class="team-img">
                                    <img
                                        src="{{ \App\Helpers\UserHelpers::getUserImage($item->foto, $item->jenis_kelamin) }}"
                                        alt="{{ $item->nama }}"/>
                                    <div class="team-social-icon">
                                        <ul class="social-link">
                                            <li>
                                                <a href="{{ 'https://wa.me/' . substr_replace($item->no_telp, '62', 0, 1) }}"><i class="fab fa-whatsapp"></i></a>
                                            </li>
                                            <li>
                                                <a href="{{ 'tel:' . substr_replace($item->no_telp, '62', 0, 1) }}"><i class="fas fa-phone"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="content">
                                    <h3>{{ $item->nama }}</h3>
                                    <span>{{ $item->jabatan }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endisset

            @if(count($ustaz))
                <div class="row mt-3">
                    <div class="col-lg-8 offset-lg-2 col-12">
                        <div class="section-title">
                            <h2 class="wow fadeInUp" data-wow-delay=".5s">
                                Pengajar Laki-laki
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($ustaz as $item)
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="team-card wow fadeInUp" data-wow-delay=".3s">
                                <div class="team-img">
                                    <img src="{{ \App\Helpers\UserHelpers::getUserImage($item->foto, 'L') }}"
                                         alt="{{ $item->nama }}"/>
                                    <div class="team-social-icon">
                                        <ul class="social-link">
                                            <li>
                                                <a href="{{ 'https://wa.me/' . substr_replace($item->no_telp, '62', 0, 1) }}"><i class="fab fa-whatsapp"></i></a>
                                            </li>
                                            <li>
                                                <a href="{{ 'tel:' . substr_replace($item->no_telp, '62', 0, 1) }}"><i class="fas fa-phone"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="content">
                                    <h3>{{ $item->nama }}</h3>
                                    @if($item->kelas)
                                    <span>{{ 'Kelas ' . $item->kelas->nama_kelas . ' ' . $item->kelas->jenis_kelas }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if(count($ustazah))
                <div class="row mt-3">
                    <div class="col-lg-8 offset-lg-2 col-12">
                        <div class="section-title">
                            <h2 class="wow fadeInUp" data-wow-delay=".5s">
                                Pengajar Perempuan
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($ustazah as $item)
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="team-card wow fadeInUp" data-wow-delay=".3s">
                                <div class="team-img">
                                    <img src="{{ \App\Helpers\UserHelpers::getUserImage($item->foto, 'P') }}"
                                         alt="{{ $item->nama }}"/>
                                    <div class="team-social-icon">
                                        <ul class="social-link">
                                            <li>
                                                <a href="{{ 'https://wa.me/' . substr_replace($item->no_telp, '62', 0, 1) }}"><i class="fab fa-whatsapp"></i></a>
                                            </li>
                                            <li>
                                                <a href="{{ 'tel:' . substr_replace($item->no_telp, '62', 0, 1) }}"><i class="fas fa-phone"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="content">
                                    <h3>{{ $item->nama }}</h3>
                                    @if($item->kelas)
                                        <span>{{ 'Kelas ' . $item->kelas->nama_kelas . ' ' . $item->kelas->jenis_kelas }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
@endsection
