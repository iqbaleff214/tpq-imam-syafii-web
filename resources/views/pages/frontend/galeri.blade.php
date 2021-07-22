@extends('layouts.frontend')

@section('body')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content left">
                        <h1 class="page-title">Galeri</h1>
                        <p>Berikut adalah galeri foto dari beragam kegiatan yang dilakukan di lingkungan TPQ Imam
                            Syafi'i Banjarmasin.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content right">
                        <ul class="breadcrumb-nav">
                            <li><a href="index.html">Beranda</a></li>
                            <li>Galeri</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="portfolio-section section">
        <div id="container" class="container">
            @if(count($galeri) > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="portfolio-btn-wrapper wow fadeInUp" data-wow-delay=".4s">
                            <button class="portfolio-btn active" data-filter="*">Semua</button>
                            @foreach($kategori as $item)
                                <button class="portfolio-btn" data-filter=".kategori{{ $item->id }}">
                                    {{ $item->kategori }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row grid">
                    @forelse($galeri as $item)
                        <div class="col-lg-4 col-md-6 grid-item kategori{{ $item->kategori_galeri_id }}">
                            <div class="portfolio-item-wrapper wow fadeInUp" data-wow-delay=".3s">
                                <div class="portfolio-img">
                                    <img src="{{ asset("storage/$item->foto") }}" alt=""/>
                                </div>
                                <div class="portfolio-overlay">
                                    <div class="overlay-content">
                                        <h4>{{ $item->judul }}</h4>
                                        <p>{{ $item->created_at->isoFormat('dddd, D MMMM YYYY') }}</p>
                                        <p>{{ $item->keterangan }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>kosong</p>
                    @endforelse

                </div>
            @else
                <div class="row">
                    <div class="col-md-4 offset-md-4 text-center">
                        <p>Belum ada kegiatan.</p>
                        <div class="container">
                            <img src="{{ asset('images/empty.jpg') }}" alt="Not Found">
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js"
            integrity="sha512-Zq2BOxyhvnRFXu0+WE6ojpZLOU2jdnqbrM1hmVdGzyeCa1DgM3X5Q4A/Is9xA1IkbUeDd7755dNNI/PzSf2Pew=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script !src="">
        document.addEventListener("DOMContentLoaded", function () {

            //============== isotope masonry js with imagesloaded
            imagesLoaded("#container", function () {
                const elem = document.querySelector(".grid");
                const iso = new Isotope(elem, {
                    // options
                    itemSelector: ".grid-item",
                    masonry: {
                        // use outer width of grid-sizer for columnWidth
                        columnWidth: ".grid-item",
                    },
                });

                let filterButtons = document.querySelectorAll(
                    ".portfolio-btn-wrapper button"
                );
                filterButtons.forEach((e) =>
                    e.addEventListener("click", () => {
                        let filterValue = event.target.getAttribute("data-filter");
                        iso.arrange({
                            filter: filterValue,
                        });
                    })
                );
            });
        });
    </script>
@endpush
