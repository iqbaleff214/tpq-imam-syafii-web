<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | {{ config('app.name') }}</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('adminlte/img/404nf.ico') }}"/>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Overlay Scrollbars -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/css/OverlayScrollbars.min.css"
          integrity="sha512-jN4O0AUkRmE6Jwc8la2I5iBmS+tCDcfUd1eq8nrZIBnDKTmCp5YxxNN1/aetnAH32qT+dDbk1aGhhoaw5cJNlw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/b8cc568f15.js" crossorigin="anonymous"></script>
@stack('link')
<!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
</head>
{{--<body class="sidebar-mini layout-fixed accent-maroon hold-transition" style="height: auto;">--}}
<body class="hold-transition layout-top-nav accent-maroon">
<div class="wrapper">


    <!-- Navbar -->
{{--    <nav class="main-header navbar navbar-expand border-bottom-0 navbar-dark navbar-maroon">--}}
{{--        <!-- Left navbar links -->--}}
{{--        <ul class="navbar-nav">--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>--}}
{{--            </li>--}}
{{--        </ul>--}}

{{--        <!-- Right navbar links -->--}}
{{--        <ul class="navbar-nav ml-auto">--}}
{{--            <li class="nav-item d-none d-md-block">--}}
{{--                <a class="nav-link" data-widget="fullscreen" href="#" role="button">--}}
{{--                    <i class="fas fa-expand-arrows-alt"></i>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <!-- Messages Dropdown Menu -->--}}
{{--            <li class="nav-item dropdown">--}}
{{--                <a class="nav-link" data-toggle="dropdown" href="#">--}}
{{--                    <span class="font-weight-bold">{{ Auth::user()->administrator->jabatan  }}<i--}}
{{--                            class="fas fa-chevron-down ml-2"></i></span>--}}
{{--                </a>--}}
{{--                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">--}}
{{--                    <a href="{{ route('kepala.profil') }}" class="dropdown-item">Profil</a>--}}
{{--                    <a href="{{ route('logout') }}" class="dropdown-item" id="logout-button">Keluar</a>--}}
{{--                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">--}}
{{--                        @csrf--}}
{{--                    </form>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    </nav>--}}
<!-- /.navbar -->

    @yield('navbar')

    @yield('body')

    <footer class="main-footer text-sm">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 1.0
        </div>
        <strong>Copyright © {{ date('Y')=='2021' ? '2021' : '2021-'.date('Y') }} <a href="#">{{ env('APP_NAME') }} </a>
            .</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
        crossorigin="anonymous"></script>
<!--Sweet alert 2-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@include('sweetalert::alert')
<!--Overlay Scrollbars-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/js/OverlayScrollbars.min.js"
        integrity="sha512-B1xv1CqZlvaOobTbSiJWbRO2iM0iii3wQ/LWnXWJJxKfvIRRJa910sVmyZeOrvI854sLDsFCuFHh4urASj+qgw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>
<script !src="">
    var osInstance = $('body').overlayScrollbars({ }).overlayScrollbars();
</script>
@stack('script')
<script !src="">
    $(function () {
        $(document).on('click', '#logout-button', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Anda yakin ingin keluar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, saya yakin!',
                cancelButtonText: 'Batalkan',
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).closest('form.d-inline').submit();
                    $('#logout-form').submit();
                }
            });
        });
    });

</script>
</body>
</html>


