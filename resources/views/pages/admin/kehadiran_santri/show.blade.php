@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kehadiran Santri</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Kehadiran</li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.kehadiran.santri.index') }}">Santri</a></li>
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
                    <div class="col-12 col-md-3">
                        <!-- Profile Image -->
                        <div class="card card-maroon card-outline">
                            <div class="card-body box-profile">
                                <span
                                    class="badge {{ $presensi->santri->status == 'Aktif' ? 'badge-success' : 'badge-danger' }}">{{ $presensi->santri->status }}</span>
                                <span
                                    class="badge bg-maroon float-right mt-1">{{ \Carbon\Carbon::parse($presensi->santri->tanggal_lahir)->age . ' tahun' }}</span>
                                <div class="text-center image">
                                    <div class="img-circle img-thumbnail img-fluid mx-auto mb-3"
                                         style="width: 150px; height: 150px; background-repeat: no-repeat;background-size: 150px; background-position: center; background-image: url('{{ \App\Helpers\UserHelpers::getSantriImage($presensi->santri->foto, $presensi->santri->jenis_kelamin) }}') ;"></div>
                                </div>

                                <h3 class="profile-username text-center">
                                    <a href="{{ route('admin.santri.show', $presensi->santri) }}">
                                    {{ $presensi->santri->nama_panggilan }}
                                    </a>
                                </h3>
                                @if($presensi->santri->kelas)
                                    <p class="text-center">
                                        <a href="{{ route('admin.kelas.show', $presensi->santri->kelas) }}"
                                           class="text-maroon">Kelas {{ $presensi->santri->kelas->nama_kelas }}</a>
                                    </p>
                                @endif

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-12 col-md-9">
                        <!-- Default box -->
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{ route('admin.kehadiran.santri.index') }}"
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
                                        <th style="width: 25%;">Status</th>
                                        <td>{{ $presensi->keterangan }}</td>
                                    </tr>
                                    @if($presensi->keterangan == 'Hadir')
                                    <tr>
                                        <th style="width: 25%;">Nilai Adab</th>
                                        <td>{{ $presensi->nilai_adab }}</td>
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

