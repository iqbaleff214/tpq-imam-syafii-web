@extends('layouts.pengajar')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"> {{ $title }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="card card-maroon card-outline">
                            <img src="{{ \App\Helpers\UserHelpers::getInfoImage($pengumuman->foto) }}" class="card-img-top" alt="{{ $pengumuman->judul }}">
                            <div class="card-footer">
                                <small class="text-muted">{{ $pengumuman->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="card ">
                            <div class="card-header">
                                <a href="{{ route('pengajar.pengumuman.index') }}" class="btn btn-outline-danger">
                                    Kembali
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <h2 class="font-weight-bold">{{ $pengumuman->judul }}</h2>
                                    <small class="text-muted my-5">{{ $pengumuman->penulis->nama . ' . ' . $pengumuman->created_at->isoFormat('dddd, DD MMMM YYYY') . ' . ' . $pengumuman->seen . ' kali dilihat'  }}</small>
                                    <p class="card-text my-2 mb-5">{!! $pengumuman->konten !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->

    </div>
@endsection
