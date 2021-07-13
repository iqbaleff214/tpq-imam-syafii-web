@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dasbor</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <!-- <li class="breadcrumb-item"><a href="#">Keuangan</a></li>
                            <li class="breadcrumb-item active">Kas</li> -->
                            <li class="breadcrumb-item active">Dasbor</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Santri</span>
                                <span class="info-box-number">{{ $count['santri'] }} (+15)</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fas fa-chalkboard-teacher"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Pengajar</span>
                                <span class="info-box-number">{{ $count['pengajar'] }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fas fa-coins"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Saldo Kas</span>
                                <span class="info-box-number">Rp{{ number_format($count['saldo'], 2, ',', '.') }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Perlu Persetujuan</span>
                                <span class="info-box-number">5</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <div class="row">

                    <div class="col-12 col-md-6">
                        <!-- BAR CHART -->
                        <div class="card card-maroon">
                            <div class="card-header">
                                <h3 class="card-title">Kehadiran Santri</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- BAR CHART -->
                        <div class="card card-maroon">
                            <div class="card-header">
                                <h3 class="card-title">Santri Baru</h3>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>TTL</th>
                                        <th>JK</th>
                                        <th>Telp.</th>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>M. Iqbal Effendi</td>
                                        <td>21/04/2000</td>
                                        <td>L</td>
                                        <td>082159142175</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Nafila Fayruz</td>
                                        <td>16/01/2001</td>
                                        <td>P</td>
                                        <td>082159142175</td>
                                    </tr>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->

    </div>
@endsection
