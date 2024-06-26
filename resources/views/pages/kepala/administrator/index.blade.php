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
              <!-- <li class="breadcrumb-item"><a href="#">Administrator</a></li> -->
              <!-- <li class="breadcrumb-item active">Dashboard v1</li> -->
              <li class="breadcrumb-item active">Administrator</li>
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
                    <a href="{{ route('kepala.admin.create') }}" class="btn bg-maroon">Administrator Baru</a>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="datatable-bs" class="table table-bordered table-hover">
                  <thead>
                    <tr class="text-center">
                        <th style="width: 25px">No</th>
                        <th>Nama</th>
                        <th style="width: 75px">JK</th>
                        <th style="width: 100px;">No Telepon</th>
                        <th style="width: 100px;">Jabatan</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <p class="text-sm">JK: Jenis Kelamin</p>
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
            ajax: "{!! route('kepala.admin.index') !!}",
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
                { data: 'jenis_kelamin', name: 'jenis_kelamin' },
                { data: 'no_telp', name: 'no_telp' },
                { data: 'jabatan', name: 'jabatan' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });
  </script>
@endpush
