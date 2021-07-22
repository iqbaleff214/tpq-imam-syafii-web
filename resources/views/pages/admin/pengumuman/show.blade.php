@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Pengumuman</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.pengumuman.index') }}">Pengumuman</a>
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
                    <div class="col-12 col-md-8">
                        <!-- Default box -->
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-outline-danger">
                                        Kembali
                                    </a>
                                </h3>
                            </div>
                            <div class="card-body mb-3 p-0">
                                <table class="table">
                                    <tr>
                                        <th style="width: 25%;">Ditambahkan</th>
                                        <td>{{ $pengumuman->created_at->diffForHumans() }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">Judul</th>
                                        <td>{{ $pengumuman->judul }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">Tanggal</th>
                                        <td>{{ $pengumuman->created_at->isoFormat('dddd, D MMMM YYYY') }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">Penulis</th>
                                        <td>{{ $pengumuman->penulis->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">Konten</th>
                                        <td>{!! $pengumuman->konten !!}</td>
                                    </tr>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                            </div>
                            <!-- /.card-footer-->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Gambar
                                </h3>
                            </div>
                            <div class="card-body">
                                <img src="<?= asset($pengumuman->foto ? "storage/".$pengumuman->foto : 'images/info.jpg') ?>" class="img-thumbnail img-preview"
                                     style="width: 100%;" alt="Administrator">
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <!-- /.content -->

    </div>
@endsection
