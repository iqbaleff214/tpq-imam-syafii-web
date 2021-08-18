@extends('layouts.kepala')

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
                    <div class="col-12 col-md-12">
                        <div class="card card-maroon card-outline">
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-6">
                                            <h4>{{ \Carbon\Carbon::today()->isoFormat('dddd') }}</h4>
                                        </div>
                                        <div class="col-6">
                                            <h5 class="text-right">{{ \GeniusTS\HijriDate\Date::today()->format(' d F o') }}</h5>
                                            <h6 class="text-right text-muted">{{ \Carbon\Carbon::today()->isoFormat('D MMMM Y') }}</h6>
                                        </div>
                                    </div>
                                    <form action="{{ route('kepala.pendaftaran.update', $profil) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="is_pendaftaran" value="{{ !$profil->is_pendaftaran }}">
                                        <button type="submit"
                                                class="btn btn-daftar btn-outline-danger">{{ $profil->is_pendaftaran ? "Tutup Pendaftaran" : "Buka Pendaftaran" }}</button>
                                    </form>
                                    @if($profil->is_pendaftaran)
                                        <span class="badge float-right mt-3 badge-success">Pendaftaran Santri Baru Dibuka</span>
                                    @else
                                        <span class="badge float-right mt-3 badge-danger">Pendaftaran Santri Baru Ditutup</span>
                                    @endif
                                </div>
                            </div>
                        </div><!-- /.card -->
                    </div>
                </div>

                <div class="row">

                    <div class="col-12 col-md-6">
                        <div class="card card-maroon card-outline">
                            <div class="card-header">
                                <h3 class="card-title">{{ $profil->is_pendaftaran ? 'Calon Santri Baru' : 'Pendaftar Ditolak' }}</h3>
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

                    <div class="col-12 col-md-3">
                        <div class="card card-outline card-maroon">
                            <div class="card-header">
                                <h3 class="card-title">Rasio Pengajar</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="jkPengajarChart"></canvas>
                                <p class="text-center text-xs mt-3 text-muted">Rasio Berdasarkan Jenis Kelamin</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card card-outline card-maroon">
                            <div class="card-header">
                                <h3 class="card-title">Rasio Santri</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="jkSantriChart"></canvas>
                                <p class="text-center text-xs mt-3 text-muted">Rasio Berdasarkan Jenis Kelamin</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($count['saldo'])
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-maroon card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Grafik Keuangan</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="keuanganChart" height="30px" width="100%"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif


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
                                    <canvas id="kehadiranChart" height="25px" width="100%"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->

    </div>
@endsection

@push('link')
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
    <!--ChartJS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js"
            integrity="sha512-asxKqQghC1oBShyhiBwA+YgotaSYKxGP1rcSYTDrB0U6DxwlJjU59B67U8+5/++uFjcuVM8Hh5cokLjZlhm3Vg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!--Select2-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!--Datatable-->
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>
    <script !src="">
        $(function () {

            $('.select2').select2();

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

            $(document).on("click", "button[type=submit].btn-honor", async function (e) {
                e.preventDefault();
                const {value: nilai} = await Swal.fire({
                    title: 'Nominal Honor',
                    input: 'number',
                    inputLabel: 'Silakan masukkan nominal honor!',
                    inputPlaceholder: 'Rp0'
                })
                if (nilai) {
                    $(this).parent('form').find('input[name=jumlah]').val(nilai);
                    $(this).parent('form.d-inline-block').submit();
                }
                return false;
            });

            $('#datatable-santri-baru').DataTable({
                ajax: {
                    url: "{!! url()->current() !!}",
                    data: function (d) {
                        d.calon = {{ $profil->is_pendaftaran ? 1 : 2 }};
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

            var jkSantriChart = new Chart($('#jkSantriChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Laki-laki', 'Perempuan'],
                    datasets: [{
                        label: 'Rasio Santri',
                        data: [{{ intval($rasio['santri']->cowok) }}, {{ intval($rasio['santri']->cewek) }}],
                        backgroundColor: ['#2860ff', '#ff4787'],
                    }]
                }
            });
            var jkPengajarChart = new Chart($('#jkPengajarChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Laki-laki', 'Perempuan'],
                    datasets: [{
                        label: 'Rasio Santri',
                        data: [{{ intval($rasio['pengajar']->cowok) }}, {{ intval($rasio['pengajar']->cewek) }}],
                        backgroundColor: ['#2860ff', '#ff4787'],
                    }]
                }
            });

            @if($bulan)
            var barCanvas = document.getElementById('kehadiranChart');
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
            generateKehadiranChart(barChart, $('#select-bulan').val());
            @endif

            @if($count['saldo'])
            var keuanganCanvas = document.getElementById('keuanganChart');
            var keuanganChart = new Chart(keuanganCanvas, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [
                        {
                            label: 'Pemasukan',
                            data: [],
                            backgroundColor: '#52ad42',
                            borderColor: '#52ad42',
                        },
                        {
                            label: 'Pengeluaran',
                            data: [],
                            backgroundColor: '#ec2f2f',
                            borderColor: '#ec2f2f',
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
            generateKeuanganBar(keuanganChart);
            @endif

            $(document).on('change', '#select-bulan', function (e) {
                generateKehadiranChart(barChart, $(this).val());
            })
        });

        function generateKehadiranChart(chart, bulan = 0) {
            $.ajax({
                url: "{!! url()->current() !!}",
                method: "GET",
                data: {
                    kehadiran_semua: true,
                    bulan: bulan
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

                    res.data.forEach(e => {
                        hadir.push(e.hadir);
                        izin.push(e.izin);
                        sakit.push(e.sakit);
                        absen.push(e.absen);
                    });

                    chart.data.labels = label;
                    chart.data.datasets[0].data = hadir;
                    chart.data.datasets[1].data = izin;
                    chart.data.datasets[2].data = sakit;
                    chart.data.datasets[3].data = absen;

                    chart.update();
                }
            });
        }
        function generateKeuanganBar(chart) {
            $.ajax({
                url: "{!! route('kepala.keuangan.kas.index') !!}",
                method: "GET",
                data: {
                    chart: chart.config.type ?? true,
                },
                success: function (res) {
                    res.label.forEach(e => {
                        chart.data.labels.push(e.bulan);
                    });
                    res.data.forEach(e => {
                        chart.data.datasets[0].data.push(e.pemasukan);
                        chart.data.datasets[1].data.push(e.pengeluaran);
                    });
                    chart.update();
                }
            });
        }
    </script>
@endpush
