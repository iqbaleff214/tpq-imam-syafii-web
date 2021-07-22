@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Santri</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.santri.index') }}">Santri</a></li>
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
                                <a href="{{ route('admin.santri.index') }}" class="btn btn-outline-danger">
                                    Kembali
                                </a>
                            </h3>
                        </div>
                        <div class="card-body mb-3 p-0">
                            <table class="table">
                                <tr>
                                    <th style="width: 25%;">Ditambahkan</th>
                                    <td>{{ $santri->created_at->diffForHumans() }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 25%;">NIS</th>
                                    <td>{{ $santri->nis }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 25%;">Nama Lengkap</th>
                                    <td>{{ $santri->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 25%;">Nama Panggilan</th>
                                    <td>{{ $santri->nama_panggilan }}</td>
                                </tr>
                                <tr>
                                    <th>Kelahiran</th>
                                    <td>{{ $santri->tempat_lahir }}
                                        , {{ \Carbon\Carbon::parse($santri->tanggal_lahir)->isoFormat('DD MMMM Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>{{ $santri->jenis_kelamin=='L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                </tr>
                                <tr>
                                    <th>Saudara</th>
                                    <td>{{ 'Anak ke-' . $santri->anak_ke . ' dari ' . $santri->jumlah_saudara . ' bersaudara' }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $santri->alamat }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $santri->status }}</td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                        </div>
                        <!-- /.card-footer-->
                    </div>
                    <!-- /.card -->
                    <div class="card card-solid">
                        <div class="card-header">
                            <h3 class="card-title">
                                Wali Santri
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Hubungan</th>
                                    <th>No. Telp</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($santri->wali as $item)
                                <tr>
                                    <td>{{ $item->nama_wali }}</td>
                                    <td>{{ $item->hubungan }}</td>
                                    <td>{{ $item->no_telp }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card card-solid">
                        <div class="card-header">
                            <h3 class="card-title">
                                Administrasi
                            </h3>
                        </div>
                        <div class="card-body mb-3 p-0">
                            <table class="table">
                                <tr>
                                    <th style="width: 25%;">SPP</th>
                                    <td>{{ $santri->spp->opsi . ' (Rp' . number_format($santri->spp->jumlah, 2, ',', '.') . ')'  }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 25%;">Kelas</th>
                                    <td>{{ $santri->kelas ? $santri->kelas->nama_kelas : 'Belum Masuk' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card card-solid">
                        <div class="card-header">
                            <h3 class="card-title">
                                Foto
                            </h3>
                        </div>
                        <div class="card-body">
                            <img
                                src="{{ \App\Helpers\UserHelpers::getUserImage($santri->foto, $santri->jenis_kelamin) }}"
                                class="img-thumbnail img-preview" style="width: 100%;" alt="Santri">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->

    </div>
@endsection
