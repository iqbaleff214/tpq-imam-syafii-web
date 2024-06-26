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
                            <li class="breadcrumb-item active">Kas</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if($total->jml_saldo)
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="callout callout-success">
                                <h5>Rekap Total</h5>
                                <dl class="row">
                                    <dt class="col-sm-4">Tanggal</dt>
                                    <dd class="col-sm-8">{{ $total->min_date . ' s.d. ' . $total->max_date }}</dd>
                                    <dt class="col-sm-4">Pemasukan</dt>
                                    <dd class="col-sm-8">{{ 'Rp' . number_format($total->jml_pemasukan, 2, ',', '.') }}</dd>
                                    <dt class="col-sm-4">Pengeluaran</dt>
                                    <dd class="col-sm-8">{{ 'Rp' . number_format($total->jml_pengeluaran, 2, ',', '.') }}</dd>
                                    <dt class="col-sm-4">Saldo</dt>
                                    <dd class="col-sm-8">{{ 'Rp' . number_format($total->jml_saldo, 2, ',', '.') }}</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="callout callout-info">
                                <h5>Rekap Bulan {{ \Carbon\Carbon::now()->isoFormat('MMMM Y') }}</h5>
                                <dl class="row">
                                    <dt class="col-sm-4">Tanggal</dt>
                                    <dd class="col-sm-8">{{ \Carbon\Carbon::now()->isoFormat('DD-MM-Y') }}</dd>
                                    <dt class="col-sm-4">Pemasukan</dt>
                                    <dd class="col-sm-8">{{ 'Rp' . number_format($sekarang->pemasukan, 2, ',', '.') }}</dd>
                                    <dt class="col-sm-4">Pengeluaran</dt>
                                    <dd class="col-sm-8">{{ 'Rp' . number_format($sekarang->pengeluaran, 2, ',', '.') }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-widget collapsed-card card-maroon card-outline">
                                <div class="card-header">
                                    <div class="user-block">
                                        <h3 class="card-title" data-card-widget="collapse"
                                            style="cursor: pointer">
                                            Tampilkan Bagan
                                        </h3>
                                    </div>
                                    <!-- /.user-block -->
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <!-- /.card-tools -->
                                </div>
                                <div class="card-body">
                                    <canvas id="barChart" height="30px" width="100%"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                @if($total->jml_saldo)
                                    <div class="card card-widget collapsed-card">
                                        <div class="card-header">
                                            <div class="user-block">
                                                <h3 class="card-title" data-card-widget="collapse"
                                                    style="cursor: pointer">
                                                    Filter
                                                </h3>
                                            </div>
                                            <!-- /.user-block -->
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <!-- /.card-tools -->
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body" style="display: none;">

                                            <div class="row">

                                                <div class="col-12 col-md-6">
                                                    <label for="select-jenis">Jenis</label>
                                                    <select class="custom-select" id="select-jenis">
                                                        <option value="" selected>Semua</option>
                                                        <option value="pemasukan">Pemasukan</option>
                                                        <option value="pengeluaran">Pengeluaran</option>
                                                    </select>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label>Rentang Waktu</label>
                                                        <input type="text" class="form-control"
                                                               id="select-rentang">
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer" style="display: none;">
                                            <button class="btn bg-maroon" id="filter-submit">Cari</button>
                                            <button class="btn btn-outline-danger float-right" id="filter-reset">
                                                Batalkan
                                            </button>
                                        </div>
                                        <!-- /.card-footer -->
                                    </div>
                                @endif
                                <table id="datatable-bs" class="table table-bordered table-hover">
                                    <thead>
                                    <tr class="text-center">
                                        <th style="width: 25px">No</th>
                                        <th style="width: 100px">Tanggal</th>
                                        <th>Uraian</th>
                                        <th style="width: 100px;">Pemasukan</th>
                                        <th style="width: 100px;">Pengeluaran</th>
                                        <th style="width: 100px">Saldo</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->

    </div>
@endsection

@push('link')
    <!-- Daterangepicker -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <!-- Datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.bootstrap4.min.css">
@endpush

@push('script')
    <!--Daterangepicker-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
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

            let jenis = null;
            let dari = null;
            let sampai = null;

            @if($total->jml_saldo)
            var barCanvas = document.getElementById('barChart');
            var barChart = new Chart(barCanvas, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [
                        {
                            label: 'Pemasukan',
                            data: [],
                            backgroundColor: 'green',
                            borderColor: 'green',
                        },
                        {
                            label: 'Pengeluaran',
                            data: [],
                            backgroundColor: 'red',
                            borderColor: 'red',
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

            // Date range picker
            $('#select-rentang').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                },
                opens: 'left'
            }, function (start, end, label) {
                dari = start.format('DD/MM/YYYY');
                sampai = end.format('DD/MM/YYYY');
            });

            $(document).on('click', '#filter-submit', function () {
                const selected_jenis = $('#select-jenis').val();

                $.ajax({
                    url: "{{ url()->current() }}",
                    method: 'GET',
                    data: {
                        filter: true,
                        dari: dari,
                        sampai: sampai
                    },
                    success: function(res) {
                        $('#rekap-dari').text(res.min_date);
                        $('#rekap-sampai').text(res.max_date);
                        $('#rekap-pemasukan').text(res.jml_pemasukan);
                        $('#rekap-pengeluaran').text(res.jml_pengeluaran);
                    }
                });

                jenis = selected_jenis !== '' ? selected_jenis : null;
                table.draw();
            });

            $(document).on('click', '#filter-reset', function () {
                jenis = null;
                dari = null;
                sampai = null;
                table.draw();
            });

            //Initialize Datatables Elements
            const table = $('#datatable-bs').DataTable({
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 rows', '25 rows', '50 rows', 'Show all']
                ],
                bLengthChange: true,
                ajax: {
                    url: "{!! url()->current() !!}",
                    data: function (d) {
                        d.jenis = jenis;
                        d.dari = dari;
                        d.sampai = sampai;
                    }
                },
                autoWidth: false,
                responsive: true,
                processing: true,
                serverSide: true,
                searching: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json'
                },
                dom: '<"html5buttons">Bfrtip',
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
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false},
                    {data: 'tanggal', name: 'tanggal', orderable: false},
                    {data: 'uraian', name: 'uraian', orderable: false},
                    {data: 'pemasukan', name: 'pemasukan', orderable: false},
                    {data: 'pengeluaran', name: 'pengeluaran', orderable: false},
                    {data: 'saldo', name: 'saldo', orderable: false},
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
            }
        });

        function generateBar(chart) {
            $.ajax({
                url: "{!! url()->current() !!}",
                method: "GET",
                data: {
                    chart: chart.config.type ?? true,
                },
                success: function (res) {
                    res.label.forEach(e => {
                        chart.data.labels.push(e.bulan);
                    });
                    res.data.forEach(e => {
                        chart.data.datasets[0].data.push(e.pemasukan);
                        chart.data.datasets[1].data.push(e.pengeluaran);
                    });
                    chart.update();
                }
            });
        }
    </script>
@endpush
