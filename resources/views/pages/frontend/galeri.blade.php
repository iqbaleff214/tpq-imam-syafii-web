@extends('layouts.frontend')

@section('body')
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="breadcrumbs-content left">
                    <h1 class="page-title">Galeri</h1>
                    <p>Berikut adalah galeri foto dari beragam kegiatan yang dilakukan di lingkungan TPQ Imam Syafi'i Banjarmasin.</p>
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
        <div class="row">
          <div class="col-lg-8 offset-lg-2 col-12">
            <div class="section-title">
              <span class="wow fadeInDown" data-wow-delay=".2s"
                >Galeri</span
              >
              <h2 class="wow fadeInUp" data-wow-delay=".4s">Galeri Kegiatan</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div
              class="portfolio-btn-wrapper wow fadeInUp"
              data-wow-delay=".4s"
            >
              <button class="portfolio-btn active" data-filter="*">Semua</button>
              <button class="portfolio-btn" data-filter=".branding">
                Pembelajaran
              </button>
              <button class="portfolio-btn" data-filter=".marketing">
                Pembelajaran Daring
              </button>
              <button class="portfolio-btn" data-filter=".web">
                Praktik
              </button>
              <button class="portfolio-btn" data-filter=".graphic">
                Wisuda
              </button>
            </div>
          </div>
        </div>
        <div class="row grid">
          <div class="col-lg-4 col-md-6 grid-item branding marketing">
            <div
              class="portfolio-item-wrapper wow fadeInUp"
              data-wow-delay=".3s"
            >
              <div class="portfolio-img">
                <img src="<?= asset('bizfinity/images/gallery1.jpg') ?>" alt="" />
              </div>
              <div class="portfolio-overlay">
                <div class="overlay-content">
                  <h4>Project Name</h4>
                  <p>
                    We Crafted an awesome design library that is robust and
                    intuitive to business presentation.
                  </p>
                  <a href="portfolio-single.html" class="theme-btn border-btn"
                    >Full View</a
                  >
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 grid-item branding marketing">
            <div
              class="portfolio-item-wrapper wow fadeInUp"
              data-wow-delay=".3s"
            >
              <div class="portfolio-img">
                <img src="<?= asset('bizfinity/images/gallery2.jpg') ?>" alt="" />
              </div>
              <div class="portfolio-overlay">
                <div class="overlay-content">
                  <h4>Project Name</h4>
                  <p>
                    We Crafted an awesome design library that is robust and
                    intuitive to business presentation.
                  </p>
                  <a href="portfolio-single.html" class="theme-btn border-btn"
                    >Full View</a
                  >
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 grid-item branding marketing">
            <div
              class="portfolio-item-wrapper wow fadeInUp"
              data-wow-delay=".3s"
            >
              <div class="portfolio-img">
                <img src="<?= asset('bizfinity/images/gallery1.jpg') ?>" alt="" />
              </div>
              <div class="portfolio-overlay">
                <div class="overlay-content">
                  <h4>Project Name</h4>
                  <p>
                    We Crafted an awesome design library that is robust and
                    intuitive to business presentation.
                  </p>
                  <a href="portfolio-single.html" class="theme-btn border-btn"
                    >Full View</a
                  >
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 grid-item branding marketing">
            <div
              class="portfolio-item-wrapper wow fadeInUp"
              data-wow-delay=".3s"
            >
              <div class="portfolio-img">
                <img src="<?= asset('bizfinity/images/gallery2.jpg') ?>" alt="" />
              </div>
              <div class="portfolio-overlay">
                <div class="overlay-content">
                  <h4>Project Name</h4>
                  <p>
                    We Crafted an awesome design library that is robust and
                    intuitive to business presentation.
                  </p>
                  <a href="portfolio-single.html" class="theme-btn border-btn"
                    >Full View</a
                  >
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 grid-item branding marketing">
            <div
              class="portfolio-item-wrapper wow fadeInUp"
              data-wow-delay=".3s"
            >
              <div class="portfolio-img">
                <img src="<?= asset('bizfinity/images/gallery3.jpg') ?>" alt="" />
              </div>
              <div class="portfolio-overlay">
                <div class="overlay-content">
                  <h4>Project Name</h4>
                  <p>
                    We Crafted an awesome design library that is robust and
                    intuitive to business presentation.
                  </p>
                  <a href="portfolio-single.html" class="theme-btn border-btn"
                    >Full View</a
                  >
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 grid-item branding marketing">
            <div
              class="portfolio-item-wrapper wow fadeInUp"
              data-wow-delay=".3s"
            >
              <div class="portfolio-img">
                <img src="<?= asset('bizfinity/images/gallery2.jpg') ?>" alt="" />
              </div>
              <div class="portfolio-overlay">
                <div class="overlay-content">
                  <h4>Project Name</h4>
                  <p>
                    We Crafted an awesome design library that is robust and
                    intuitive to business presentation.
                  </p>
                  <a href="portfolio-single.html" class="theme-btn border-btn"
                    >Full View</a
                  >
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 grid-item branding marketing">
            <div
              class="portfolio-item-wrapper wow fadeInUp"
              data-wow-delay=".3s"
            >
              <div class="portfolio-img">
                <img src="<?= asset('bizfinity/images/gallery1.jpg') ?>" alt="" />
              </div>
              <div class="portfolio-overlay">
                <div class="overlay-content">
                  <h4>Project Name</h4>
                  <p>
                    We Crafted an awesome design library that is robust and
                    intuitive to business presentation.
                  </p>
                  <a href="portfolio-single.html" class="theme-btn border-btn"
                    >Full View</a
                  >
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 grid-item branding marketing">
            <div
              class="portfolio-item-wrapper wow fadeInUp"
              data-wow-delay=".3s"
            >
              <div class="portfolio-img">
                <img src="<?= asset('bizfinity/images/gallery2.jpg') ?>" alt="" />
              </div>
              <div class="portfolio-overlay">
                <div class="overlay-content">
                  <h4>Project Name</h4>
                  <p>
                    We Crafted an awesome design library that is robust and
                    intuitive to business presentation.
                  </p>
                  <a href="portfolio-single.html" class="theme-btn border-btn"
                    >Full View</a
                  >
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 grid-item branding marketing">
            <div
              class="portfolio-item-wrapper wow fadeInUp"
              data-wow-delay=".3s"
            >
              <div class="portfolio-img">
                <img src="<?= asset('bizfinity/images/gallery3.jpg') ?>" alt="" />
              </div>
              <div class="portfolio-overlay">
                <div class="overlay-content">
                  <h4>Project Name</h4>
                  <p>
                    We Crafted an awesome design library that is robust and
                    intuitive to business presentation.
                  </p>
                  <a href="portfolio-single.html" class="theme-btn border-btn"
                    >Full View</a
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
