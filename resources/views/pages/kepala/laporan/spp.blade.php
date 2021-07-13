@extends('layouts.kepala')

@section('body')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">SPP Santri</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="#">SPP Santri</a></li> -->
              <li class="breadcrumb-item active">Keuangan</li>
              <li class="breadcrumb-item active">SPP Santri</li>
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
              <div class="card-body">
                <table id="datatable-bs" class="table table-bordered table-hover">
                  <thead>
                    <tr class="text-center">
                        <th style="width: 25px">No</th>
                        <th style="width: 50px">Tanggal</th>
                        <th style="width: 100px">Santri</th>
                        <th style="width: 50px">Bulan</th>
                        <th style="width: 100px;">Jumlah</th>
                        <th style="width: 100px;">Status</th>
                        <th>Keterangan</th>
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
            ajax: "{!! route('kepala.keuangan.spp') !!}",
            autoWidth: false,
            responsive: true,
            processing: true,
            serverSide: true,
            lengthChange: false,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'tanggal', name: 'tanggal' },
                { data: 'jumlah', name: 'jumlah' },
                { data: 'pengajar', name: 'pengajar' },
                { data: 'keterangan', name: 'keterangan' },
            ]
        });
    });
  </script>
@endpush