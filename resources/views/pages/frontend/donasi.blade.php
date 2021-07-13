@extends('layouts.frontend')

@section('body')
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="breadcrumbs-content left">
                    <h1 class="page-title">Donasi</h1>
                    <p>Berikan infaq terbaik Anda untuk keberlangsungan pendidikan Al-Qur'an untuk anak-anak. Jangan sia-siakan kesempatan Anda untuk mendapatkan pahala jariyah. </p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <div class="breadcrumbs-content right">
                    <ul class="breadcrumb-nav">
                        <li><a href="index.html">Beranda</a></li>
                        <li>Donasi</li>
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
							<h4>Info Rekening</h4>
						</div>
						<div class="single-info">
							<ul>
								<li>Bank Syariah Indonesia</li>
								<li>6034 9488 2657 9473</li>
								<li>a.n M. Iqbal Effendi</li>
							</ul>
						</div>
						<div class="single-info">
							<ul>
								<li>Bank Negara Indonesia</li>
								<li>6034 9488 2657 9473</li>
								<li>a.n M. Iqbal Effendi</li>
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
							  action="<?= 'tes' ?>">
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
								<div class="col-12">
									<div class="contacts-icon contactss-email">
										<input
												type="text"
												name="contact_email"
												placeholder="Rp0"
												required="required"
										/>
									</div>
								</div>
								<div class="col-12">
									<div class="contacts-button button">
										<button type="submit" class="btn mouse-dir white-bg">
											Konfirmasi Donasi <span class="dir-part"></span>
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

@endsection
