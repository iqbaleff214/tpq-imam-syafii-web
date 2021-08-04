@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kehadiran Santri</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Kehadiran</li>
                            <li class="breadcrumb-item active">Santri</li>
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
                                    <a href="{{ route('admin.kehadiran.santri.create') }}" class="btn bg-maroon">Presensi
                                        Baru</a>
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
                                                <div class="col-12 col-md-4">
                                                    <label for="select-santri">Santri</label>
                                                    <select class="custom-select" id="select-santri">
                                                        <option value="" selected>Semua</option>
                                                        @foreach($santri as $item)
                                                            <option
                                                                value="{{ $item->id }}">{{ $item->nama_lengkap }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <label for="select-hari">Hari</label>
                                                    <select class="custom-select" id="select-hari">
                                                        <option value="" selected>Semua</option>
                                                        @foreach($hari as $key => $val)
                                                            <option
                                                                value="{{ $key }}">{{ $val }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <label for="select-status">Status</label>
                                                    <select class="custom-select" id="select-status">
                                                        <option value="" selected>Semua</option>
                                                        <option value="Hadir">Hadir</option>
                                                        <option value="Sakit">Sakit</option>
                                                        <option value="Izin">Izin</option>
                                                        <option value="Absen">Absen</option>
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
                                        <th style="width: 50px">Hari</th>
                                        <th style="width: 75px">Tanggal</th>
                                        <th style="width: 75px">Hijriah</th>
                                        <th>Nama Santri</th>
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
            let santri_id = null;
            let hari = null;
            let keterangan = null;

            var table = $('#datatable-bs').DataTable({
                ajax: {
                    url: "{!! route('admin.kehadiran.santri.index') !!}",
                    data: function (d) {
                        d.bulan = bulan;
                        d.santri_id = santri_id;
                        d.hari = hari;
                        d.keterangan = keterangan;
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
                    {data: 'hari', name: 'hari'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'hijriah', name: 'hijriah'},
                    {data: 'santri', name: 'santri'},
                    {data: 'keterangan', name: 'keterangan'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $(document).on('click', '#filter-submit', function () {
                const selected_santri = $('#select-santri').val();
                const selected_hari = $('#select-hari').val();
                const selected_status = $('#select-status').val();

                santri_id = selected_santri !== '' ? selected_santri : null;
                hari = selected_hari !== '' ? selected_hari : null;
                keterangan = selected_status !== '' ? selected_status : null;

                table.draw();
            });

            $(document).on('click', '#filter-reset', function () {
                santri_id = null;
                hari = null;
                keterangan = null;
                table.draw();
            });

            $(document).on('change', '#select-bulan', function () {
                bulan = $(this).val();
                table.draw();
            });

        });
    </script>
@endpush
