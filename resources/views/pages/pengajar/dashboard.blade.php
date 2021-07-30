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
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">

                        <div class="card card-maroon card-outline">
                            <div class="card-body">

                                <div class="container">
                                    <div class="row">
                                        <div class="col-6">
                                            <h4>{{ \Carbon\Carbon::today()->isoFormat('dddd') }}</h4>
                                        </div>
                                        <div class="col-6">
                                            <h5 class="text-right">{{ \GeniusTS\HijriDate\Date::today()->format(' d F o') }}</h5>
                                            <h6 class="text-right text-muted">{{ \Carbon\Carbon::today()->isoFormat('D MMMM Y') }}</h6>
                                        </div>
                                    </div>
                                    @if($ngaji)
                                        <div class="row mt-4">
                                            @if($presensi)
                                                @if($presensi->datang)
                                                    @if($presensi->pulang)
                                                        <div class="col-4">
                                                            Pembelajaran
                                                            Selesai: {{ \Carbon\Carbon::parse($presensi->datang)->format('H.i') }}
                                                            -{{ \Carbon\Carbon::parse($presensi->pulang)->format('H.i') }}
                                                            WITA
                                                        </div>
                                                    @else
                                                        <div class="col-4">
                                                            <form
                                                                action="{{ route('pengajar.kehadiran.update', $presensi) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn bg-maroon btn-block">
                                                                    Selesai
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="col-4">
                                                        <h3 class="text-muted">{{ $presensi->keterangan }}</h3>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="col-4">
                                                    <form action="{{ route('pengajar.kehadiran.store') }}"
                                                          method="post">
                                                        @csrf
                                                        <button type="submit" class="btn bg-maroon btn-block"
                                                                name="keterangan" value="Hadir">Hadir
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="col-4">
                                                    <form action="{{ route('pengajar.kehadiran.store') }}"
                                                          method="post">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-danger btn-block"
                                                                name="keterangan" value="Izin">Izin
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="col-4">
                                                    <form action="{{ route('pengajar.kehadiran.store') }}"
                                                          method="post">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-danger btn-block"
                                                                name="keterangan" value="Sakit">Sakit
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div><!-- /.card -->

                        @if($presensi_bulan->count())
                            <div class="card card-maroon card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        @foreach($presensi_bulan as $bulan)
                                            <li class="nav-item">
                                                <a class="nav-link opsi-bulan-kehadiran {{ $loop->last ? 'active' : '' }}"
                                                   data-toggle="pill"
                                                   role="button">{{ $bulan->bulan }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="card-body p-0">

                                    <table class="table table-hover table-striped" id="tabel-kehadiran">
                                        <thead class="text-center">
                                        <th style="width: 25px">No</th>
                                        <th>Hari</th>
                                        <th>Tanggal</th>
                                        <th>Hijriah</th>
                                        <th>Status</th>
                                        </thead>
                                        <tbody></tbody>
                                    </table>

                                </div>
                                <!-- /.card -->
                            </div>
                        @endif
                    </div>
                    <!-- /.col-md-6 -->

                    <div class="col-lg-6">

                        <div class="card card-maroon card-outline">
                            <div class="card-header">
                                <h5 class="card-title m-0">Featured</h5>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title">Special title treatment</h6>

                                <p class="card-text">With supporting text below as a natural lead-in to additional
                                    content.</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@push('link')
    <!-- Datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css">
@endpush

@push('script')
    <!--Datatable-->
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>

    <script !src="">
        $(document).ready(function () {

            let bulan_kehadiran = $('.opsi-bulan-kehadiran.active').text();

            var tb_kehadiran = $('#tabel-kehadiran').DataTable({
                ajax: {
                    url: '{!! route('pengajar.kehadiran.index') !!}',
                    data: function (d) {
                        d.bulan = bulan_kehadiran
                    }
                },
                autoWidth: false,
                paging: false,
                searching: false,
                info: false,
                responsive: true,
                processing: true,
                serverSide: true,
                lengthChange: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json'
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'hari', name: 'hari' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'hijriah', name: 'hijriah' },
                    { data: 'keterangan', name: 'keterangan' },
                ]
            });

            $(document).on('click', '.opsi-bulan-kehadiran', function () {
                bulan_kehadiran = $(this).text();
                tb_kehadiran.draw();
            });
        });
    </script>
@endpush
