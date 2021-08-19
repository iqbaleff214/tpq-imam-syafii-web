@extends('layouts.kepala')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Administrator</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('kepala.admin.index') }}">Administrator</a>
                            </li>
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
                <div class="col-md-3 col-12">
                    <!-- Profile Image -->
                    <div class="card card-maroon card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center image">
                                <div class="img-circle img-thumbnail img-fluid mx-auto mb-3"
                                     style="width: 150px; height: 150px; background-repeat: no-repeat;background-size: 150px; background-position: center; background-image: url('{{ \App\Helpers\UserHelpers::getUserImage($admin->foto, $admin->jenis_kelamin) }}') ;"></div>
                            </div>

                            <h3 class="profile-username text-center">{{ $admin->nama }}</h3>
                            <p class="text-center">
                                {{ $admin->jabatan }}
                            </p>

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
                                <h6 class="font-weight-bold">Kelahiran</h6>
                                <p class="text-muted">{{ $admin->tempat_lahir . ', '. \Carbon\Carbon::parse($admin->tanggal_lahir)->isoFormat('D MMMM Y') }}</p>
                            </div>
                            <hr>
                            <div>
                                <h6 class="font-weight-bold">Jenis Kelamin</h6>
                                <p class="text-muted">{{ $admin->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                            <hr>
                            <div>
                                <h6 class="font-weight-bold">Nomor Telepon</h6>
                                <p class="text-muted">{{ $admin->no_telp }}</p>
                            </div>
                            <hr>
                            <div>
                                <h6 class="font-weight-bold">Alamat</h6>
                                <p class="text-muted">{{ $admin->alamat }}</p>
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
                                        <a href="{{ route('kepala.admin.index') }}"
                                           class="btn btn-outline-danger">
                                            Kembali
                                        </a>
                                    </h3>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <table class="table table-hover table-bordered table-striped"
                                           id="datatable-bs">
                                        <thead class="text-center">
                                        <th style="width: 25px">No</th>
                                        <th style="width: 80px">Tanggal</th>
                                        <th>Judul</th>
                                        <th>Konten</th>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
                <!-- /.col -->

            </div>
        </section>
        <!-- /.content -->

    </div>
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

    <script>
        $(function() {

            //Initialize Datatables Elements
            $('#datatable-bs').DataTable({
                ajax: "{!! url()->current() !!}",
                autoWidth: false,
                responsive: true,
                processing: true,
                serverSide: true,
                pageLength: 5,
                lengthChange: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json'
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'tanggal', name: 'tanggal' },
                    { data: 'judul', name: 'judul' },
                    { data: 'konten', name: 'konten' },
                ]
            });
        });
    </script>
@endpush
