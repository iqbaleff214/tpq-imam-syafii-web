@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Honor</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Keuangan</li>
                            <li class="breadcrumb-item active">Honor</li>
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{ route('admin.keuangan.honor.create') }}" class="btn bg-maroon">Bayar Honor</a>
                                </h3>
                                @if($bulan->count())
                                    <div class="row">
                                        <div class="col-12 col-sm-6 offset-sm-6">
                                            <select class="select2 form-control" id="select-bulan">
                                                @foreach($bulan as $item)
                                                    <option
                                                        value="{{ $item->bulan }}" {{ $loop->last ? 'selected' : '' }}>{{ $item->bulan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @if($bulan->count())
                                    <div class="card card-widget collapsed-card">
                                        <div class="card-header">
                                            <div class="user-block">
                                                <h3 class="card-title" data-card-widget="collapse" style="cursor: pointer">
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
                                                    <label for="select-pengajar">Pengajar</label>
                                                    <select class="custom-select" id="select-pengajar">
                                                        <option value="" selected>Semua</option>
                                                        @foreach($pengajar as $item)
                                                            <option
                                                                value="{{ $item->id }}">{{ $item->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="select-status">Status</label>
                                                    <select class="custom-select" id="select-status">
                                                        <option value="" selected>Semua</option>
                                                        <option value="1">Diterima</option>
                                                        <option value="0">Menunggu</option>
                                                    </select>
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
                                        <th style="width: 75px">Tanggal</th>
                                        <th style="width: 100px">Bulan</th>
                                        <th>Nama Pengajar</th>
                                        <th>Nominal</th>
                                        <th style="width: 100px">Status</th>
                                        <th style="width: 150px;" class="notexport">Aksi</th>
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
    <!-- Datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.bootstrap4.min.css">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"
          integrity="sha512-kq3FES+RuuGoBW3a9R2ELYKRywUEQv0wvPTItv3DSGqjpbNtGWVdvT8qwdKkqvPzT93jp8tSF4+oN4IeTEIlQA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
@endpush

@push('script')
    <!--Select2-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
            let pengajar_id = null;
            let status = null;

            var table = $('#datatable-bs').DataTable({
                ajax: {
                    url: "{!! route('admin.keuangan.honor.index') !!}",
                    data: function (d) {
                        d.bulan = bulan;
                        d.pengajar_id = pengajar_id;
                        d.status = status;
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
                        exportOptions: {
                            columns: ':not(.notexport)'
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        exportOptions: {
                            columns: ':not(.notexport)'
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        orientation: 'landscape',
                        exportOptions: {
                            columns: ':not(.notexport)'
                        },
                        customize: function (doc) {
                            doc.content[1].table.widths =
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }
                    }
                ],
                initComplete: function () {
                    var btns = $('.btn-secondary');
                    btns.addClass('btn-outline-danger btn-sm');
                    btns.removeClass('btn-secondary');

                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'bulan', name: 'bulan'},
                    {data: 'pengajar', name: 'pengajar'},
                    {data: 'jumlah', name: 'jumlah'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $(document).on('click', '#filter-submit', function () {
                const selected_pengajar = $('#select-pengajar').val();
                const selected_status = $('#select-status').val();

                pengajar_id = selected_pengajar !== '' ? selected_pengajar : null;
                status = selected_status !== '' ? selected_status : null;

                table.draw();
            });

            $(document).on('click', '#filter-reset', function () {
                pengajar_id = null;
                status = null;
                table.draw();
            });

            $(document).on('change', '#select-bulan', function () {
                bulan = $(this).val();
                table.draw();
            });

        });
    </script>
@endpush
