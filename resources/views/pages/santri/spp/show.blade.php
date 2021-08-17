@extends('layouts.santri')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">SPP</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <!-- Default box -->
                        <div class="card card-outline card-maroon">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{ route('santri.spp.index') }}" class="btn btn-outline-danger">
                                        Kembali
                                    </a>
                                </h3>
                            </div>
                            <div class="card-body mb-3 p-0">
                                <table class="table">
                                    <tr>
                                        <th style="width: 25%;">Ditambahkan</th>
                                        <td>{{ $spp->created_at->diffForHumans() }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">Bulan</th>
                                        <td>{{ $spp->bulan ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">Nama</th>
                                        <td>{{ $spp->santri->nama_lengkap }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">Nominal</th>
                                        <td>Rp{{ number_format($spp->jumlah, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">Status</th>
                                        <td>{{ $spp->status == 0 ? 'Ditagih' : ( $spp->status == 2 ? 'Diterima' : 'Dibayar') }}</td>
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
                    <div class="col-12 col-md-4">
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Bukti
                                </h3>
                            </div>
                            <div class="card-body">
                                <img src="{{ $spp->bukti ? asset("storage/$spp->bukti") : asset('images/cash.jpg') }}" class="img-thumbnail" alt="pengajaristrator">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->

    </div>
@endsection
