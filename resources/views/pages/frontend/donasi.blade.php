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
                        <li><a href="{{ route('beranda') }}">Beranda</a></li>
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
					<div class="contact-address-wrapper wow fadeInLeft"
							data-wow-delay="0.4s">
						<div class="inner-section-title">
							<h4>Info Rekening</h4>
						</div>
						<div class="single-info">
							@forelse ($profil->rekening as $item)
							<ul>
								<li>{{ $item->bank }}</li>
								<li>{{ $item->rekening }}</li>
								<li>{{ 'a.n. ' . $item->nama }}</li>
							</ul>
							@empty
							<p>Belum terdapat nomor rekening.</p>
							@endforelse
						</div>
					</div>
				</div>
				<div class="col-xl-7 col-lg-7 col-md-8 col-12">
					<div class="contact-wrapper wow fadeInRight"
							data-wow-delay="0.6s">
						<form class="contacts-form"
							  method="post"
							  action="{{ route('donasi.store') }}">
                            @csrf
							<div class="row">
								<div class="col-lg-6 col-12">
									<div class="contacts-icon contactss-name">
										<input
												type="text"
												name="nama"
												placeholder="Nama"
												required="required"
                                                autofocus
										/>
									</div>
								</div>
								<div class="col-lg-6 col-12">
									<div class="contacts-icon contactss-name">
										<input
												type="text"
												name="no_telp"
												placeholder="Nomor Telepon/WhatsApp"
												required="required"
										/>
									</div>
								</div>
								<div class="col-12">
									<div class="contacts-icon contactss-email">
										<input
												type="number"
                                                min="0"
                                                value="{{ $donasi }}"
												name="jumlah"
												placeholder="Rp0"
												required="required"
										/>
									</div>
								</div>
								<div class="col-12">
									<div class="contacts-icon contactss-email">
										<input
												type="text"
												name="keterangan"
												placeholder="Catatan (Opsional)"
										/>
									</div>
								</div>
								<div class="col-12">
									<div class="contacts-button button">
										<button type="submit" class="btn mouse-dir white-bg btn-donasi">
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

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script !src="">
        $(document).ready(function() {
            $(document).on("click", "button[type=submit].btn-donasi", function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Anda yakin telah mengirimkan donasi?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya, saya yakin!',
                    cancelButtonText: 'Batalkan',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).closest('form').submit();
                    }
                });
            });
        });
    </script>
@endpush
