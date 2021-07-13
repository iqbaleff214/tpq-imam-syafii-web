@extends('layouts.frontend')

@section('body')
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="breadcrumbs-content left">
                    <h1 class="page-title">Pengumuman dan Informasi</h1>
                    <p>Semua pengumuman dan informasi yang berkaitan dengan TPQ Imam Syafi'i Banjarmasin.</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <div class="breadcrumbs-content right">
                    <ul class="breadcrumb-nav">
                        <li><a href="index.html">Beranda</a></li>
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

                <div class="single-list">
                    <div class="post-thumbnils">
                        <img src="<?= asset('bizfinity/images/gallery1.jpg') ?>" style="width:100%;" alt="#">
                    </div>
                    <div class="post-details">
                        <div class="detail-inner">
                            <h2 class="post-title">
                                <a href="blog-single-sidebar.html">Pengumuman Libur Ramadan 1442 H</a>
                            </h2>

                            <ul class="custom-flex post-meta">
                                <li>
                                    <a href="#">
                                    <i class="fas fa-calendar"></i>
                                    25 April 2021
                                    </a>
                                </li>
                            </ul>
                            <p>We denounce with righteous indige nation and dislike men who are so beguiled and demo realized by the charms of pleasure of the moment that...</p>
                            <div class="button">
                                <a href="#" class="btn mouse-dir white-bg">Selengkapnya <span class="dir-part"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single-list">
                    <div class="post-thumbnils">
                        <img src="<?= asset('bizfinity/images/gallery1.jpg') ?>" style="width:100%;" alt="#">
                    </div>
                    <div class="post-details">
                        <div class="detail-inner">
                            <h2 class="post-title">
                                <a href="blog-single-sidebar.html">Pengumuman Libur Ramadan 1442 H</a>
                            </h2>

                            <ul class="custom-flex post-meta">
                                <li>
                                    <a href="#">
                                    <i class="fas fa-calendar"></i>
                                    25 April 2021
                                    </a>
                                </li>
                            </ul>
                            <p>We denounce with righteous indige nation and dislike men who are so beguiled and demo realized by the charms of pleasure of the moment that...</p>
                            <div class="button">
                                <a href="#" class="btn mouse-dir white-bg">Selengkapnya <span class="dir-part"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single-list">
                    <div class="post-thumbnils">
                        <img src="<?= asset('bizfinity/images/gallery1.jpg') ?>" style="width:100%;" alt="#">
                    </div>
                    <div class="post-details">
                        <div class="detail-inner">
                            <h2 class="post-title">
                                <a href="blog-single-sidebar.html">Pengumuman Libur Ramadan 1442 H</a>
                            </h2>

                            <ul class="custom-flex post-meta">
                                <li>
                                    <a href="#">
                                    <i class="fas fa-calendar"></i>
                                    25 April 2021
                                    </a>
                                </li>
                            </ul>
                            <p>We denounce with righteous indige nation and dislike men who are so beguiled and demo realized by the charms of pleasure of the moment that...</p>
                            <div class="button">
                                <a href="#" class="btn mouse-dir white-bg">Selengkapnya <span class="dir-part"></span></a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="pagination center">
                    <ul class="pagination-list">
                        <li><a href="#"><i class="lni lni-arrow-left"></i></a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#"><i class="lni lni-arrow-right"></i></a></li>
                    </ul>
                </div>

            </div>
            <aside class="col-lg-4 col-md-5 col-12">
                <div class="sidebar">
                    <div class="widget search-widget">
                        <h5 class="widget-title">Pencarian</h5>
                        <form action="#">
                            <input type="text" placeholder="Cari kata kunci...">
                            <button type="submit"><i class="lni lni-search-alt"></i></button>
                        </form>
                    </div>
                    <div class="widget popular-feeds">
                        <h5 class="widget-title">Terbaru</h5>
                        <div class="popular-feed-loop">
                            <div class="single-popular-feed">
                                <div class="feed-img animate-img">
                                    <a href="#">
                                        <img src="<?= asset('bizfinity/images/gallery1.jpg') ?>" class="image-fit" alt="#">
                                    </a>
                                </div>
                                <div class="feed-desc">
                                    <h6 class="post-title"><a href="#">Pengumuman Libur Ramadan.</a></h6>
                                    <span class="time"><i class="fas fa-calendar"></i> 25 April 2021</span>
                                </div>
                            </div>
                            <div class="single-popular-feed">
                                <div class="feed-img animate-img">
                                    <a href="#">
                                        <img src="<?= asset('bizfinity/images/gallery1.jpg') ?>" class="image-fit" alt="#">
                                    </a>
                                </div>
                                <div class="feed-desc">
                                    <h6 class="post-title"><a href="#">Pengumuman Libur Ramadan.</a></h6>
                                    <span class="time"><i class="fas fa-calendar"></i> 25 April 2021</span>
                                </div>
                            </div>
                            <div class="single-popular-feed">
                                <div class="feed-img animate-img">
                                    <a href="#">
                                        <img src="<?= asset('bizfinity/images/gallery1.jpg') ?>" class="image-fit" alt="#">
                                    </a>
                                </div>
                                <div class="feed-desc">
                                    <h6 class="post-title"><a href="#">Pengumuman Libur Ramadan.</a></h6>
                                    <span class="time"><i class="fas fa-calendar"></i> 25 April 2021</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
