@extends('layouts.admin')

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
                <div class="col">
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
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection

@push('link')
    <!-- Fullcalendar -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.min.css" integrity="sha256-u40zn9KeZYpMjgYaxWJccb4HnP0i8XI17xkXrEklevE=" crossorigin="anonymous">
@endpush

@push('script')
    <!-- Fullcalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.min.js" integrity="sha256-AOrsg7pOO9zNtKymdz4LsI+KyLEHhTccJrZVU4UFwIU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/locales-all.min.js" integrity="sha256-6TW9hevn9VV+Dk6OtclSzIjH05B6f2WWhJ/PQgy7m7s=" crossorigin="anonymous"></script>

    <script>

        $(document).ready(function() {

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
                        title: `Jadwal`,
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
