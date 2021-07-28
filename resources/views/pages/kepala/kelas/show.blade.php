@extends('layouts.kepala')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kelas</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('kepala.kelas.index') }}">Kelas</a></li>
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
                                <a href="{{ route('kepala.kelas.index') }}" class="btn btn-outline-danger">
                                    Kembali
                                </a>
                            </h3>
                        </div>
                        <div class="card-body mb-3 p-0">
                            <table class="table">
                                <tr>
                                    <th style="width: 25%;">Ditambahkan</th>
                                    <td>{{ $kelas->created_at->diffForHumans() }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 25%;">Nama Kelas</th>
                                    <td>{{ $kelas->nama_kelas }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 25%;">Jenis Kelas</th>
                                    <td>{{ $kelas->jenis_kelas }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 25%;">Tingkat</th>
                                    <td>{{ $kelas->kurikulum->tingkat }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 25%;">Santri</th>
                                    <td>{{ $kelas->santri->count() }}</td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                        </div>
                        <!-- /.card-footer-->
                    </div>
                    <!-- /.card -->

                @if($kelas->santri->count())

                    <!-- Default box -->
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Santri
                                </h3>
                            </div>
                            <div class="card-body mb-3">
                                <table id="datatable-bs" class="table table-bordered table-hover">
                                    <thead>
                                    <tr class="text-center">
                                        <th style="width: 50px">NIS</th>
                                        <th>Nama</th>
                                        <th style="width: 50px">Panggilan</th>
                                        <th style="width: 30px">Umur</th>
                                        <th style="width: 30px">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($kelas->santri as $item)
                                        <tr>
                                            <td>{{ $item->nis }}</td>
                                            <td>{{ $item->nama_lengkap }}</td>
                                            <td>{{ $item->nama_panggilan }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }}</td>
                                            <td>
                                                <a href="{{ route('kepala.santri.show', $item) }}" class="btn btn-success btn-xs px-2"> Lihat </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                            </div>
                            <!-- /.card-footer-->
                        </div>
                        <!-- /.card -->
                    @endif
                </div>
                <div class="col-12 col-md-4">
                    <div class="card card-solid">
                        <div class="card-header">
                            <h3 class="card-title">
                                Pengajar
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table">
                                <tr>
                                    <th style="width: 35%;">Nama Pengajar</th>
                                    <td>{{ $kelas->pengajar->nama }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2">Foto</th>
                                </tr>
                            </table>
                            <div class="mx-4 mb-4">
                                <img
                                    src="{{ $kelas->pengajar->foto ? asset("storage/".$kelas->pengajar->foto) : asset($kelas->pengajar->jenis_kelamin=="L" ? 'images/ikhwan.jpg' : 'images/akhwat.jpg') }}"
                                    class="img-thumbnail img-preview"
                                    style="width: 100%;" alt="Administrator">
                            </div>
                        </div>
                    </div>
                </div>
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
                autoWidth: false,
                responsive: true,
                processing: true,
                lengthChange: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json'
                },
                columnDefs: [
                    { orderable: false, searchable: false, targets: 4 },
                ]
            });
        });
    </script>
@endpush

