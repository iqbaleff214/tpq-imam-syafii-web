@extends('layouts.frontend')

@section('body')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content left">
                        <h1 class="page-title">Pendaftaran Santri</h1>
                        @if($profil->is_pendaftaran)
                            <p>Pendaftaran santri telah dibuka untuk
                                periode {{ \GeniusTS\HijriDate\Date::today()->format('F o') }}</p>
                        @else
                            <p>Pendaftaran santri belum dibuka.</p>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content right">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('beranda') }}">Beranda</a></li>
                            <li>Pendaftaran</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($spp->count())
        <section id="pricing" class="pricing-table section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 col-12">
                        <div class="section-title">
                            <h2 class="wow fadeInUp" data-wow-delay=".4s">
                                Biaya Pendidikan (SPP)
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($spp as $item)
                        <div class="{{ $class_spp }}">
                            <div class="single-table wow fadeInUp" data-wow-delay=".7s">
                                <div class="table-head">
                                    <h4 class="title">
                                        {{ $item->opsi }} <span>{{ $item->keterangan ?: $item->opsi }}</span>
                                    </h4>
                                    <div class="price">
                                        <p class="amount">
                                            <span class="curency" style="font-size: small;">Rp</span>
                                            {{ sprintf("%02dk", ($item->jumlah/1000)) }}
                                            <span class="duration">/bln</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($profil->is_pendaftaran)
        <section class="call-action section overlay">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-12 wow fadeInLeft" data-wow-delay=".3s">
                        <div class="section-title">
                            <span>Pendaftaran</span>
                            <h2>
                                Daftarkan anak Anda di TPQ Imam Syafi'i Banjarmasin
                            </h2>
                            <p>
                                Usia minimum untuk mendaftar adalah 6 tahun.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-12 wow fadeInRight" data-wow-delay=".4s">
                        <div class="right-form">
                            <div class="section-heading">
                                <span class="small">Formulir Pendaftaran Santri</span>
                                <h4>TPQ Imam Syafi'i Banjarmasin</h4>
                            </div>
                            @if(session('success'))
                                <div class="alert alert-success" role="alert">
                                    <h4 class="alert-heading">Pendaftaran Berhasil!</h4>
                                    <p>Silakan tunggu sampai calon santri dinyatakan diterima di {{ $profil->nama }}. <b>Anda tidak perlu mengisi formulir pendaftaran lagi</b>.</p>
                                    <hr>
                                    <p class="mb-0">InsyaAllah Anda akan dikabari via email atau whatsapp mengenai calon santri yang bersangkutan.</p>
                                </div>
                            @elseif(session('error'))
                                <div class="alert alert-danger" role="alert">
                                    <h4 class="alert-heading">Pendaftaran Gagal!</h4>
                                    <p>{{ session('error') }}</p>
                                    <hr>
                                    <p class="mb-0">Silakan hubungi Administrator untuk informasi lebih jauh!</p>
                                </div>
                            @else
                            <div class="contact-form-box">
                                <form method="POST"
                                      action="{{ session('nis') ? route('pendaftaran.post') : route('pendaftaran.next') }}"
                                      class="mailform">
                                    @csrf
                                    <div class="row">
                                        @if(session('nis'))
                                            <div class="col-12 mb-3 container">
                                                <p class="text-center">Silakan isi surel/email dan buat password Anda untuk membuat akun. NIS santri akan digunakan sebagai username.</p>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <input type="text" name="nis"
                                                       class="@error('nis') is-invalid @enderror"
                                                       placeholder="NIS" value="{{ old('nis', session('nis')) }}" readonly/>
                                                <small class="is-invalid-text">{{ $errors->first('nis') }}</small>
                                                <input type="hidden" name="jenis_kelamin" value="{{ old('jenis_kelamin') }}">
                                                <input type="hidden" name="spp_opsi_id" value="{{ old('spp_opsi_id') }}">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <input type="email" name="email"
                                                       class="@error('email') is-invalid @enderror"
                                                       placeholder="Surel"
                                                       value="{{ old('email') }}" autofocus/>
                                                <small class="is-invalid-text">{{ $errors->first('email') }}</small>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <input type="password" name="password"
                                                       class="@error('password') is-invalid @enderror"
                                                       placeholder="Kata Sandi"/>
                                                <small class="is-invalid-text">{{ $errors->first('password') }}</small>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <input type="password" name="password_confirmation"
                                                       class="@error('password') is-invalid @enderror"
                                                       placeholder="Konfirmasi Kata Sandi"/>
                                                <small class="is-invalid-text">{{ $errors->first('password') }}</small>
                                            </div>
                                        @endif
                                        <div class="col-12 mb-3">
                                            <input type="text" name="nama_lengkap"
                                                   class="@error('nama_lengkap') is-invalid @enderror"
                                                   placeholder="Nama Lengkap"
                                                   value="{{ old('nama_lengkap') }}" {{ session('nis') ? 'readonly' : 'autofocus' }}/>
                                            <small class="is-invalid-text">{{ $errors->first('nama_lengkap') }}</small>
                                        </div>
                                        <div class="col-lg-6 col-12 mb-3">
                                            <input type="text" name="nama_panggilan"
                                                   class="@error('nama_panggilan') is-invalid @enderror"
                                                   placeholder="Nama Panggilan" value="{{ old('nama_panggilan') }}" {{ session('nis') ? 'readonly' : '' }}/>
                                            <small class="is-invalid-text">{{ $errors->first('nama_panggilan') }}</small>
                                        </div>
                                        <div class="col-lg-6 col-12 mb-3">
                                            <select name="jenis_kelamin"
                                                    class="@error('jenis_kelamin') is-invalid @enderror" {{ session('nis') ? 'disabled' : '' }}>
                                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }} >
                                                    Laki-laki
                                                </option>
                                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }} >
                                                    Perempuan
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-12 mb-3">
                                            <input type="text" name="tempat_lahir"
                                                   class="@error('tempat_lahir') is-invalid @enderror"
                                                   placeholder="Tempat Lahir" value="{{ old('tempat_lahir') }}" {{ session('nis') ? 'readonly' : '' }}/>
                                            <small class="is-invalid-text">{{ $errors->first('tempat_lahir') }}</small>
                                        </div>
                                        <div class="col-lg-6 col-12 mb-3">
                                            <input type="date"  max="{{ date('Y-m-d') }}" name="tanggal_lahir"
                                                   class="@error('tanggal_lahir') is-invalid @enderror"
                                                   placeholder="Tanggal Lahir" value="{{ old('tanggal_lahir') }}" {{ session('nis') ? 'readonly' : '' }}/>
                                            <small class="is-invalid-text">{{ $errors->first('tanggal_lahir') }}</small>
                                        </div>
                                        <div class="col-lg-6 col-12 mb-3">
                                            <input type="text" name="nama_wali"
                                                   class="@error('nama_wali') is-invalid @enderror"
                                                   placeholder="Nama Ayah" value="{{ old('nama_wali') }}" {{ session('nis') ? 'readonly' : '' }}/>
                                            <small class="is-invalid-text">{{ $errors->first('nama_wali') }}</small>
                                        </div>
                                        <div class="col-lg-6 col-12 mb-3">
                                            <input type="text" name="no_telp"
                                                   class="@error('no_telp') is-invalid @enderror"
                                                   placeholder="Nomor Telepon Ayah" value="{{ old('no_telp') }}" {{ session('nis') ? 'readonly' : '' }}/>
                                            <small class="is-invalid-text">{{ $errors->first('no_telp') }}</small>
                                        </div>
                                        <div class="col-lg-6 col-12 mb-3">
                                            <input type="text" name="anak_ke"
                                                   class="@error('anak_ke') is-invalid @enderror"
                                                   placeholder="Anak ke-..." value="{{ old('anak_ke') }}" {{ session('nis') ? 'readonly' : '' }}/>
                                            <small class="is-invalid-text">{{ $errors->first('anak_ke') }}</small>
                                        </div>
                                        <div class="col-lg-6 col-12 mb-3">
                                            <input type="text" name="jumlah_saudara"
                                                   class="@error('jumlah_saudara') is-invalid @enderror"
                                                   placeholder="Dari ... bersaudara"
                                                   value="{{ old('jumlah_saudara') }}" {{ session('nis') ? 'readonly' : '' }}/>
                                            <small
                                                class="is-invalid-text">{{ $errors->first('jumlah_saudara') }}</small>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <textarea name="alamat" class="@error('alamat') is-invalid @enderror"
                                                      placeholder="Alamat" {{ session('nis') ? 'readonly' : '' }}>{{ old('alamat') }}</textarea>
                                            <small class="is-invalid-text">{{ $errors->first('alamat') }}</small>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <select name="spp_opsi_id"
                                                    class="@error('spp_opsi_id') is-invalid @enderror" {{ session('nis') ? 'disabled' : '' }}>
                                                @foreach($spp as $item)
                                                    <option
                                                        value="{{ $item->id }}" {{ old('spp_opsi_id') == $item->id ? 'selected' : '' }} >
                                                        {{ $item->opsi . ' (Rp' . number_format($item->jumlah, 2, ',', '.') . ')' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="is-invalid-text">{{ $errors->first('spp_opsi_id') }}</small>
                                        </div>
                                        <div class="button col-12 mb-3 mt-3">
                                            <button type="submit" class="btn white-bg mouse-dir">
                                                {{ session('nis') ? 'Selesaikan Pendaftaran' : 'Selanjutnya' }} <span class="dir-part"></span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection

@push('link')
    <style>
        input.is-invalid, textarea.is-invalid, select.is-invalid {
            border-color: #b6003d !important;
            color: #b6003d !important;
        }

        small.is-invalid-text {
            color: #b6003d !important;
        }

        .call-action .contact-form-box select {
            height: 50px;
            width: 100%;
            border: 1px solid #eee;
            border-radius: 0;
            margin-bottom: 10px;
            color: #333;
            background-color: transparent;
            font-size: 14px;
            font-weight: 500;
            padding: 0px 20px;
        }
    </style>
@endpush
