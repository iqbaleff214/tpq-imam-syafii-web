@extends('layouts.frontend')

@section('body')
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="breadcrumbs-content left">
                    <h1 class="page-title">Hubungi Kami</h1>
                    <p>Jika Anda ingin mengontak kami silakan isi formulir di bawah.</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <div class="breadcrumbs-content right">
                    <ul class="breadcrumb-nav">
                        <li><a href="index.html">Beranda</a></li>
                        <li>Hubungi Kami</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Start Contact Area -->
<div class="contact-area contact-page section">
	<div class="container">
		<div class="contact-inner">
			<div class="row">
				<div class="col-xl-5 col-lg-5 col-md-4 col-12">
					<div
							class="contact-address-wrapper wow fadeInLeft"
							data-wow-delay="0.4s"
					>
						<div class="inner-section-title">
							<h4>Info Kontak</h4>
						</div>
						<div class="single-info">
							<ul>
								<li>Masjid Imam Syafi'i Banjarmasin</li>
								<li>Jl. AMD XII Manunggal</li>
								<li>Banjarmasin,</li>
								<li>Kalimantan Selatan</li>
							</ul>
						</div>
						<div class="single-info">
							<ul>
								<li>
									<span>(+62) 8215 914 2175</span>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-xl-7 col-lg-7 col-md-8 col-12">
					<div
							class="contact-wrapper wow fadeInRight"
							data-wow-delay="0.6s"
					>
						<form class="contacts-form"
							  method="post"
							  action="<?= ('r') ?>">
							<div class="row">
								<div class="col-lg-6 col-12">
									<div class="contacts-icon contactss-name">
										<input
												type="text"
												name="contact_name"
												placeholder="Nama"
												required="required"
										/>
									</div>
								</div>
								<div class="col-lg-6 col-12">
									<div class="contacts-icon contactss-name">
										<input
												type="text"
												name="contact_phone"
												placeholder="No. Telp"
												required="required"
										/>
									</div>
								</div>
								<div class="col-lg-6 col-12">
									<div class="contacts-icon contactss-email">
										<input
												type="email"
												name="contact_email"
												placeholder="Surel"
												required="required"
										/>
									</div>
								</div>
								<div class="col-lg-6 col-12">
									<div class="contacts-icon contactss-name">
										<input
												type="text"
												name="contact_subject"
												placeholder="Subyek"
												required="required"
										/>
									</div>
								</div>
								<div class="col-12">
									<div class="contacts-icon contactss-message">
										<textarea
												name="contact_message"
												rows="7"
												placeholder="Pesan"
										></textarea>
									</div>
								</div>
								<div class="col-12">
									<div class="contacts-button button">
										<button type="submit" class="btn mouse-dir white-bg">
											Kirim Pesan <span class="dir-part"></span>
										</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Contact Area -->

<!-- Start Google-map Area -->
<section class="map-section">
	<div class="map-container">
		<div class="mapouter">
			<div class="gmap_canvas">
				<iframe
						width="100%"
						height="500"
						id="gmap_canvas"
						src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3982.9721893999626!2d114.61346541475793!3d-3.356957097556321!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2de4238e8f81e633%3A0xd6935b9a9783d52!2sMasjid%20Imam%20Syafi&#39;i%20Banjarmasin!5e0!3m2!1sen!2sid!4v1619350719411!5m2!1sen!2sid"
						frameborder="0"
						scrolling="no"
						marginheight="0"
						marginwidth="0"></iframe>
			</div>
			<style>
				.mapouter {
					position: relative;
					text-align: right;
				}

				.gmap_canvas {
					overflow: hidden;
					background: none !important;
				}
			</style>
		</div>
	</div>
</section>
<!-- End Google-map Area -->

@endsection
