@extends('layouts.admin')

@section('body')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Pengajar</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.pengajar.index') }}">Pengajar</a></li>
                <li class="breadcrumb-item active">Detail</li>
                <!-- <li class="breadcrumb-item active">pengajaristrator</li> -->
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
                            <a href="{{ route('admin.pengajar.index') }}" class="btn btn-outline-danger">
                                Kembali
                            </a>
                        </h3>
                    </div>
                    <div class="card-body mb-3 p-0">
                        <table class="table">
                            <tr>
                                <th style="width: 25%;">Ditambahkan</th>
                                <td>{{ $pengajar->created_at->diffForHumans() }}</td>
                            </tr>
                            <tr>
                                <th style="width: 25%;">Nama</th>
                                <td>{{ $pengajar->nama }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $pengajar->status }}</td>
                            </tr>
                            <tr>
                                <th>Kelahiran</th>
                                <td>{{ $pengajar->tempat_lahir }}, {{ \Carbon\Carbon::parse($pengajar->tanggal_lahir)->isoFormat('DD MMMM Y') }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>{{ $pengajar->jenis_kelamin=='L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            </tr>
                            <tr>
                                <th>Nomor Telepon</th>
                                <td>{{ $pengajar->no_telp }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $pengajar->alamat }}</td>
                            </tr>
                            @isset($pengajar->kelas->nama_kelas)
                            <tr>
                                <th>Kelas</th>
                                <td>{{ $pengajar->kelas->nama_kelas }}</td>
                            </tr>
                            @endisset
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
                        <img src="{{ $pengajar->foto ? asset("storage/$pengajar->foto") : asset($pengajar->jenis_kelamin=="L" ? 'images/ikhwan.svg' : 'images/akhwat.svg') }}" class="img-thumbnail" alt="pengajaristrator">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

</div>
@endsection
