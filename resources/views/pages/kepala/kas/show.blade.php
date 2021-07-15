@extends('layouts.kepala')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kas</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <!-- <li class="breadcrumb-item"><a href="#">Kas</a></li> -->
                            <li class="breadcrumb-item active">Keuangan</li>
                            <li class="breadcrumb-item"><a href="{{ route('kepala.keuangan.kas.index') }}">Kas</a></li>
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
                                <a href="{{ route('kepala.keuangan.kas.index') }}" class="btn btn-outline-danger">
                                    Kembali
                                </a>
                            </h3>
                        </div>
                        <div class="card-body mb-3 p-0">
                            <table class="table">
                                <tr>
                                    <th style="width: 25%;">Ditambahkan</th>
                                    <td>{{ $kas->created_at->diffForHumans() }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 25%;">Uraian</th>
                                    <td>{{ $kas->uraian }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 25%;">{{ $kas->pemasukan ? 'Pemasukan' : 'Pengeluaran' }}</th>
                                    <td>Rp{{ number_format($kas->pemasukan ?: $kas->pengeluaran, 2, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 25%;">Keterangan</th>
                                    <td>{{ $kas->keterangan ?: '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button class="btn bg-maroon" type="submit">
                                Simpan
                            </button>
                            <button class="btn btn-outline-danger float-right" type="reset">
                                Reset
                            </button>
                        </div>
                        <!-- /.card-footer-->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-12 col-md-4">
                    <div class="card card-solid">
                        <div class="card-header">
                            <h3 class="card-title">
                                Bukti
                            </h3>
                        </div>
                        <div class="card-body">
                            <img src="{{ $kas->bukti ? asset("storage/$kas->bukti") : asset('images/note.jpg') }}" class="img-thumbnail" alt="pengajaristrator">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection
