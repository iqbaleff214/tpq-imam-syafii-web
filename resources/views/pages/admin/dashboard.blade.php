@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dasbor</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <!-- <li class="breadcrumb-item"><a href="#">Keuangan</a></li>
                            <li class="breadcrumb-item active">Kas</li> -->
                            <li class="breadcrumb-item active">Dasbor</li>
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
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-gradient-primary"><i class="fas fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Santri Aktif</span>
                                <span class="info-box-number">{{ $count['santri'] }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-gradient-success"><i
                                    class="fas fa-chalkboard-teacher"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Pengajar Aktif</span>
                                <span class="info-box-number">{{ $count['pengajar'] }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-gradient-olive"><i class="fas fa-coins"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Saldo Kas</span>
                                <span
                                    class="info-box-number">{{ 'Rp' . number_format($count['saldo'], 2, ',', '.') }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-gradient-cyan"><i class="fas fa-vote-yea"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Donasi Diterima</span>
                                <span
                                    class="info-box-number">{{ 'Rp' . number_format($count['donasi'], 2, ',', '.') }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <div class="row">

                    <div class="col-12 col-md-6">
                        <div class="card card-maroon card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Calon Santri Baru</h3>
                                <form action="{{ route('admin.pendaftaran.update', $profil) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="is_pendaftaran" value="{{ !$profil->is_pendaftaran }}">
                                    <button type="submit"
                                            class="btn btn-daftar float-right bg-maroon">{{ $profil->is_pendaftaran ? "Tutup Pendaftaran" : "Buka Pendaftaran" }}</button>
                                </form>
                            </div>
                            <div class="card-body">
                                <table id="datatable-santri-baru"
                                       class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr class="text-center">
                                        <th style="width: 20px">No</th>
                                        <th style="width: 50px">NIS</th>
                                        <th>Nama</th>
                                        <th>Umur</th>
                                        <th style="width: 105px">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- BAR CHART -->
                        <div class="card card-maroon">
                            <div class="card-header">
                                <h3 class="card-title">Kehadiran Santri</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="barChart"
                                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>

                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->

    </div>
@endsection

@push('link')
    <!--ChartJS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js"
            integrity="sha512-asxKqQghC1oBShyhiBwA+YgotaSYKxGP1rcSYTDrB0U6DxwlJjU59B67U8+5/++uFjcuVM8Hh5cokLjZlhm3Vg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"
          integrity="sha512-kq3FES+RuuGoBW3a9R2ELYKRywUEQv0wvPTItv3DSGqjpbNtGWVdvT8qwdKkqvPzT93jp8tSF4+oN4IeTEIlQA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <!-- Datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css">
@endpush

@push('script')
    <!--Select2-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!--Datatable-->
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>
    <script !src="">
        $(function () {

            $(document).on("click", "button[type=submit].btn-daftar", function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Anda yakin ingin {{ $profil->is_pendaftaran ? "menutup" : "membuka" }} pendaftaran?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya, saya yakin!',
                    cancelButtonText: 'Batalkan',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent('form').submit();
                    }
                });
                return false;
            });

            $(document).on("click", "button[type=submit].btn-confirm", function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Anda yakin?',
                    text: 'Tindakan tidak dapat dibatalkan!',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya, saya yakin!',
                    cancelButtonText: 'Batalkan',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent('form').submit();
                    }
                });
                return false;
            });

            $('#datatable-santri-baru').DataTable({
                ajax: {
                    url: "{!! url()->current() !!}",
                    data: function (d) {
                        d.calon = true;
                    }
                },
                autoWidth: false,
                responsive: true,
                processing: true,
                serverSide: true,
                lengthChange: false,
                info: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json'
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'nis', name: 'nis'},
                    {data: 'nama_lengkap', name: 'nama_lengkap'},
                    {data: 'umur', name: 'umur'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>
@endpush
