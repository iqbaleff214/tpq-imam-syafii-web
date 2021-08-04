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
                                        <td>{{ \Illuminate\Support\Facades\Auth::user()->pengajar->kelas->nama_kelas }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis</th>
                                        <td>{{ \Illuminate\Support\Facades\Auth::user()->pengajar->kelas->jenis_kelas }}</td>
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
                        @if($kurikulum->bahan->count())
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
                        @endif
                        @if($kurikulum->materi->count())
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
                        @endif
                        @if($kurikulum->metode->count())
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
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


