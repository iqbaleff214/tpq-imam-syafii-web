@extends('layouts.admin')

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
                            <li class="breadcrumb-item"><a href="{{ route('admin.kelas.index') }}">Kelas</a></li>
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
                <div class="col-12 col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-maroon card-outline">
                        <div class="card-body box-profile">
                                <span
                                    class="badge {{ $kelas->pengajar->status == 'Aktif' ? 'badge-success' : 'badge-danger' }}">{{ $kelas->pengajar->status }}</span>
                            <div class="text-center image">
                                <div class="img-circle img-thumbnail img-fluid mx-auto mb-3"
                                     style="width: 150px; height: 150px; background-repeat: no-repeat;background-size: 150px; background-position: center; background-image: url('{{ \App\Helpers\UserHelpers::getUserImage($kelas->pengajar->foto, $kelas->pengajar->jenis_kelamin) }}') ;"></div>
                            </div>

                            <h3 class="profile-username text-center">
                                <a href="{{ route('admin.pengajar.show', $kelas->pengajar) }}">
                                    {{ $kelas->pengajar->nama }}
                                </a>
                            </h3>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-maroon card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Kelas</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div>
                                <h6 class="font-weight-bold">Ditambahkan</h6>
                                <p class="text-muted">{{ $kelas->created_at->diffForHumans() }}</p>
                            </div>
                            <hr>
                            <div>
                                <h6 class="font-weight-bold">Nama Kelas</h6>
                                <p class="text-muted">{{ $kelas->nama_kelas }}</p>
                            </div>
                            <hr>
                            <div>
                                <h6 class="font-weight-bold">Jenis Kelas</h6>
                                <p class="text-muted">{{ $kelas->jenis_kelas }}</p>
                            </div>
                            <hr>
                            <div>
                                <h6 class="font-weight-bold">Tingkat</h6>
                                <p class="text-muted">{{ $kelas->kurikulum->tingkat }}</p>
                            </div>
                            <hr>
                            <div>
                                <h6 class="font-weight-bold">Santri</h6>
                                <p class="text-muted">{{ $kelas->santri->count() . ' santri' }}</p>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-12 col-md-9">
                    <div class="row">
                        <div class="col">
                            <!-- Default box -->
                            <div class="card card-solid">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <a href="{{ route('admin.kelas.index') }}" class="btn btn-outline-danger">
                                            Kembali
                                        </a>
                                    </h3>
                                </div>
                                <div class="card-body mb-3">
                                    <table id="datatable-bs" class="table table-bordered table-striped table-hover">
                                        <thead>
                                        <tr class="text-center">
                                            <th style="width: 20px">No</th>
                                            <th style="width: 50px">NIS</th>
                                            <th>Nama</th>
                                            <th>Panggilan</th>
                                            <th>Umur</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
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

                    @if($bulan->count())
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-outline card-maroon">
                                    <div class="card-header">
                                        <h3 class="card-title">Grafik Kehadiran</h3>
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
                                    </div>
                                    <div class="card-body">
                                        <canvas id="barChart" width="100%"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
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

    <script>
        $(function () {

            $('.select2').select2();

            let bulan = $('#select-bulan').val();
            var barChart = null;

            @if($bulan->count())
            var barCanvas = document.getElementById('barChart');
            barChart = new Chart(barCanvas, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [
                        {
                            label: 'Hadir',
                            data: [],
                            backgroundColor: 'green',
                        },
                        {
                            label: 'Izin',
                            data: [],
                            backgroundColor: 'blue',
                        },
                        {
                            label: 'Sakit',
                            data: [],
                            backgroundColor: 'yellow',
                        },
                        {
                            label: 'Absen',
                            data: [],
                            backgroundColor: 'red',
                        },
                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                stepSize: 1,
                                min: 0,
                                max: 100,
                            }
                        }]
                    }
                }
            });
            generateBar(barChart, bulan);
            @endif

            $(document).on('change', '#select-bulan', function () {
                bulan = $(this).val();
                generateBar(barChart, bulan);
            });

            //Initialize Datatables Elements
            $('#datatable-bs').DataTable({
                ajax: {
                    url: "{!! route('admin.santri.index') !!}",
                    data: function (d) {
                        d.kelas_id = "{{ $kelas->id }}"
                    }
                },
                autoWidth: false,
                responsive: true,
                processing: true,
                serverSide: true,
                lengthChange: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json'
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'nis', name: 'nis'},
                    {data: 'nama_lengkap', name: 'nama_lengkap'},
                    {data: 'nama_panggilan', name: 'nama_panggilan'},
                    {data: 'umur', name: 'umur'},
                ]
            });
        });

        function generateBar(chart, bulan) {
            $.ajax({
                url: "{!! route('admin.kelas.show', $kelas) !!}",
                method: "GET",
                data: {
                    chart: chart.config.type ?? true,
                    bulan: bulan,
                },
                success: function (res) {
                    let label = [];
                    let hadir = [];
                    let izin = [];
                    let sakit = [];
                    let absen = [];
                    res.label.forEach(e => {
                        label.push(e);
                    });
                    chart.data.labels = label;
                    res.data.forEach(e => {
                        hadir.push(e.hadir);
                        izin.push(e.izin);
                        sakit.push(e.sakit);
                        absen.push(e.absen);
                    });
                    chart.data.datasets[0].data = hadir;
                    chart.data.datasets[1].data = izin;
                    chart.data.datasets[2].data = sakit;
                    chart.data.datasets[3].data = absen;
                    chart.update();
                }
            });
        }
    </script>
@endpush

