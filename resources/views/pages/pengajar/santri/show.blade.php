@extends('layouts.pengajar')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"> {{ $title }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">

                        <!-- Profile Image -->
                        <div class="card card-maroon card-outline">
                            <div class="card-body box-profile">
                                <span
                                    class="badge {{ $santri->status == 'Aktif' ? 'badge-success' : 'badge-danger' }}">{{ $santri->status }}</span>
                                <span
                                    class="badge bg-maroon float-right mt-1">{{ \Carbon\Carbon::parse($santri->tanggal_lahir)->age . ' tahun' }}</span>
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
                                    <p class="text-muted">{{ \Carbon\Carbon::parse($santri->tanggal_lahir)->age }}
                                        tahun</p>
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
                                    <a href="{{ route('pengajar.santri.index') }}" class="btn btn-outline-danger">
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
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group">
                                    @if($bulan->count())
                                        <select class="form-control select2" id="select-bulan"
                                                style="width: 100%;">
                                            @foreach($bulan as $item)
                                                <option
                                                    value="{{ $item->bulan }}" {{ $loop->last ? 'selected' : '' }}>{{ $item->bulan }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane" id="pembelajaran">

                                        @if(!$santri->pembelajaran()->whereDate('created_at', \Carbon\Carbon::today())->first() or $ngaji)

                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#exampleModal">
                                                Launch demo modal
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal" tabindex="-1"
                                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content" style="z-index: 510!important;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Modal
                                                                title</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ...
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close
                                                            </button>
                                                            <button type="button" class="btn btn-primary">Save changes
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <form action="{{ route('pengajar.pembelajaran.store') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-12 col-md-3">
                                                        <div class="form-group">
                                                            <label for="bacaan">Bacaan</label>
                                                            <select class="form-control select2" id="bacaan"
                                                                    name="bacaan" style="width: 100%">
                                                                @foreach($bacaan as $item)
                                                                    <option
                                                                        value="{{ $item->materi }}">{{ $item->jenis == 'QURAN' ? 'Q.S.' : 'Iqro' }} {{ $item->materi }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <div class="form-group">
                                                            <label for="mulai">Mulai</label>
                                                            <input type="number" min="1" class="form-control" id="mulai"
                                                                   name="mulai" placeholder="Mulai Ayat/Halaman">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <div class="form-group">
                                                            <label for="selesai">Selesai</label>
                                                            <input type="number" min="1" class="form-control"
                                                                   id="selesai" name="selesai"
                                                                   placeholder="Sampai Ayat/Halaman">
                                                            <small id="selesai"
                                                                   class="form-text text-muted text-center">Kosongkan
                                                                jika 1 ayat/halaman.</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <div class="form-group">
                                                            <label for="keterangan">Keterangan</label>
                                                            <select name="keterangan" id="keterangan"
                                                                    class="form-control select2" style="width: 100%">
                                                                <option value="Lanjut">Lanjut</option>
                                                                <option value="Ulang">Ulang</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-12 col-md-3 offset-9">
                                                        <button class="btn bg-maroon btn-block">Simpan</button>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif

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
                                    <div class="tab-pane active" id="kehadiran">

                                        @if(!$santri->kehadiran()->whereDate('created_at', \Carbon\Carbon::today())->first() and $ngaji)
                                            <div class="row mb-3">
                                                <div class="col">
                                                    @php($ket = ['Hadir' => 'bg-maroon', 'Izin' => 'btn-outline-danger', 'Sakit' => 'btn-outline-danger', 'Absen' => 'btn-outline-danger'])
                                                    @foreach($ket as $val => $class)
                                                        <form class="d-inline" method="POST"
                                                              action="{{ route('pengajar.kehadiran.santri.store') }}">
                                                            @csrf
                                                            <input type="hidden" name="nilai_adab">
                                                            <input type="hidden" name="santri_id"
                                                                   value="{{ $santri->id }}">
                                                            <input type="hidden" name="keterangan" value={{ $val }}>
                                                            <button type="submit"
                                                                    class="btn {{ $class }} btn-sm px-2 {{ $val == 'Hadir' ? 'confirm-attendance' : '' }}">
                                                                {{ $val }}
                                                            </button>
                                                        </form>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <table class="table table-hover table-bordered table-striped"
                                               id="datatable-kehadiran">
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

                                        <div class="text-center">
                                            @if($bulan->count())
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <canvas id="doughnutChart" class="mt-5 mx-auto"></canvas>
                                                        <p class="text-sm text-center mt-3 text-muted"
                                                           id="doughnutChartLabel">Grafik Kehadiran Bulan Ini</p>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <canvas id="barChart" height="300px"
                                                                class="mt-5 mx-auto"></canvas>
                                                        <p class="text-sm text-center mt-3 text-muted"
                                                           id="barChartLabel">Grafik Kehadiran Bulan Ini</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

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
        </div>
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
    <!--ChartJS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js"
            integrity="sha512-asxKqQghC1oBShyhiBwA+YgotaSYKxGP1rcSYTDrB0U6DxwlJjU59B67U8+5/++uFjcuVM8Hh5cokLjZlhm3Vg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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

            var doughnutCanvas = document.getElementById('doughnutChart');
            var doughnutChart = new Chart(doughnutCanvas, {
                type: 'doughnut',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Kehadiran Santri',
                        data: [],
                        backgroundColor: [],
                    }]
                }
            });

            var barCanvas = document.getElementById('barChart');
            var barChart = new Chart(barCanvas, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Kehadiran Santri',
                        data: [],
                        backgroundColor: [],
                    }]
                },
                options: {
                    scales: {
                        xAxes: [{
                            ticks: {
                                stepSize: 1,
                            }
                        }]
                    }
                }
            });

            generateChart(bulan, doughnutChart);
            generateChart(bulan, barChart);
            $('#doughnutChartLabel').text(`Grafik kehadiran bulan ${bulan}`);

            var table_kehadiran = $('#datatable-kehadiran').DataTable({
                ajax: {
                    url: "{!! route('pengajar.kehadiran.santri.show', $santri->id) !!}",
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
                    url: "{!! route('pengajar.pembelajaran.show', $santri->id) !!}",
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
                $('#doughnutChartLabel').text(`Grafik kehadiran bulan ${bulan}`);
                generateChart(bulan, doughnutChart);
                table_kehadiran.draw();
            });

            $(document).on("click", "button[type=submit].confirm-attendance", async function (e) {
                e.preventDefault();
                const {value: nilai} = await Swal.fire({
                    title: 'Nilai Adab',
                    input: 'text',
                    inputLabel: 'Silakan masukkan nilai adab santri!',
                    inputPlaceholder: 'Nilai adab santri'
                })
                if (nilai) {
                    $(this).closest('form.d-inline').find('input[name=nilai_adab]').val(nilai);
                    $(this).closest('form.d-inline').submit();
                }
                return false;
            });
        });

        function generateChart(bulan, chart) {
            $.ajax({
                url: "{!! route('pengajar.kehadiran.santri.show', $santri->id) !!}",
                method: "GET",
                data: {
                    chart: chart.config.type ?? true,
                    bulan: bulan,
                },
                success: function (res) {
                    let chartData = [];
                    let chartLabel = [];
                    let chartColor = [];
                    res.forEach(e => {
                        chartLabel.push(e.label);
                        chartData.push(e.data);
                        chartColor.push(`rgb(${Math.floor(Math.random() * 256)},${Math.floor(Math.random() * 256)},${Math.floor(Math.random() * 256)})`);
                    });
                    chart.data.labels = chartLabel;
                    chart.data.datasets[0].data = chartData;
                    chart.data.datasets[0].backgroundColor = chartColor;

                    chart.update();
                }
            });
        }
    </script>
@endpush