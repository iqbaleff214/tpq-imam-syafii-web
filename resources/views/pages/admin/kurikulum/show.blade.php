@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kurikulum</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.kurikulum.index') }}">Kurikulum</a>
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
                                <a href="{{ route('admin.kurikulum.index') }}" class="btn btn-outline-danger">
                                    Kembali
                                </a>
                            </h3>
                        </div>
                        <div class="card-body mb-3 p-0">
                            <table class="table">
                                <tr>
                                    <th style="width: 25%;">Ditambahkan</th>
                                    <td>{{ $kurikulum->created_at->diffForHumans() }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%">Tingkat</th>
                                    <td>{{ $kurikulum->tingkat }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%">Jadwal</th>
                                    <td>{{ $kurikulum->mulai }} s.d. {{ $kurikulum->selesai }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%">Target</th>
                                    <td>{{ $kurikulum->target }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%">Catatan</th>
                                    <td>{{ $kurikulum->keterangan }}</td>
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
                                Bahan Pendidikan
                            </h3>
                        </div>
                        <div class="card-body mb-3 p-0">
                            <table class="table">
                                @foreach($kurikulum->bahan as $bahan)
                                    <tr>
                                        <td style="width: 5px">{{ $loop->iteration }}.</td>
                                        <td>{{ $bahan->bahan }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="card card-solid">
                        <div class="card-header">
                            <h3 class="card-title">
                                Materi Kurikulum
                            </h3>
                        </div>
                        <div class="card-body mb-3 p-0">
                            <table class="table">
                                @foreach($kurikulum->materi as $materi)
                                    <tr>
                                        <td style="width: 5px">{{ $loop->iteration }}.</td>
                                        <td>{{ $materi->materi }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="card card-solid">
                        <div class="card-header">
                            <h3 class="card-title">
                                Metode Pembelajaran
                            </h3>
                        </div>
                        <div class="card-body mb-3 p-0">
                            <table class="table">
                                @foreach($kurikulum->metode as $metode)
                                    <tr>
                                        <td style="width: 5px">{{ $loop->iteration }}.</td>
                                        <td>{{ $metode->metode }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

