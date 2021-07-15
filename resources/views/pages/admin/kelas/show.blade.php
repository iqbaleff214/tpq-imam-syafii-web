@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kelas</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.kelas.index') }}">Kelas</a></li>
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
                                <a href="{{ route('admin.kelas.index') }}" class="btn btn-outline-danger">
                                    Kembali
                                </a>
                            </h3>
                        </div>
                        <div class="card-body mb-3 p-0">
                            <table class="table">
                                <tr>
                                    <th style="width: 25%;">Ditambahkan</th>
                                    <td>{{ $kelas->created_at->diffForHumans() }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 25%;">Nama Kelas</th>
                                    <td>{{ $kelas->nama_kelas }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 25%;">Jenis Kelas</th>
                                    <td>{{ $kelas->jenis_kelas }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 25%;">Tingkat</th>
                                    <td>{{ $kelas->kurikulum->tingkat }}</td>
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
                <div class="col-12 col-md-6">
                    <div class="card card-solid">
                        <div class="card-header">
                            <h3 class="card-title">
                                Pengajar
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table">
                                <tr>
                                    <th style="width: 35%;">Nama Pengajar</th>
                                    <td>{{ $kelas->pengajar->nama }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2">Foto</th>
                                </tr>
                            </table>
                            <div class="mx-4 mb-4">
                                <img
                                    src="{{ $kelas->pengajar->foto ? asset("storage/".$kelas->pengajar->foto) : asset($kelas->pengajar->jenis_kelamin=="L" ? 'images/ikhwan.jpg' : 'images/akhwat.jpg') }}"
                                    class="img-thumbnail img-preview"
                                    style="width: 100%;" alt="Administrator">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->

    </div>
@endsection

