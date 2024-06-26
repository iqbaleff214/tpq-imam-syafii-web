@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Inventaris</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.inventaris.index') }}">Inventaris</a></li>
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
                                    <a href="{{ route('admin.inventaris.index') }}" class="btn btn-outline-danger">
                                        Kembali
                                    </a>
                                </h3>
                            </div>
                            <div class="card-body mb-3 p-0">
                                <table class="table">
                                    <tr>
                                        <th style="width: 25%;">Ditambahkan</th>
                                        <td>{{ $inventaris->created_at->diffForHumans() }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">Kode</th>
                                        <td>{{ $inventaris->kode_barang }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">Barang</th>
                                        <td>{{ $inventaris->nama_barang }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">Satuan</th>
                                        <td>{{ $inventaris->satuan }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">Total</th>
                                        <td>{{ $inventaris->jumlah_baik + $inventaris->jumlah_rusak }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">Jumlah Baik</th>
                                        <td>{{ $inventaris->jumlah_baik }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">Jumlah Rusak</th>
                                        <td>{{ $inventaris->jumlah_rusak }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">Keterangan</th>
                                        <td>{{ $inventaris->keterangan }}</td>
                                    </tr>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-12 col-md-4">

                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Foto
                                </h3>
                            </div>
                            <div class="card-body">
                                <img src="{{ $inventaris->foto ? asset("storage/$inventaris->foto") : asset('images/inventory.jpg') }}" class="img-thumbnail img-preview" style="width: 100%;" alt="Administrator">
                            </div>
                        </div>

                        <div class="card card-outline card-maroon">
                            <div class="card-header">
                                <h3 class="card-title">Grafik Kondisi</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="doughnutChart"></canvas>
                                <p class="text-center text-xs mt-3 text-muted"
                                   id="doughnutChartLabel"></p>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <!-- /.content -->

    </div>
@endsection

@push('script')
    <!--ChartJS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js"
            integrity="sha512-asxKqQghC1oBShyhiBwA+YgotaSYKxGP1rcSYTDrB0U6DxwlJjU59B67U8+5/++uFjcuVM8Hh5cokLjZlhm3Vg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script !src="">
        $(function() {
            const chart = new Chart($('#doughnutChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Baik', 'Rusak'],
                    datasets: [{
                        label: 'Rasio Santri',
                        data: [{{ intval($inventaris->jumlah_baik) }}, {{ intval($inventaris->jumlah_rusak) }}],
                        backgroundColor: ['#52ad42', '#ec2f2f'],
                    }]
                }
            });
        });
    </script>
@endpush
