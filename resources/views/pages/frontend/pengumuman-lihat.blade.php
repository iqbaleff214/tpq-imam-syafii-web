@extends('layouts.frontend')

@section('body')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content left">
                        <h1 class="page-title">Pengumuman</h1>
                        <p>{{ $pengumuman->judul }}</p>
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



    <section class="section blog-single">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="post-thumbnils">
                        <img src="{{ \App\Helpers\UserHelpers::getInfoImage($pengumuman->foto) }}"
                             alt="{{ $pengumuman->judul }}">
                    </div>
                    <div class="post-details">
                        <div class="detail-inner">
                            <h2 class="post-title">
                                <a href="#">{{ $pengumuman->judul }}</a>
                            </h2>

                            <ul class="custom-flex post-meta">
                                <li>
                                    <a href="#">
                                        <i class="fas fa-user"></i>
                                        {{ $pengumuman->penulis->nama }}
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="lni lni-calendar"></i>
                                        {{ $pengumuman->created_at->isoFormat('dddd, D MMMM YYYY') }}
                                    </a>
                                </li>
                            </ul>
                            <p>
                                {!! $pengumuman->konten !!}
                            </p>

                            <div class="post-tags-media">
                                <div class="post-tags popular-tag-widget mb-xl-40">
                                </div>
                                <div class="post-social-media">
                                    <h5 class="share-title">Bagikan</h5>
                                    <ul class="custom-flex">
                                        <li>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                                               target="_blank">
                                                <i class="lni lni-facebook-filled"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://twitter.com/intent/tweet?text={{ \Illuminate\Support\Str::slug($pengumuman->judul, '+') }}&url={{ url()->current() }}" target="_blank">
                                                <i class="lni lni-twitter-original"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://wa.me/?text={{ url()->current() }}" target="_blank">
                                                <i class="lni lni-whatsapp"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="detail-post-navigation">
                                <div class="prev-post">
                                    @isset($prev)
                                        <span><i class="lni lni-arrow-left"></i>Sebelumnya</span>
                                        <a href="{{ route('pengumuman.detail', $prev->slug) }}">{{ $prev->judul }}</a>
                                    @endisset
                                </div>
                                <div class="next-post">
                                    @isset($next)
                                        <span>Selanjutnya <i class="lni lni-arrow-right"></i></span>
                                        <a href="{{ route('pengumuman.detail', $next->slug) }}">{{ $next->judul }}</a>
                                    @endisset
                                </div>
                            </div>
                        </div>

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
                                            <span class="time"><i class="fas fa-calendar"></i> {{ $item->created_at->isoFormat('dddd, D MMMM YYYYY') }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <p>Kosong</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
