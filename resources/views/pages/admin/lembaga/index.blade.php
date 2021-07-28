@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Lembaga</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <!-- <li class="breadcrumb-item"><a href="#">Administrator</a></li> -->
                            <!-- <li class="breadcrumb-item active">Dashboard v1</li> -->
                            <li class="breadcrumb-item active">Lembaga</li>
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
                    <div class="col-12 col-md-6 col-lg-4">
                        <div id="logo-container" class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Logo
                                </h3>
                                <button class="btn btn-outline-danger btn-sm float-right" id="logo-edit">Edit</button>
                            </div>
                            <div class="card-body">
                                <img src="{{ asset("storage/$profil->foto") }}" class="img-thumbnail" alt="{{ $profil->nama }}">
                            </div>
                            <div class="card-footer logo-footer">
                                <button class="btn bg-maroon" type="submit">
                                    Simpan
                                </button>
                            </div>
                        </div>
                        <div id="sosmed-container" class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Akun Sosmed
                                </h3>
                                <button class="btn btn-outline-danger btn-sm float-right" id="sosmed-edit">Edit</button>
                            </div>
                            <div class="card-body mb-3 p-0">
                                <table class="table">
                                    <tr>
                                        <th style="width: 25%;">Email</th>
                                        <td>{{ $profil->email }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">Facebook</th>
                                        <td>{{ $profil->facebook ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">Twitter</th>
                                        <td>{{ $profil->twitter ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">Instagram</th>
                                        <td>{{ $profil->instagram ?:'-' }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">WhatsApp</th>
                                        <td>{{ $profil->whatsapp ?:'-' }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">YouTube</th>
                                        <td>{{ $profil->youtube ?:'-' }}</td>
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
                    <div class="col-12 col-md-6 col-lg-8">
                        <!-- Default box -->
                        <div id="info-container" class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Info
                                </h3>
                                <button class="btn btn-outline-danger btn-sm float-right" id="info-edit">Edit</button>
                            </div>
                            <div class="card-body mb-3 p-0">
                                <table class="table">
                                    <tr>
                                        <th style="width: 25%;">Diedit</th>
                                        <td>{{ $profil->updated_at->diffForHumans() }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">Nama</th>
                                        <td>{{ $profil->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">No. Telepon</th>
                                        <td>{{ $profil->no_telp }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">Alamat</th>
                                        <td>{{ $profil->alamat }}</td>
                                    </tr>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer" id="info-footer">
                            </div>
                            <!-- /.card-footer-->
                        </div>
                        <!-- /.card -->
                        <div id="visi-container" class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Visi dan Misi
                                </h3>
                                <button class="btn btn-outline-danger btn-sm float-right" id="visi-edit">Edit</button>
                            </div>
                            <div class="card-body mb-3 p-0">
                                <table class="table">
                                    <tr>
                                        <th style="width: 25%;">Visi</th>
                                        <td>{{ $profil->visi }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 25%;">Misi</th>
                                        <td>{{ $profil->facebook ?: '-' }}</td>
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
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{ route('admin.lembaga.create') }}" class="btn bg-maroon">Profil Lembaga Baru</a>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="datatable-bs" class="table table-bordered table-hover">
                                    <thead>
                                    <tr class="text-center">
                                        <th style="width: 25px">No</th>
                                        <th>Tanggal</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th style="width: 150px;">Aksi</th>
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
                ajax: "{!! route('admin.lembaga.index') !!}",
                autoWidth: false,
                responsive: true,
                processing: true,
                serverSide: true,
                lengthChange: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json'
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'nama', name: 'nama' },
                    { data: 'alamat', name: 'alamat' },
                    { data: 'visi', name: 'visi' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });
        });
    </script>
@endpush
