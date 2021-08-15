@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Santri</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.santri.index') }}">Santri</a></li>
                            <li class="breadcrumb-item active">Detail</li>
                            <!-- <li class="breadcrumb-item active">santriistrator</li> -->
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
                    <div class="col-md-3 col-12">

                        <!-- Profile Image -->
                        <div class="card card-maroon card-outline">
                            <div class="card-body box-profile">
                                <span
                                    class="badge {{ $santri->status == 'Aktif' ? 'badge-success' : 'badge-danger' }}">{{ $santri->status }}</span>
                                <span
                                    class="badge bg-maroon float-right mt-1">{{ \Carbon\Carbon::parse($santri->tanggal_lahir)->age . ' tahun' }}</span>
                                <div class="text-center image">
                                    <div class="img-circle img-thumbnail img-fluid mx-auto mb-3"
                                         style="width: 150px; height: 150px; background-repeat: no-repeat;background-size: 150px; background-position: center; background-image: url('{{ \App\Helpers\UserHelpers::getSantriImage($santri->foto, $santri->jenis_kelamin) }}') ;"></div>
                                </div>

                                <h3 class="profile-username text-center">{{ $santri->nama_panggilan }}</h3>
                                @if($santri->kelas)
                                    <p class="text-center">
                                        <a href="{{ route('admin.kelas.show', $santri->kelas) }}"
                                           class="text-maroon">Kelas {{ $santri->kelas->nama_kelas }}</a>
                                    </p>
                                @endif

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- About Me Box -->
                        <div class="card card-maroon card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Biodata</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div>
                                    <h6 class="font-weight-bold">NIS</h6>
                                    <p class="text-muted">{{ $santri->nis }}</p>
                                </div>
                                <hr>
                                <div>
                                    <h6 class="font-weight-bold">Nama Lengkap</h6>
                                    <p class="text-muted">{{ $santri->nama_lengkap }}</p>
                                </div>
                                <hr>
                                <div>
                                    <h6 class="font-weight-bold">Nama Panggilan</h6>
                                    <p class="text-muted">{{ $santri->nama_panggilan }}</p>
                                </div>
                                <hr>
                                <div>
                                    <h6 class="font-weight-bold">Kelahiran</h6>
                                    <p class="text-muted">{{ $santri->tempat_lahir . ', '. \Carbon\Carbon::parse($santri->tanggal_lahir)->isoFormat('D MMMM Y') }}</p>
                                </div>
                                <hr>
                                <div>
                                    <h6 class="font-weight-bold">Usia</h6>
                                    <p class="text-muted">{{ \Carbon\Carbon::parse($santri->tanggal_lahir)->age }}
                                        tahun</p>
                                </div>
                                <hr>
                                <div>
                                    <h6 class="font-weight-bold">Jenis Kelamin</h6>
                                    <p class="text-muted">{{ $santri->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                </div>
                                <hr>
                                <div>
                                    <h6 class="font-weight-bold">Saudara</h6>
                                    <p class="text-muted">{{ 'Anak ke-' . $santri->anak_ke . ' dari ' . $santri->jumlah_saudara . ' bersaudara' }}</p>
                                </div>
                                <hr>
                                <div>
                                    <h6 class="font-weight-bold">Alamat</h6>
                                    <p class="text-muted">{{ $santri->alamat }}</p>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9 col-12">

                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-header p-2">
                                        <h3 class="card-title m-2">
                                            <a href="{{ route('admin.santri.index') }}" class="btn btn-outline-danger">
                                                Kembali
                                            </a>
                                        </h3>
                                        <ul class="nav nav-pills float-right m-2">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#kehadiran"
                                                   data-toggle="tab">Kehadiran</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#pembelajaran"
                                                   data-toggle="tab">Pembelajaran</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#hafalan" data-toggle="tab">Hafalan</a>
                                            </li>
                                        </ul>
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="form-group">
                                            @if($bulan->count())
                                                <select class="custom-select select2" id="select-bulan"
                                                        style="width: 100%;">
                                                    @foreach($bulan as $item)
                                                        <option
                                                            value="{{ $item->bulan }}" {{ $loop->last ? 'selected' : '' }}>{{ $item->bulan }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="kehadiran">
                                                <table class="table table-hover table-bordered table-striped"
                                                       id="datatable-kehadiran">
                                                    <thead class="text-center">
                                                    <th style="width: 25px">No</th>
                                                    <th>Hari</th>
                                                    <th>Tanggal</th>
                                                    <th>Hijriah</th>
                                                    <th>Nilai Adab</th>
                                                    <th>Status</th>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                            <!-- /.tab-pane -->
                                            <div class="tab-pane" id="pembelajaran">
                                                <table class="table table-hover table-bordered table-striped"
                                                       id="datatable-pembelajaran">
                                                    <thead class="text-center">
                                                    <th style="width: 25px">No</th>
                                                    <th>Hari</th>
                                                    <th>Tanggal</th>
                                                    <th>Hijriah</th>
                                                    <th>Bacaan</th>
                                                    <th>Nilai</th>
                                                    <th>Keterangan</th>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                            <!-- /.tab-pane -->
                                            <div class="tab-pane" id="hafalan">
                                                <table class="table table-hover table-bordered table-striped"
                                                       id="datatable-hafalan">
                                                    <thead class="text-center">
                                                    <th style="width: 25px">No</th>
                                                    <th>Hari</th>
                                                    <th>Tanggal</th>
                                                    <th>Hijriah</th>
                                                    <th>Hafalan</th>
                                                    <th>Nilai</th>
                                                    <th>Keterangan</th>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                            <!-- /.tab-pane -->
                                        </div>
                                        <!-- /.tab-content -->
                                    </div><!-- /.card-body -->
                                </div>
                            </div>
                        </div>

                        @if($bulan->count())

                            <div class="row">
                                <div class="col-12">
                                    <div class="card card-outline card-maroon">
                                        <div class="card-header">
                                            <h3 class="card-title">Grafik Kehadiran</h3>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="barChart" width="100%"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="card card-outline card-maroon">
                                        <div class="card-header">
                                            <h3 class="card-title">Grafik Kehadiran</h3>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="doughnutChart"></canvas>
                                            <p class="text-center text-xs mt-3 text-muted" id="doughnutChartLabel"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="card card-outline card-maroon">
                                        <div class="card-header">
                                            <h3 class="card-title">Grafik Pembelajaran</h3>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="doughnutBelajarChart"></canvas>
                                            <p class="text-center text-xs mt-3 text-muted"
                                               id="doughnutBelajarChartLabel"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="card card-outline card-maroon">
                                        <div class="card-header">
                                            <h3 class="card-title">Grafik Hafalan</h3>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="doughnutHafalanChart"></canvas>
                                            <p class="text-center text-xs mt-3 text-muted"
                                               id="doughnutHafalanChartLabel"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endif

                        <div class="row">
                            <div class="col">
                                <div class="card card-maroon card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">Wali Santri</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 {{ $santri->wali->count() > 1 ? 'col-md-6' : '' }}">
                                                <div>
                                                    <h6 class="font-weight-bold">Nama</h6>
                                                    <p class="text-muted">{{ $santri->wali[0]->nama_wali }}</p>
                                                </div>
                                                <hr>
                                                <div>
                                                    <h6 class="font-weight-bold">Hubungan</h6>
                                                    <p class="text-muted">{{ $santri->wali[0]->hubungan }}</p>
                                                </div>
                                                <hr>
                                                <div>
                                                    <h6 class="font-weight-bold">Nomor Telepon</h6>
                                                    <p class="text-muted">{{ $santri->wali[0]->no_telp }}</p>
                                                </div>
                                            </div>
                                            @if($santri->wali->count() > 1)
                                                <div class="col-12 col-md-6">
                                                    <div>
                                                        <h6 class="font-weight-bold">Nama</h6>
                                                        <p class="text-muted">{{ $santri->wali[1]->nama_wali }}</p>
                                                    </div>
                                                    <hr>
                                                    <div>
                                                        <h6 class="font-weight-bold">Hubungan</h6>
                                                        <p class="text-muted">{{ $santri->wali[1]->hubungan }}</p>
                                                    </div>
                                                    <hr>
                                                    <div>
                                                        <h6 class="font-weight-bold">Nomor Telepon</h6>
                                                        <p class="text-muted">{{ $santri->wali[1]->no_telp }}</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

    </div>
@endsection

@push('link')
    <!-- Datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.bootstrap4.min.css">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"
          integrity="sha512-kq3FES+RuuGoBW3a9R2ELYKRywUEQv0wvPTItv3DSGqjpbNtGWVdvT8qwdKkqvPzT93jp8tSF4+oN4IeTEIlQA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <style>
        .nav-pills a.nav-link.active {
            background-color: #d81b60;
        }
    </style>
@endpush

@push('script')
    <!--Select2-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!--ChartJS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js"
            integrity="sha512-asxKqQghC1oBShyhiBwA+YgotaSYKxGP1rcSYTDrB0U6DxwlJjU59B67U8+5/++uFjcuVM8Hh5cokLjZlhm3Vg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!--Datatable-->
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

    <script>
        $(function () {

            $('.select2').select2();

            let bulan = $('#select-bulan').val();
            let santri_id = '{{ $santri->id }}';
            var doughnutChart = null;
            var doughnutUrl = null;
            var doughnutHafalanChart = null;
            var doughnutHafalanUrl = null;
            var doughnutBelajarChart = null;
            var doughnutBelajarUrl = null;
            var barChart = null;

            @if($bulan->count())

                doughnutUrl = "{!! route('admin.kehadiran.santri.show', $santri->id) !!}";
            var doughnutCanvas = document.getElementById('doughnutChart');
            doughnutChart = new Chart(doughnutCanvas, {
                type: 'doughnut',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Kehadiran Santri',
                        data: [],
                        backgroundColor: [],
                    }]
                }
            });
            generateChart(bulan, doughnutChart, doughnutUrl);

            doughnutHafalanUrl = "{!! route('admin.santri.hafalan', $santri) !!}";
            var doughnutHafalanCanvas = document.getElementById('doughnutHafalanChart');
            doughnutHafalanChart = new Chart(doughnutHafalanCanvas, {
                type: 'doughnut',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Kehadiran Santri',
                        data: [],
                        backgroundColor: [],
                    }]
                }
            });
            generateChart(bulan, doughnutHafalanChart, doughnutHafalanUrl);

            doughnutBelajarUrl = "{!! route('admin.santri.pembelajaran', $santri) !!}";
            var doughnutBelajarCanvas = document.getElementById('doughnutBelajarChart');
            doughnutBelajarChart = new Chart(doughnutBelajarCanvas, {
                type: 'doughnut',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Kehadiran Santri',
                        data: [],
                        backgroundColor: [],
                    }]
                }
            });
            generateChart(bulan, doughnutBelajarChart, doughnutBelajarUrl);

            var barCanvas = document.getElementById('barChart');
            barChart = new Chart(barCanvas, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [
                        {
                            label: 'Hadir',
                            data: [],
                            backgroundColor: 'green',
                        },
                        {
                            label: 'Izin',
                            data: [],
                            backgroundColor: 'blue',
                        },
                        {
                            label: 'Sakit',
                            data: [],
                            backgroundColor: 'yellow',
                        },
                        {
                            label: 'Absen',
                            data: [],
                            backgroundColor: 'red',
                        },
                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                stepSize: 1,
                                min: 0,
                                max: 100,
                            }
                        }]
                    }
                }
            });
            generateBar(barChart);

            @endif

            $('#doughnutChartLabel').text(`Grafik kehadiran bulan ${bulan}`);
            $('#doughnutHafalanChartLabel').text(`Grafik hafalan bulan ${bulan}`);
            $('#doughnutBelajarChartLabel').text(`Grafik pembelajaran bulan ${bulan}`);

            var table_kehadiran = $('#datatable-kehadiran').DataTable({
                ajax: {
                    url: "{!! route('admin.kehadiran.santri.index') !!}",
                    data: function (d) {
                        d.bulan = bulan;
                        d.santri_id = santri_id;
                    }
                },
                autoWidth: false,
                responsive: true,
                processing: true,
                serverSide: true,
                searching: false,
                lengthChange: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json'
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        action: newExportAction,
                        exportOptions: {
                            columns: ':not(.notexport)'
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        action: newExportAction,
                        exportOptions: {
                            columns: ':not(.notexport)'
                        }
                    },
                ],
                initComplete: function () {
                    var btns = $('.btn-secondary');
                    btns.addClass('btn-outline-danger btn-sm');
                    btns.removeClass('btn-secondary');
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'hari', name: 'hari'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'hijriah', name: 'hijriah'},
                    {data: 'nilai_adab', name: 'nilai_adab'},
                    {data: 'keterangan', name: 'keterangan'},
                ]
            });
            var table_pembelajaran = $('#datatable-pembelajaran').DataTable({
                ajax: {
                    url: "{!! route('admin.santri.pembelajaran', $santri) !!}",
                    data: function (d) {
                        d.bulan = bulan;
                    }
                },
                autoWidth: false,
                responsive: true,
                processing: true,
                serverSide: true,
                searching: false,
                lengthChange: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json'
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        action: newExportAction,
                        exportOptions: {
                            columns: ':not(.notexport)'
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        action: newExportAction,
                        exportOptions: {
                            columns: ':not(.notexport)'
                        }
                    },
                ],
                initComplete: function () {
                    var btns = $('.btn-secondary');
                    btns.addClass('btn-outline-danger btn-sm');
                    btns.removeClass('btn-secondary');
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'hari', name: 'hari'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'hijriah', name: 'hijriah'},
                    {data: 'ayat', name: 'ayat'},
                    {data: 'nilai', name: 'nilai'},
                    {data: 'keterangan', name: 'keterangan'},
                ]
            });
            var table_hafalan = $('#datatable-hafalan').DataTable({
                ajax: {
                    url: "{!! route('admin.santri.hafalan', $santri) !!}",
                    data: function (d) {
                        d.bulan = bulan;
                    }
                },
                autoWidth: false,
                responsive: true,
                processing: true,
                serverSide: true,
                searching: false,
                lengthChange: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json'
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        action: newExportAction,
                        exportOptions: {
                            columns: ':not(.notexport)'
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        action: newExportAction,
                        exportOptions: {
                            columns: ':not(.notexport)'
                        }
                    },
                ],
                initComplete: function () {
                    var btns = $('.btn-secondary');
                    btns.addClass('btn-outline-danger btn-sm');
                    btns.removeClass('btn-secondary');
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'hari', name: 'hari'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'hijriah', name: 'hijriah'},
                    {data: 'ayat', name: 'ayat'},
                    {data: 'nilai', name: 'nilai'},
                    {data: 'keterangan', name: 'keterangan'},
                ]
            });

            function newExportAction(e, dt, button, config) {
                var self = this;
                var oldStart = dt.settings()[0]._iDisplayStart;
                dt.one('preXhr', function (e, s, data) {
                    // Just this once, load all data from the server...
                    data.start = 0;
                    data.length = 2147483647;
                    dt.one('preDraw', function (e, settings) {
                        // Call the original action function
                        if (button[0].className.indexOf('buttons-copy') >= 0) {
                            $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                        } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                            $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                                $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                                $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                        } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                            $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                                $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                                $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                        } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                            $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                                $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                                $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                        } else if (button[0].className.indexOf('buttons-print') >= 0) {
                            $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                        }
                        dt.one('preXhr', function (e, s, data) {
                            // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                            // Set the property to what it was before exporting.
                            settings._iDisplayStart = oldStart;
                            data.start = oldStart;
                        });
                        // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                        setTimeout(dt.ajax.reload, 0);
                        // Prevent rendering of the full data to the DOM
                        return false;
                    });
                });
                // Requery the server with the new one-time export settings
                dt.ajax.reload();
            };

            $(document).on('change', '#select-bulan', function () {
                bulan = $(this).val();
                table_kehadiran.draw();
                table_pembelajaran.draw();
                table_hafalan.draw();

                $('#doughnutChartLabel').text(`Grafik kehadiran bulan ${bulan}`);
                $('#doughnutHafalanChartLabel').text(`Grafik hafalan bulan ${bulan}`);
                $('#doughnutBelajarChartLabel').text(`Grafik pembelajaran bulan ${bulan}`);
                generateChart(bulan, doughnutChart, doughnutUrl);
                generateChart(bulan, doughnutHafalanChart, doughnutHafalanUrl);
                generateChart(bulan, doughnutBelajarChart, doughnutBelajarUrl);
            });

            $(document).on('click', '.nav-link', function () {
                table_kehadiran.draw();
                table_pembelajaran.draw();
                table_hafalan.draw();
            });

        });

        function generateChart(bulan, chart, url) {
            $.ajax({
                url: url,
                method: "GET",
                data: {
                    chart: chart.config.type ?? true,
                    bulan: bulan,
                },
                success: function (res) {
                    let chartData = [];
                    let chartLabel = [];
                    let chartColor = [];
                    res.forEach(e => {
                        chartLabel.push(e.label);
                        chartData.push(e.data);
                        chartColor.push(`rgb(${Math.floor(Math.random() * 256)},${Math.floor(Math.random() * 256)},${Math.floor(Math.random() * 256)})`);
                    });
                    chart.data.labels = chartLabel;
                    chart.data.datasets[0].data = chartData;
                    chart.data.datasets[0].backgroundColor = chartColor;

                    chart.update();
                }
            });
        }

        function generateBar(chart) {
            $.ajax({
                url: "{!! route('admin.kehadiran.santri.show', $santri->id) !!}",
                method: "GET",
                data: {
                    chart: chart.config.type ?? true,
                },
                success: function (res) {
                    // console.log(res.data);
                    res.label.forEach(e => {
                        chart.data.labels.push(e.bulan);
                    });
                    res.data.forEach(e => {
                        chart.data.datasets[0].data.push(e.hadir);
                        chart.data.datasets[1].data.push(e.izin);
                        chart.data.datasets[2].data.push(e.sakit);
                        chart.data.datasets[3].data.push(e.absen);
                    });
                    chart.update();
                }
            });
        }
    </script>
@endpush
