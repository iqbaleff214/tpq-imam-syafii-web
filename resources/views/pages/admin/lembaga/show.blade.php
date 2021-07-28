@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Galeri</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.galeri.index') }}">Galeri</a>
                            </li>
                            <li class="breadcrumb-item active">Detail</li>
                            <!-- <li class="breadcrumb-item active">Administrator</li> -->
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12 col-md-6">
                    <!-- Default box -->
                    <div class="card card-solid">
                        <div class="card-header">
                            <h3 class="card-title">
                                <a href="{{ route('admin.galeri.index') }}" class="btn btn-outline-danger">
                                    Kembali
                                </a>
                            </h3>
                        </div>
                        <div class="card-body mb-3">
                            <img src="{{ asset("storage/$galeri->foto") }}" class="img-thumbnail img-preview"
                                 style="width: 100%;" alt="{{ $galeri->judul }}">

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                        </div>
                        <!-- /.card-footer-->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-12 col-md-6">
                    <div class="card card-solid">
                        <div class="card-header">
                            <h3 class="card-title">
                                Kegiatan
                            </h3>
                        </div>
                        <div class="card-body mb-3 p-0">
                            <table class="table">
                                <tr>
                                    <th style="width: 25%;">Ditambahkan</th>
                                    <td>{{ $galeri->created_at->diffForHumans() }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 25%;">Judul</th>
                                    <td>{{ $galeri->judul }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 25%;">Kategori</th>
                                    <td>{{ $galeri->kategori->kategori }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 25%;">Keterangan</th>
                                    <td>{{ $galeri->keterangan ?: '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->

    </div>
@endsection
