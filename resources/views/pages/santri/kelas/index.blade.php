@extends('layouts.santri')

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
        <section class="content">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <!-- Default box -->
                        <div class="card card-solid card-maroon">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Kurikulum
                                </h3>
                            </div>
                            <div class="card-body mb-3 p-0">
                                <table class="table">
                                    <tr>
                                        <th style="width: 30%;">Terakhir diubah</th>
                                        <td>{{ $kurikulum->updated_at->diffForHumans() }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kelas</th>
                                        <td>{{ \Illuminate\Support\Facades\Auth::user()->santri->kelas->nama_kelas }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis</th>
                                        <td>{{ \Illuminate\Support\Facades\Auth::user()->santri->kelas->jenis_kelas }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tingkat</th>
                                        <td>{{ $kurikulum->tingkat }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jadwal</th>
                                        <td>{{ $kurikulum->mulai }} s.d. {{ $kurikulum->selesai }}</td>
                                    </tr>
                                    <tr>
                                        <th>Target</th>
                                        <td>{{ $kurikulum->target }}</td>
                                    </tr>
                                    <tr>
                                        <th>Catatan</th>
                                        <td>{{ $kurikulum->keterangan }}</td>
                                    </tr>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-12 col-md-6">

                        <div class="row">
                            <div class="col-12 col-md-12">
                                <!-- Profile Image -->
                                <div class="card card-maroon card-outline">
                                    <div class="card-body box-profile">
                                <span
                                    class="badge {{ $kelas->pengajar->status == 'Aktif' ? 'badge-success' : 'badge-danger' }}">{{ $kelas->pengajar->status }}</span>
                                        <div class="text-center image">
                                            <div class="img-circle img-thumbnail img-fluid mx-auto mb-3"
                                                 style="width: 150px; height: 150px; background-repeat: no-repeat;background-size: 150px; background-position: center; background-image: url('{{ \App\Helpers\UserHelpers::getUserImage($kelas->pengajar->foto, $kelas->pengajar->jenis_kelamin) }}') ;"></div>
                                        </div>
                                        <h3 class="profile-username text-center">{{ $kelas->pengajar->nama }}</h3>

                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>

                        @if($kurikulum->bahan->count())
                            <div class="row">
                                <div class="col">
                                    <div class="card card-solid card-maroon">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                Bahan Pendidikan
                                            </h3>
                                        </div>
                                        <div class="card-body mb-3 p-0">
                                            <table class="table">
                                                @foreach($kurikulum->bahan as $bahan)
                                                    <tr>
                                                        @if($kurikulum->bahan->count() > 1)
                                                            <td style="width: 5px">{{ $loop->iteration }}.</td>
                                                        @endif
                                                        <td>{{ $bahan->bahan }}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($kurikulum->materi->count())
                            <div class="row">
                                <div class="col">
                                    <div class="card card-solid card-maroon">

                                        <div class="card-header">
                                            <h3 class="card-title">
                                                Materi Kurikulum
                                            </h3>
                                        </div>
                                        <div class="card-body mb-3 p-0">
                                            <table class="table">
                                                @foreach($kurikulum->materi as $materi)
                                                    <tr>
                                                        @if($kurikulum->materi->count() > 1)
                                                            <td style="width: 5px">{{ $loop->iteration }}.</td>
                                                        @endif
                                                        <td>{{ $materi->materi }}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($kurikulum->metode->count())
                            <div class="row">
                                <div class="col">
                                    <div class="card card-solid card-maroon">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                Metode Pembelajaran
                                            </h3>
                                        </div>
                                        <div class="card-body mb-3 p-0">
                                            <table class="table">
                                                @foreach($kurikulum->metode as $metode)
                                                    <tr>
                                                        @if($kurikulum->metode->count() > 1)
                                                            <td style="width: 5px">{{ $loop->iteration }}.</td>
                                                        @endif
                                                        <td>{{ $metode->metode }}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


