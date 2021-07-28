@extends('layouts.kepala')

@section('body')  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Kalender Pendidikan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item"><a href="#">Kalender Pendidikan</a></li>
                        <li class="breadcrumb-item active">Baru</li> -->
                        <li class="breadcrumb-item active">Kalender Pendidikan</li>
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
                <div class="col-md-3">
                    <div class="sticky-top mb-3">
                        <form action="{{ route('kepala.kalender.store') }}" method="POST">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Kegiatan Baru</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="tes">Kegiatan</label>
                                        <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" placeholder="Kegiatan">
                                    </div>
                                    <div class="form-group">
                                        <label for="tes">Mulai</label>
                                        <input type="date" class="form-control @error('mulai') is-invalid @enderror" id="mulai" name="mulai">
                                    </div>

                                    <div class="form-group mx-4">
                                        <div class="icheck-primary">
                                            <input class="form-check-input" type="checkbox" id="satu_hari" checked>
                                            <label for="satu_hari">
                                                Satu hari
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="tes">Selesai</label>
                                        <input type="date" class="form-control" id="selesai" name="selesai" disabled>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button class="btn bg-maroon" type="submit">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card card-primary">
                        <div class="card-body p-0">
                            <!-- THE CALENDAR -->
                            <div id="calendar"></div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable-bs" class="table table-bordered table-hover">
                                <thead>
                                <tr class="text-center">
                                    <th style="width: 25px">No</th>
                                    <th>Kegiatan</th>
                                    <th style="width: 100px;">Mulai</th>
                                    <th style="width: 100px;">Selesai</th>
                                    <th style="width: 75px">Ditambahkan</th>
                                    <th style="width: 75px;">Aksi</th>
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
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection

@push('link')
    <!-- Fullcalendar -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.min.css" integrity="sha256-u40zn9KeZYpMjgYaxWJccb4HnP0i8XI17xkXrEklevE=" crossorigin="anonymous">
    <!-- Datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css">
@endpush

@push('script')
    <!-- Fullcalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.min.js" integrity="sha256-AOrsg7pOO9zNtKymdz4LsI+KyLEHhTccJrZVU4UFwIU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/locales-all.min.js" integrity="sha256-6TW9hevn9VV+Dk6OtclSzIjH05B6f2WWhJ/PQgy7m7s=" crossorigin="anonymous"></script>

    <!--Datatable-->
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>

    <script>

        $(document).ready(function() {

            //Initialize Datatables Elements
            $('#datatable-bs').DataTable({
                ajax: "{!! route('kepala.kalender.index') !!}",
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
                    { data: 'keterangan', name: 'keterangan' },
                    { data: 'mulai', name: 'mulai' },
                    { data: 'selesai', name: 'selesai' },
                    { data: 'created_at', name: 'created_at', searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });

            $('#satu_hari').on('click', function() {
                $('#selesai').prop('disabled', (i, v) => !v);
            });

            // Calendar
            const date = new Date()
            const d    = date.getDate(),
                m    = date.getMonth(),
                y    = date.getFullYear()
            const Calendar = FullCalendar.Calendar;
            const containerEl = document.getElementById('external-events');
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'id',
                headerToolbar: {
                    left  : 'prev,next today',
                    center: 'title',
                    right : 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                themeSystem: 'bootstrap',
                eventDidMount: function(info) {
                    console.log(info.event.extendedProps.title)
                    $(info.el).tooltip({
                        // title: info.event.extendedProps.description,
                        title: `Heyo`,
                        placement: "top",
                        trigger: "hover",
                        container: "body",
                        html: true
                    });
                },
                events: {!! $kalender !!},
            });
            calendar.render();
        });

    </script>
@endpush
