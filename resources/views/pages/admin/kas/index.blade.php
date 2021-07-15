@extends('layouts.admin')

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
                <div class="row">
                    @if($total['oldest'])
                        <div class="col-12 col-md-6">
                            <div class="callout callout-success">
                                <h5>Rekap</h5>
                                <dl class="row">
                                    <dt class="col-sm-4">Bulan</dt>
                                    <dd class="col-sm-8">{{ $total['oldest']->created_at->isoFormat('MMMM Y') }}
                                        s.d. {{ $total['latest']->created_at->isoFormat('MMMM Y') }}</dd>
                                    <dt class="col-sm-4">Pemasukan</dt>
                                    <dd class="col-sm-8">Rp{{ number_format($total['pemasukan'], 2, ',', '.') }}</dd>
                                    <dt class="col-sm-4">Pengeluaran</dt>
                                    <dd class="col-sm-8">Rp{{ number_format($total['pengeluaran'], 2, ',', '.') }}</dd>
                                    <dt class="col-sm-4">Saldo</dt>
                                    <dd class="col-sm-8">
                                        Rp{{ number_format($total['pemasukan'] - $total['pengeluaran'], 2, ',', '.') }}</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="callout callout-danger">
                                <h5>Rekap Bulan ini</h5>
                                <dl class="row">
                                    <dt class="col-sm-4">Bulan</dt>
                                    <dd class="col-sm-8">{{ \Carbon\Carbon::now()->isoFormat('MMMM Y') }}</dd>
                                    <dt class="col-sm-4">Pemasukan</dt>
                                    <dd class="col-sm-8">Rp{{ number_format($sekarang['pemasukan'], 2, ',', '.') }}</dd>
                                    <dt class="col-sm-4">Pengeluaran</dt>
                                    <dd class="col-sm-8">
                                        Rp{{ number_format($sekarang['pengeluaran'], 2, ',', '.') }}</dd>
                                    <dt class="col-sm-4">Saldo</dt>
                                    <dd class="col-sm-8">
                                        Rp{{ number_format($sekarang['pemasukan'] - $sekarang['pengeluaran'], 2, ',', '.') }}</dd>
                                </dl>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{ route('admin.keuangan.kas.create') }}" class="btn bg-maroon">Uraian
                                        Baru</a>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="datatable-bs" class="table table-bordered table-hover">
                                    <thead>
                                    <tr class="text-center">
                                        <th style="width: 65px">Tanggal</th>
                                        <th>Uraian</th>
                                        <th style="width: 100px;">Pemasukan</th>
                                        <th style="width: 100px;">Pengeluaran</th>
                                        <th style="width: 100px">Saldo</th>
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
        $(function () {

            //Initialize Datatables Elements
            $('#datatable-bs').DataTable({
                ajax: "{!! route('admin.keuangan.kas.index') !!}",
                autoWidth: false,
                responsive: true,
                processing: true,
                serverSide: true,
                lengthChange: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json'
                },
                columns: [
                    {data: 'tanggal', name: 'tanggal'},
                    {data: 'uraian', name: 'uraian'},
                    {data: 'pemasukan', name: 'pemasukan'},
                    {data: 'pengeluaran', name: 'pengeluaran'},
                    {data: 'saldo', name: 'saldo'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>
@endpush
