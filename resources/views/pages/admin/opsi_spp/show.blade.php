@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Opsi SPP</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">SPP</li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.spp.opsi.index') }}">Opsi</a></li>
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
                                <a href="{{ route('admin.spp.opsi.index') }}" class="btn btn-outline-danger">
                                    Kembali
                                </a>
                            </h3>
                        </div>
                        <div class="card-body mb-3 p-0">
                            <table class="table">
                                <tr>
                                    <th style="width: 25%;">Ditambahkan</th>
                                    <td>{{ $opsi->created_at->diffForHumans() }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 25%;">Opsi</th>
                                    <td>{{ $opsi->opsi }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 25%;">Biaya</th>
                                    <td>Rp{{ number_format($opsi->jumlah, 2, ',', '.') }} per bulan</td>
                                </tr>
                                <tr>
                                    <th style="width: 25%;">Keterangan</th>
                                    <td>{{ $opsi->keterangan }}</td>
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
            </div>
        </section>
        <!-- /.content -->

    </div>
@endsection
