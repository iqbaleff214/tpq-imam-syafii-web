@extends('layouts.auth')

@section('title', 'Masuk')

@section('bodyclass', 'hold-transition login-page')

@section('body')
    <div class="login-box">
        <img src="{{ asset('logo.png') }}" alt="{{ config('app.name') }}" class="img-fluid img-lg">
        <div class="login-logo d-block">
            <a href="{{ route('beranda') }}" class="text-sm-right">{{ config('app.name') }}</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Silakan verifikasi surel/email Anda</p>
                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    @if (session('resent'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            Tautan telah dikirim! Silakan cek surel/email Anda.
                        </div>
                    @endif
                    <p>Tekan tombol di bawah jika tidak ada surel/email yang masuk.</p>
                    <div class="row">
                        <div class="col-6">
                        </div>
                        <!-- /.col -->
                        <div class="col-6">
                            <button type="submit" class="btn btn-danger btn-block">Kirim Tautan</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                @if (Route::has('password.request'))
                    <p class="mb-1 mt-3">
                        Belum mau? <a href="{{ route('home') }}" class="text-maroon">Kembali ke Beranda</a>.
                    </p>
                @endif
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
@endsection
