@extends('layouts.frontend')

@section('body')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content left">
                        <h1 class="page-title">Pendaftaran Santri</h1>
                        <p>Pendaftaran santri dilaksanakan gelombang 1 yang berlangsung pada 1 Muharram - 1 Safar
                            1443.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content right">
                        <ul class="breadcrumb-nav">
                            <li><a href="index.html">Beranda</a></li>
                            <li>Pendaftaran</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($spp->count())
        <section id="pricing" class="pricing-table section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 col-12">
                        <div class="section-title">
                            <h2 class="wow fadeInUp" data-wow-delay=".4s">
                                Biaya Pendidikan (SPP)
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($spp as $item)
                        <div class="{{ $class_spp }}">
                            <div class="single-table wow fadeInUp" data-wow-delay=".7s">
                                <div class="table-head">
                                    <h4 class="title">
                                        {{ $item->opsi }} <span>{{ $item->keterangan ?: $item->opsi }}</span>
                                    </h4>
                                    <div class="price">
                                        <p class="amount">
                                            <span class="curency" style="font-size: small;">Rp</span>
                                            {{ sprintf("%02dk", ($item->jumlah/1000)) }}
                                            <span class="duration">/bln</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($profil->is_pendaftaran)
    <section class="call-action section overlay">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12 wow fadeInLeft" data-wow-delay=".3s">
                    <div class="section-title">
                        <span>Pendaftaran</span>
                        <h2>
                            Daftarkan anak Anda di TPQ Imam Syafi'i Banjarmasin
                        </h2>
                        <p>
                            Usia minimum untuk mendaftar adalah 6 tahun.
                        </p>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-12 wow fadeInRight" data-wow-delay=".4s">
                    <div class="right-form">
                        <div class="section-heading">
                            <span class="small">Formulir Pendaftaran SantriZ</span>
                            <h4>TPQ Imam Syafi'i Banjarmasin</h4>
                        </div>
                        <div class="contact-form-box">
                            <form method="post" action="assets/mail/mail.php" class="mailform">
                                <div class="row">
                                    <div class="col-12">
                                        <input type="text" name="name" placeholder="Nama Lengkap"/>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <input type="text" name="name" placeholder="Nama Panggilan"/>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <input type="text" name="name" placeholder="Jenis Kelamin"/>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <input type="text" name="place" placeholder="Tempat Lahir"/>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <input type="date" name="date" placeholder="Tanggal Lahir"/>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <input type="text" name="name" placeholder="Nama Ayah"/>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <input type="text" name="name" placeholder="Nama Ibu"/>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="name" placeholder="No. Telp Wali"/>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <input type="text" name="name" placeholder="Anak ke-..."/>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <input type="text" name="name" placeholder="Dari ... bersaudara"/>
                                    </div>
                                    <div class="col-12">
                                        <textarea name="message" rows="5" placeholder="Alamat"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="name" placeholder="Biaya Pendidikan"/>
                                    </div>
                                    <div class="button col-12 mt-3">
                                        <button type="submit" class="btn white-bg mouse-dir">
                                            Daftar <span class="dir-part"></span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

@endsection
