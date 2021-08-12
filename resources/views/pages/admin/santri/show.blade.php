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
                    <div class="col-md-3">

                        <!-- Profile Image -->
                        <div class="card card-maroon card-outline">
                            <div class="card-body box-profile">
                                <span class="badge {{ $santri->status == 'Aktif' ? 'badge-success' : 'badge-danger' }}">{{ $santri->status }}</span>
                                <span class="badge bg-maroon float-right mt-1">{{ \Carbon\Carbon::parse($santri->tanggal_lahir)->age . ' tahun' }}</span>
                                <div class="text-center image">
                                    <div class="img-circle img-thumbnail img-fluid mx-auto mb-3"
                                         style="width: 150px; height: 150px; background-repeat: no-repeat;background-size: 150px; background-position: center; background-image: url('{{ \App\Helpers\UserHelpers::getUserImage($santri->foto, $santri->jenis_kelamin) }}') ;"></div>
                                </div>

                                <h3 class="profile-username text-center">{{ $santri->nama_panggilan }}</h3>
                                @if($santri->kelas)
                                    <p class="text-muted text-center">Kelas {{ $santri->kelas->nama_kelas }}</p>
                                @endif

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- About Me Box -->
                        <div class="card card-maroon">
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
                                    <p class="text-muted">{{ \Carbon\Carbon::parse($santri->tanggal_lahir)->age }} tahun</p>
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
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header p-2">
                                <h3 class="card-title m-2">
                                    <a href="{{ route('admin.santri.index') }}" class="btn btn-outline-danger">
                                        Kembali
                                    </a>
                                </h3>
                                <ul class="nav nav-pills float-right m-2">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#kehadiran" data-toggle="tab">Kehadiran</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#pembelajaran" data-toggle="tab">Pembelajaran</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#hafalan" data-toggle="tab">Hafalan</a>
                                    </li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group">
                                    @if($bulan->count())
                                        <select class="form-control select2" id="select-bulan" style="width: 100%;">
                                            @foreach($bulan as $item)
                                                <option
                                                    value="{{ $item->bulan }}" {{ $loop->last ? 'selected' : '' }}>{{ $item->bulan }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="kehadiran">
                                        <table class="table table-hover table-bordered table-striped" id="datatable-kehadiran">
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
                        <!-- /.card -->
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
    <!--Datatable-->
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>

    <script>
        $(function () {

            $('.select2').select2();

            let bulan = $('#select-bulan').val();
            let santri_id = '{{ $santri->id }}';

            var table = $('#datatable-bs').DataTable({
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
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'hari', name: 'hari'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'hijriah', name: 'hijriah'},
                    {data: 'keterangan', name: 'keterangan'},
                ]
            });

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

            $(document).on('change', '#select-bulan', function () {
                bulan = $(this).val();
                table_kehadiran.draw();
                table_pembelajaran.draw();
                table_hafalan.draw();
            });

            $(document).on('click', '.nav-link', function () {
                table_kehadiran.draw();
                table_pembelajaran.draw();
                table_hafalan.draw();
            });

        });
    </script>
@endpush
