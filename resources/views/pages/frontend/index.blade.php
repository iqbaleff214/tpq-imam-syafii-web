@extends('layouts.frontend')

@section('meta')
    <meta name="description" content="{{ $profil->deskripsi }}"/>
@endsection

@section('body')
    <section class="hero-slider">

        <div class="single-slider">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-6 co-12">
                        <div class="home-slider">
                            <div class="hero-text">
                                <h1 class="wow fadeInUp" data-wow-delay=".5s">{{ $profil->nama }}</h1>
                                <p class="wow fadeInUp" data-wow-delay=".7s">
                                    {{ $profil->deskripsi }}
                                </p>
                            </div>
                            @if($profil->is_pendaftaran)
                            <div class="hero-text">
                                <h1><span>Penerimaan</span><br>Santri Baru</h1>
                                <p>
                                    Kurikulum Taman Pendidikan Al-Qur’an (TPQ) Imam Syafi’i disusun dari berbagai sumber
                                    dengan memperhatikan atau berpedoman Al-Qur’an dan As-sunnah.
                                </p>
                            </div>
                            @endif
                            <div class="hero-text">
                                <h1><span>TPQ Imam Syafi'i</span><br>Banjarmasin</h1>
                                <p>
                                    Kurikulum Taman Pendidikan Al-Qur’an (TPQ) Imam Syafi’i disusun dari berbagai sumber
                                    dengan memperhatikan atau berpedoman Al-Qur’an dan As-sunnah.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <section class="Features section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="feature-right wow fadeInUp" data-wow-delay=".3s">
                        <div class="watch-inner">
                            <div class="video-head wow zoomIn" data-wow-delay="0.4s">
                                <a
                                    href="https://www.youtube.com/watch?v=3uUh5ywVEfQ"
                                    class="glightbox video"><i class="fas fa-play"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="feature-content">
                        <div class="title">
                            <span class="wow fadeInRight" data-wow-delay=".3s">Visi dan Misi</span>
                            <h4 class="wow fadeInRight my-2" data-wow-delay=".5s"> Visi </h4>
                            <p class="wow fadeInRight my-3" data-wow-delay=".6s">
                                {{ $profil->visi }}
                            </p>
                            <h4 class="wow fadeInRight mt-2" data-wow-delay=".5s"> Misi </h4>
                        </div>
                        <div class="feature-item wow fadeInUp" data-wow-delay=".5s">
                            <div class="feature-thumb">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="banner-content">
                                <p>
                                    Mengajarkan dan menamankan akidah yang sesuai dengan al Qur’an dan as Sunnah sedari
                                    dini.
                                </p>
                            </div>
                        </div>
                        <div class="feature-item wow fadeInUp" data-wow-delay=".5s">
                            <div class="feature-thumb">
                                <i class="fas fa-smile-beam"></i>
                            </div>
                            <div class="banner-content">
                                <p>
                                    Membiasakan santri untuk berakhlak mulia pada diri sendiri, keluarga, dan masyarakat
                                    sekitar.
                                </p>
                            </div>
                        </div>
                        <div class="feature-item wow fadeInUp" data-wow-delay=".5s">
                            <div class="feature-thumb">
                                <i class="fas fa-book-reader"></i>
                            </div>
                            <div class="banner-content">
                                <p>
                                    Mengajarkan dan memahamkan cara baca tulis Al-Qur’an yang berdasar kepada ilmu
                                    tajwid.
                                </p>
                            </div>
                        </div>
                        <div class="feature-item wow fadeInUp" data-wow-delay=".5s">
                            <div class="feature-thumb">
                                <i class="fas fa-pray"></i>
                            </div>
                            <div class="banner-content">
                                <p>
                                    Mengajarkan doa–doa untuk diterapkan dalam kehidupan sehari-hari.
                                </p>
                            </div>
                        </div>
                        <div class="feature-item wow fadeInUp" data-wow-delay=".5s">
                            <div class="feature-thumb">
                                <i class="fas fa-mosque"></i>
                            </div>
                            <div class="banner-content">
                                <p>
                                    Mengajarkan dan membiasakan praktik tata cara salat yang benar.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="fun-facts" class="fun-facts overlay">
        <div class="fun-inner">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-fun wow fadeIn" data-wow-delay=".3s">
                            <div class="head">
                                <div class="icon"><i class="fas fa-male"></i></div>
                                <div class="counter">
                                    <span id="secondo1" class="countup"
                                          cup-end="{{ $count['santri'] }}">{{ $count['santri'] }}</span>
                                </div>
                                <h2>Santri laki-laki</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-fun wow fadeIn" data-wow-delay=".5s">
                            <div class="head">
                                <div class="icon"><i class="fas fa-female"></i></div>
                                <div class="counter">
                                    <span id="secondo2" class="countup"
                                          cup-end="{{ $count['santriwati'] }}">{{ $count['santriwati'] }}</span>
                                </div>
                                <h2>Santri Perempuan</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-fun wow fadeIn" data-wow-delay=".7s">
                            <div class="head">
                                <div class="icon"><i class="fas fa-users"></i></div>
                                <div class="counter">
                                    <span id="secondo3" class="countup"
                                          cup-end="{{ $count['kelas'] }}">{{ $count['kelas'] }}</span>
                                </div>
                                <h2>Kelompok Belajar</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-fun wow fadeIn" data-wow-delay=".9s">
                            <div class="head">
                                <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
                                <div class="counter">
                                    <span id="secondo4" class="countup"
                                          cup-end="{{ $count['pengajar'] }}">{{ $count['pengajar'] }}</span>
                                </div>
                                <h2>Pengajar</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="services section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <div class="section-title">
                        <span class="wow fadeInDown" data-wow-delay=".2s">Fasilitas</span>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Fasilitas Pendukung</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-service wow fadeInUp" data-wow-delay=".2s">
                        <div class="serial">
                            <span><i class="fas fa-chalkboard-teacher"></i></span>
                        </div>
                        <h3><a href="service-single.html">Ruang Pembelajaran</a></h3>
                        <p>
                            Ruang Utama pembelajaran berada di teras Masjid untuk santri dan pengajar laki–laki dan di
                            dalam masjid tempat salat jamaah wanita pembelajaran untuk santri dan pengajar perempuan.
                        </p>
                        <div class="circles-wrap">
                            <div class="circles">
                                <span class="circle circle-1"></span>
                                <span class="circle circle-2"></span>
                                <span class="circle circle-3"></span>
                                <span class="circle circle-4"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-service wow fadeInUp" data-wow-delay=".3s">
                        <div class="serial">
                            <span><i class="fas fa-book"></i></span>
                        </div>
                        <h3><a href="service-single.html">Perpustakaan Masjid</a></h3>
                        <p>
                            Yang tersedia saat ini baru berupa sarana pembelajaran.
                        </p>
                        <div class="circles-wrap">
                            <div class="circles">
                                <span class="circle circle-1"></span>
                                <span class="circle circle-2"></span>
                                <span class="circle circle-3"></span>
                                <span class="circle circle-4"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-service wow fadeInUp" data-wow-delay=".4s">
                        <div class="serial">
                            <span><i class="fas fa-chalkboard"></i></span>
                        </div>
                        <h3><a href="service-single.html">Peralatan Pembelajaran</a></h3>
                        <p>
                            Tersedia meja belajar, papan tulis, Al-Qur'an dan Buku Iqro, buku modul pembelajaran dan
                            buku pendukung pembelajaran lainnya.
                        </p>
                        <div class="circles-wrap">
                            <div class="circles">
                                <span class="circle circle-1"></span>
                                <span class="circle circle-2"></span>
                                <span class="circle circle-3"></span>
                                <span class="circle circle-4"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-service wow fadeInUp" data-wow-delay=".2s">
                        <div class="serial">
                            <span><i class="fas fa-chalkboard-teacher"></i></span>
                        </div>
                        <h3><a href="service-single.html">Ruang Pembelajaran</a></h3>
                        <p>
                            Ruang Utama pembelajaran berada di teras Masjid untuk santri dan pengajar laki–laki dan di
                            dalam masjid tempat salat jamaah wanita pembelajaran untuk santri dan pengajar perempuan.
                        </p>
                        <div class="circles-wrap">
                            <div class="circles">
                                <span class="circle circle-1"></span>
                                <span class="circle circle-2"></span>
                                <span class="circle circle-3"></span>
                                <span class="circle circle-4"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-service wow fadeInUp" data-wow-delay=".3s">
                        <div class="serial">
                            <span><i class="fas fa-book"></i></span>
                        </div>
                        <h3><a href="service-single.html">Perpustakaan Masjid</a></h3>
                        <p>
                            Yang tersedia saat ini baru berupa sarana pembelajaran.
                        </p>
                        <div class="circles-wrap">
                            <div class="circles">
                                <span class="circle circle-1"></span>
                                <span class="circle circle-2"></span>
                                <span class="circle circle-3"></span>
                                <span class="circle circle-4"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-service wow fadeInUp" data-wow-delay=".4s">
                        <div class="serial">
                            <span><i class="fas fa-chalkboard"></i></span>
                        </div>
                        <h3><a href="service-single.html">Peralatan Pembelajaran</a></h3>
                        <p>
                            Tersedia meja belajar, papan tulis, Al-Qur'an dan Buku Iqro, buku modul pembelajaran dan
                            buku pendukung pembelajaran lainnya.
                        </p>
                        <div class="circles-wrap">
                            <div class="circles">
                                <span class="circle circle-1"></span>
                                <span class="circle circle-2"></span>
                                <span class="circle circle-3"></span>
                                <span class="circle circle-4"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="testimonials" class="section testimonials">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <div class="section-title">
                        <span class="wow fadeInDown" data-wow-delay=".2s">Testimoni</span>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">
                            Apa Kata Mereka?
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="testimonial-slider">
                        <div class="single-testimonial">
                            <div class="client1">
                                <img src="{{ asset('bizfinity/images/team1.jpg') }}" alt="Images"
                                     style="height: 100%;"/>
                            </div>
                            <i class="fas fa-quote-right"></i>
                            <p>
                                "Pendidikan Al-Qur'an diajarkan berdasarkan syariat Islam. MasyaAllah."
                            </p>
                            <div class="bottom">
                                <h4 class="name">
                                    Fulan<span>Wali Santri</span>
                                </h4>
                            </div>
                        </div>
                        <div class="single-testimonial">
                            <div class="client1">
                                <img src="{{ asset('bizfinity/images/team2.jpg') }}" alt="Images"
                                     style="height: 100%;"/>
                            </div>
                            <i class="fas fa-quote-right"></i>
                            <p>
                                "Pendidikan Al-Qur'an diajarkan berdasarkan syariat Islam. MasyaAllah."
                            </p>
                            <div class="bottom">
                                <h4 class="name">
                                    Fulanah<span>Wali Santri</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img
            class="shape1 wow fadeInLeft"
            data-wow-delay=".8s"
            src="{{ asset('bizfinity/images/testi-shape1.png') }}"
            alt="#"
        />
    </section>

    @if(count($pengumuman))
        <section class="latest-news-area section">
            <div class="letast-news-grid">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2 col-12">
                            <div class="section-title">
                                <span class="wow fadeInDown" data-wow-delay=".2s">Pengumuman</span>
                                <h2 class="wow fadeInUp" data-wow-delay=".4s">
                                    Terbaru
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @forelse($pengumuman as $item)
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="letest-news-item wow fadeInUp" data-wow-delay=".4s">
                                    <div class="image">
                                        <img src="{{ \App\Helpers\UserHelpers::getInfoImage($item->foto) }}" alt="#"/>
                                    </div>
                                    <div class="content-body">
                                        <div class="meta-details">
                                            <div class="meta-list text-sm">
                                                <i class="fas fa-user mx-2"></i>
                                                <span>{{ $item->penulis->nama }}</span>
                                                <i class="fas fa-calendar mx-2"></i>
                                                <span>{{ $item->created_at->isoFormat('dddd, D MMMM YYYY') }}</span>
                                            </div>
                                        </div>
                                        <h4 class="title">
                                            <a href="{{ route('pengumuman.detail', $item->slug) }}">{{ $item->judul }}</a>
                                        </h4>
                                        <p>
                                            {{ \Illuminate\Support\Str::limit(strip_tags($item->konten), 255) }}
                                        </p>
                                        <div class="button">
                                            <a
                                                class="btn mouse-dir white-bg"
                                                href="{{ route('pengumuman.detail', $item->slug) }}">Selengkapnya <span
                                                    class="dir-part"></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-md-4 offset-md-4 text-center">
                                <p>Belum ada pengumuman.</p>
                                <div class="container">
                                    <img src="{{ asset('images/empty.jpg') }}" alt="Not Found">
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="client-logo-section">
        <div class="container">
            <div class="client-logo-wrapper">
                <div class="client-logo-carousel d-flex align-items-center justify-content-between">
                    {{--                    <div class="client-logo">--}}
                    {{--                        <img src="{{ asset('bizfinity/images/client1.png') }}" alt=""/>--}}
                    {{--                    </div>--}}
                    {{--                    <div class="client-logo">--}}
                    {{--                        <img src="{{ asset('bizfinity/images/client2.png') }}" alt=""/>--}}
                    {{--                    </div>--}}
                    {{--                    <div class="client-logo">--}}
                    {{--                        <img src="{{ asset('bizfinity/images/client3.png') }}" alt=""/>--}}
                    {{--                    </div>--}}
                    {{--                    <div class="client-logo">--}}
                    {{--                        <img src="{{ asset('bizfinity/images/client4.png') }}" alt=""/>--}}
                    {{--                    </div>--}}
                    {{--                    <div class="client-logo">--}}
                    {{--                        <img src="{{ asset('bizfinity/images/client5.png') }}" alt=""/>--}}
                    {{--                    </div>--}}
                    {{--                    <div class="client-logo">--}}
                    {{--                        <img src="{{ asset('bizfinity/images/client2.png') }}" alt=""/>--}}
                    {{--                    </div>--}}
                    {{--                    <div class="client-logo">--}}
                    {{--                        <img src="{{ asset('bizfinity/images/client3.png') }}" alt=""/>--}}
                    {{--                    </div>--}}
                    {{--                    <div class="client-logo">--}}
                    {{--                        <img src="{{ asset('bizfinity/images/client4.png') }}" alt=""/>--}}
                    {{--                    </div>--}}
                    {{--                    <div class="client-logo">--}}
                    {{--                        <img src="{{ asset('bizfinity/images/client5.png') }}" alt=""/>--}}
                    {{--                    </div>--}}
                </div>
            </div>
        </div>
    </section>

@endsection

@push('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/tiny-slider.css"
          integrity="sha512-eMxdaSf5XW3ZW1wZCrWItO2jZ7A9FhuZfjVdztr7ZsKNOmt6TUMTQgfpNoVRyfPE5S9BC0A4suXzsGSrAOWcoQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

@endpush

@push('script')
    <script !src="" type="javascript">
        document.addEventListener("DOMContentLoaded", function () {

            //========= glightbox
            GLightbox({
                href: "https://www.youtube.com/watch?v=3uUh5ywVEfQ",
                type: "video",
                source: "youtube", //vimeo, youtube or local
                width: 900,
                autoplayVideos: true,
            });
        });
    </script>
@endpush
