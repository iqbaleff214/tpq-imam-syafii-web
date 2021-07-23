<!DOCTYPE html>
<html class="no-js" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <title>{{ $title }} - {{ config('app.name', $profil->nama) }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('adminlte/img/404nf.ico') }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="keywords" content="tpq, imam syafi'i banjarmasin, tpq imam syafi'i banjarmasin, tpq mis, {{ $profil->nama }}, {{ config('app.name') }}" />
    @yield('meta')
    <meta name="google" content="notranslate" />
    <!-- Web Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Overlay Scrollbars -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/css/OverlayScrollbars.min.css"
          integrity="sha512-jN4O0AUkRmE6Jwc8la2I5iBmS+tCDcfUd1eq8nrZIBnDKTmCp5YxxNN1/aetnAH32qT+dDbk1aGhhoaw5cJNlw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/b8cc568f15.js" crossorigin="anonymous"></script>

    <!-- ========================= CSS here ========================= -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.lineicons.com/3.0/lineicons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('bizfinity/css/animate.css') }}"/>
    <link rel="stylesheet" href="{{ asset('bizfinity/css/glightbox.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('bizfinity/css/mainn.css') }}"/>
    <link rel="stylesheet" href="{{ asset('bizfinity/css/reset.css') }}"/>
    <link rel="stylesheet" href="{{ asset('bizfinity/css/responsive.css') }}"/>
    @stack('link')
</head>
<body style="overflow-x: hidden">
<div class="preloader">
    <div class="preloader-inner">
        <div class="preloader-icon">
            <span></span>
            <span></span>
        </div>
    </div>
</div>

<header class="header navbar-area">

    <div class="toolbar-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-9 col-12">
                    <div class="toolbar-contact"><p><i class="lni lni-envelope"></i><a
                                href="mailto:{{ $profil->email }}"> {{ $profil->email }} </a></p>
                        <p><i class="lni lni-phone"></i><a href="tel:+123456789">(+62) 8215 914 2175</a></p>
                        <p><i class="lni lni-map-marker"></i> {{ $profil->alamat }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-3 col-12">
                    <div class="toolbar-sl-share">
                        <ul>
                            <li><a href="#"><i class="fab fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fab fa-whatsapp"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="nav-inner">
                    <nav class="navbar navbar-expand-lg">
                        <a class="navbar-brand logo" href="{{ route('beranda') }}">
                            <img src="{{ asset('logo.png') }}"
                                 alt="{{ config('app.name') }}" style="width: 75px;">
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                            <ul id="nav" class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a class="{{ Route::is('beranda') ? 'active' : '' }}" href="{{ route('beranda') }}">Beranda</a>
                                </li>
                                <li class="nav-item">
                                    <a class="{{ Route::is('pengumuman*') ? 'active' : '' }}"
                                       href="{{ route('pengumuman') }}">Pengumuman</a>
                                </li>
                                <li class="nav-item">
                                    <a class="{{ Route::is('galeri') ? 'active' : '' }}"
                                       href="{{ route('galeri') }}">Galeri</a>
                                </li>
                                <li class="nav-item">
                                    <a class="{{ Route::is('donasi') ? 'active' : '' }}"
                                       href="{{ route('donasi') }}">Donasi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="{{ Route::is('pendaftaran') ? 'active' : '' }}"
                                       href="{{ route('pendaftaran') }}">Pendaftaran</a>
                                </li>
                                <li class="nav-item">
                                    <a class="{{ Route::is('struktur') ? 'active' : '' }}"
                                       href="{{ route('struktur') }}">Struktur</a>
                                </li>
                                <li class="nav-item">
                                    <a class="{{ Route::is('hubungi') ? 'active' : '' }}" href="{{ route('hubungi') }}">Hubungi
                                        Kami</a>
                                </li>
                            </ul>
                        </div>
                        <div class="button">
                            <a href="{{ route('login') }}" class="btn white-bg mouse-dir">
                                Masuk <span class="dir-part"></span>
                            </a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>

@yield('body')

<section class="newsletter section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="subscribe-text wow fadeInLeft" data-wow-delay=".3s">
                    <h6>Donasi</h6>
                    <p class="">
                        Berikan infaq terbaik Anda untuk keberlangsungan pendidikan Al-Qur'an untuk anak-anak. Jangan
                        sia-siakan kesempatan Anda untuk mendapatkan pahala jariyah.
                    </p>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="subscribe-form wow fadeInRight" data-wow-delay=".5s">
                    <form
                        action="{{ route('donasi') }}"
                        method="get"
                        target="_blank"
                        class="newsletter-inner">
                        <input
                            name="donasi"
                            placeholder="Rp0"
                            class="common-input text-white"
                            onfocus="this.placeholder = 'Rp0'"
                            onblur="this.placeholder = 'Rp0'"
                            required=""
                            type="number"
                            autocomplete="off"/>
                        <div class="button">
                            <button class="btn mouse-dir white-bg">
                                Donasi! <span class="dir-part"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer">
    <div class="footer-middle">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5 col-12">
                    <div class="f-about single-footer">
                        <div class="logo">
                            <a href="{{ route('beranda') }}"><img src="{{ asset('logo.png') }}" alt="#"/></a>
                        </div>
                        <p>
                            {{ $profil->deskripsi }}
                        </p>
                        <div class="footer-social">
                            <ul>
                                <li>
                                    <a href="#"><i class="fab fa-facebook"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-linkedin"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-7 col-12">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="single-footer f-link">
                                <h3>TPQ Imam Syafi'i</h3>
                                <ul>
                                    <li><a href="{{ route('beranda') }}">Beranda</a></li>
                                    <li><a href="{{ route('pengumuman') }}">Pengumuman</a></li>
                                    <li><a href="{{ route('galeri') }}">Galeri</a></li>
                                    <li><a href="{{ route('donasi') }}">Donasi</a></li>
                                    <li><a href="{{ route('struktur') }}">Struktur</a></li>
                                    <li><a href="{{ route('hubungi') }}">Hubungi Kami</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="single-footer f-contact f-link">
                                <h3>Hubungi Kami</h3>
                                <p>Untuk mendapat informasi lebih lengkap, silakan hubungi kami</p>
                                <ul class="footer-contact">
                                    <li>
                                        <i class="fas fa-envelope"></i> <a
                                            href="mailto:{{ $profil->email }}"> {{ $profil->email }} </a>
                                    </li>
                                    <li>
                                        <i class="fas fa-phone"></i><a href="tel:+123456789">(+62) 8215 914 2175</a>
                                    </li>
                                    <li>
                                        <i class="fas fa-map-marker"></i> {{ $profil->alamat }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-footer gallery">
                        <h3>Instagram Feed</h3>
                        <ul class="list">
                            <li>
                                <a href="#"><img src="{{ asset('bizfinity/images/gallery1.jpg') }}" alt="#"/><i
                                        class="lni lni-instagram"></i></a>
                            </li>
                            <li>
                                <a href="#"
                                ><img src="{{ asset('bizfinity/images/gallery2.jpg') }}" alt="#"/><i
                                        class="lni lni-instagram"
                                    ></i
                                    ></a>
                            </li>
                            <li>
                                <a href="#"
                                ><img src="{{ asset('bizfinity/images/gallery3.jpg') }}" alt="#"/><i
                                        class="lni lni-instagram"
                                    ></i
                                    ></a>
                            </li>
                            <li>
                                <a href="#"
                                ><img src="{{ asset('bizfinity/images/gallery2.jpg') }}" alt="#"/><i
                                        class="lni lni-instagram"
                                    ></i
                                    ></a>
                            </li>
                            <li>
                                <a href="#"
                                ><img src="{{ asset('bizfinity/images/gallery3.jpg') }}" alt="#"/><i
                                        class="lni lni-instagram"
                                    ></i
                                    ></a>
                            </li>
                            <li>
                                <a href="#"
                                ><img src="{{ asset('bizfinity/images/gallery1.jpg') }}" alt="#"/><i
                                        class="lni lni-instagram"
                                    ></i
                                    ></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="inner">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="left">
                            <p>
                                Dikembangkan oleh: M. Iqbal Effendi dan Nafila Fayruz
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="right">
                            <p>All Right Reserved. {{ env('APP_NAME') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<a href="#" class="scroll-top btn-hover">
    <i class="fas fa-chevron-up"></i>
</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="{{ asset('bizfinity/js/count-up.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"
        integrity="sha512-Eak/29OTpb36LLo2r47IpVzPBLXnAMPAVypbSZiZ4Qkf8p/7S/XRG5xp7OKWPPYfJT6metI+IORkR5G8F900+g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/min/tiny-slider.js"
        integrity="sha512-D/zaRVk05q6ERt1JgWB49kL6tyerY7a94egaVv6ObiGcw3OCEv0tvoPDEsVqL28HyAZhDd483ix8gkWQGDgEKw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('bizfinity/js/glightbox.min.js') }}"></script>
<script src="{{ asset('bizfinity/js/imagesloaded.min.js') }}"></script>
<script src="{{ asset('bizfinity/js/main.js') }}"></script>
<!--Overlay Scrollbars-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/js/OverlayScrollbars.min.js"
        integrity="sha512-B1xv1CqZlvaOobTbSiJWbRO2iM0iii3wQ/LWnXWJJxKfvIRRJa910sVmyZeOrvI854sLDsFCuFHh4urASj+qgw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stack('script')
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {


        //====== Clients Logo Slider
        tns({
            container: ".client-logo-carousel",
            slideBy: "page",
            autoplay: true,
            autoplayButtonOutput: false,
            mouseDrag: true,
            gutter: 15,
            nav: false,
            controls: false,
            responsive: {
                0: {
                    items: 1,
                },
                540: {
                    items: 2,
                },
                768: {
                    items: 3,
                },
                992: {
                    items: 4,
                },
                1170: {
                    items: 6,
                },
            },
        });

        //======== Home Slider
        var slider = new tns({
            container: ".home-slider",
            slideBy: "page",
            autoplay: false,
            mouseDrag: true,
            gutter: 0,
            items: 1,
            nav: true,
            controls: false,
            controlsText: [
                '<i class="lni lni-arrow-left prev"></i>',
                '<i class="lni lni-arrow-right next"></i>',
            ],
            responsive: {
                1200: {
                    items: 1,
                },
                992: {
                    items: 1,
                },
                0: {
                    items: 1,
                },
            },
        });

        //======== Testimonial Slider
        var slider = new tns({
            container: ".testimonial-slider",
            slideBy: "page",
            autoplay: false,
            mouseDrag: true,
            gutter: 0,
            items: 1,
            nav: true,
            controls: false,
            controlsText: [
                '<i class="lni lni-arrow-left prev"></i>',
                '<i class="lni lni-arrow-right next"></i>',
            ],
            responsive: {
                1200: {
                    items: 2,
                },
                992: {
                    items: 1,
                },
                0: {
                    items: 1,
                },
            },
        });


        //The first argument are the elements to which the plugin shall be initialized
        //The second argument has to be at least a empty object or a object with your desired options
        // OverlayScrollbars(document.querySelectorAll("body"), { });
    });
</script>
</body>
</html>
