@extends('layouts.frontend')

@section('meta')
    <meta name="keywords" content="pengumuman" />
    <meta name="description" content="Berisi tentang pengumuman dan informasi seputar {{ $profil->nama }}"/>
@endsection

@section('body')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content left">
                        <h1 class="page-title">Pengumuman</h1>
                        <p>Semua pengumuman dan informasi yang berkaitan dengan TPQ Imam Syafi'i Banjarmasin.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content right">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('beranda') }}">Beranda</a></li>
                            <li>Pengumuman</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <section class="section blog-list">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-7 col-12">

                    <div class="letast-news-grid latest-news-area">
                        <div class="row">
                            @forelse($pengumuman as $item)
                                <div class="col-12 col-md-6">
                                    <div class="letest-news-item wow fadeInUp mt-0 mb-4" data-wow-delay=".4s">
                                        <div class="image">
                                            <img src="{{ \App\Helpers\UserHelpers::getInfoImage($item->foto) }}"
                                                 alt="#"/>
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
                                                {{ \Illuminate\Support\Str::limit(strip_tags($item->konten), 155) }}
                                            </p>
                                            <div class="button">
                                                <a
                                                    class="btn mouse-dir white-bg"
                                                    href="{{ route('pengumuman.detail', $item->slug) }}">Selengkapnya
                                                    <span
                                                        class="dir-part"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-md-6 offset-md-3 text-center">
                                    <p>Belum ada pengumuman.</p>
                                    <div class="container">
                                        <img src="{{ asset('images/empty.jpg') }}" alt="Not Found">
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="pagination center">
                        {!! $pengumuman->withQueryString()->links('vendor.pagination.frontend') !!}
                    </div>

                </div>
                <aside class="col-lg-4 col-md-5 col-12">
                    <div class="sidebar">
                        <div class="widget search-widget">
                            <h5 class="widget-title">Pencarian</h5>
                            <form method="get" action="{{ route('pengumuman') }}">
                                <input type="search" name="q" placeholder="Cari kata kunci..."
                                       value="{{ isset($_GET['q']) ? $_GET['q'] : '' }}">
                                <button type="submit"><i class="lni lni-search-alt"></i></button>
                            </form>
                        </div>
                        <div class="widget popular-feeds">
                            <h5 class="widget-title">Terbaru</h5>
                            <div class="popular-feed-loop">
                                @forelse($newest as $item)
                                    <div class="single-popular-feed">
                                        <div class="feed-img animate-img">
                                            <a href="{{ route('pengumuman.detail', $item->slug) }}">
                                                <img src="{{ \App\Helpers\UserHelpers::getInfoImage($item->foto) }}"
                                                     class="image-fit"
                                                     alt="#">
                                            </a>
                                        </div>
                                        <div class="feed-desc">
                                            <h6 class="post-title"><a
                                                    href="{{ route('pengumuman.detail', $item->slug) }}">{{ $item->judul }}</a>
                                            </h6>
                                            <span class="time"><i class="fas fa-calendar"></i> {{ $item->created_at->isoFormat('dddd, D MMMM YYYY') }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <p>Belum ada pengumuman.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
