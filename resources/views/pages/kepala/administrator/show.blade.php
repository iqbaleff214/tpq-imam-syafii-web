@extends('layouts.kepala')

@section('body')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Administrator</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('kepala.admin.index') }}">Administrator</a></li>
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
            <div class="col-12 col-sm-6 col-md-8">
                <!-- Default box -->
                <div class="card card-solid">
                    <div class="card-header">
                        <h3 class="card-title">
                            <a href="{{ route('kepala.admin.index') }}" class="btn btn-outline-danger">
                                Kembali
                            </a>
                        </h3>
                    </div>
                    <div class="card-body mb-3 p-0">
                        <table class="table">
                            <tr>
                                <th style="width: 25%;">Ditambahkan</th>
                                <td>{{ $admin->created_at->diffForHumans() }}</td>
                            </tr>
                            <tr>
                                <th style="width: 25%;">Nama</th>
                                <td>{{ $admin->nama }}</td>
                            </tr>
                            <tr>
                                <th>Jabatan</th>
                                <td>{{ $admin->jabatan }}</td>
                            </tr>
                            <tr>
                                <th>Kelahiran</th>
                                <td>{{ $admin->tempat_lahir }}, {{ \Carbon\Carbon::parse($admin->tanggal_lahir)->isoFormat('D MMMM Y') }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>{{ $admin->jenis_kelamin=='L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            </tr>
                            <tr>
                                <th>Nomor Telepon</th>
                                <td>{{ $admin->no_telp }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $admin->alamat }}</td>
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
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card card-solid">
                    <div class="card-header">
                        <h3 class="card-title">
                            Foto
                        </h3>
                    </div>
                    <div class="card-body">
                        <img src="{{ \App\Helpers\UserHelpers::getUserImage($admin->foto, $admin->jenis_kelamin) }}" class="img-thumbnail" alt="Administrator">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

</div>
@endsection
