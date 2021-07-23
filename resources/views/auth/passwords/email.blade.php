@extends('layouts.auth')

@section('title', 'Lupa Kata Sandi')

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
                <p class="login-box-msg">Lupa kata sandi? Anda masih bisa setel ulang kata sandi lewat surel/email.</p>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Surel" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-danger btn-block">Ajukan</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    Sudah ingat dengan akun Anda? <a href="{{ route('login') }}" class="text-maroon">Masuk aja</a>.
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
@endsection
