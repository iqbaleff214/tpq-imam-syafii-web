{{--@extends('errors::minimal')--}}

{{--@section('title', __('Unauthorized'))--}}
{{--@section('code', '401')--}}
{{--@section('message', __('Unauthorized'))--}}
    <!DOCTYPE html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <title>{{ env('APP_NAME') }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('adminlte/img/404nf.ico') }}"/>
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- ========================= CSS here ========================= -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
          crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('bizfinity/css/mainn.css') }}"/>
    <link rel="stylesheet" href="{{ asset('bizfinity/css/reset.css') }}"/>
    <link rel="stylesheet" href="{{ asset('bizfinity/css/responsive.css') }}"/>
</head>
<body>

<section class="error-page">
    <div class="table">
        <div class="table-cell">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-12">

                        <div class="error-image">
                            <img src="{{ asset('images/errors/401.jpg') }}" alt="Not Found">
                        </div>

                    </div>
                    <div class="col-lg-6 col-12">

                        <div class="error-text">
                            <h2>Tidak Punya Otoritas!</h2>
                            <p>Wah, halaman ini terbatas, silakan kembali ke Beranda.</p>
                            <div class="button">
                                @if(\Illuminate\Support\Facades\Route::is('kepala.*'))
                                    <a href="{{ route('kepala.dashboard') }}" class="btn mouse-dir white-bg">
                                        Dasbor <span class="dir-part"></span>
                                    </a>
                                @elseif(\Illuminate\Support\Facades\Route::is('admin.*'))
                                    <a href="{{ route('admin.dashboard') }}" class="btn mouse-dir white-bg">
                                        Dasbor <span class="dir-part"></span>
                                    </a>
                                @else
                                    <a href="{{ route('beranda') }}" class="btn mouse-dir white-bg">
                                        Beranda <span class="dir-part"></span>
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>

