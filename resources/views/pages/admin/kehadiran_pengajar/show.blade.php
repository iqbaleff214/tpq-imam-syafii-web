@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kehadiran Pengajar</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Kehadiran</li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.kehadiran.pengajar.index') }}">Pengajar</a></li>
                            <li class="breadcrumb-item active">Detail</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
                <div class="row">
                    <div class="col-12">
                        <!-- Default box -->
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{ route('admin.kehadiran.pengajar.index') }}"
                                       class="btn btn-outline-danger">
                                        Kembali
                                    </a>
                                </h3>
                            </div>
                            <div class="card-body mb-3 p-0">
                                <table class="table">
                                    <tr>
                                        <th style="width: 25%;">Tanggal</th>
                                        <td>{{ $presensi->created_at->isoFormat('dddd, D MMMM YYYY') }} / {{ \GeniusTS\HijriDate\Hijri::convertToHijri($presensi->created_at)->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">Nama</th>
                                        <td>{{ $presensi->pengajar->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">Status</th>
                                        <td>{{ $presensi->keterangan }}</td>
                                    </tr>
                                    @if($presensi->keterangan == 'Hadir')
                                    <tr>
                                        <th style="width: 25%;">Waktu</th>
                                        <td>{{ \Carbon\Carbon::parse($presensi->datang)->format('H.i') }}
                                            -{{ \Carbon\Carbon::parse($presensi->pulang)->format('H.i') }}
                                            WITA</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                            </div>
                            <!-- /.card-footer-->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
        </section>
        <!-- /.content -->

    </div>
@endsection

