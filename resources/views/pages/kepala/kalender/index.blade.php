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
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Kegiatan Baru</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="tes">Kegiatan</label>
                                    <input type="text" class="form-control" id="tes" placeholder="Kegiatan">
                                </div>
                                <div class="form-group">
                                    <label for="tes">Mulai</label>
                                    <input type="date" class="form-control" id="tes">
                                </div>
                                <div class="form-group">
                                    <label for="tes">Selesai</label>
                                    <input type="date" class="form-control" id="tes">
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button class="btn bg-maroon">Simpan</button>
                            </div>
                        </div>
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
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection

@push('link')
    <!-- Fullcalendar -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.css">
@endpush

@push('script')
    <!-- Fullcalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.js"></script>

    <script>

        $(document).ready(function() {

        });

        // Calendar
        const date = new Date()
        const d    = date.getDate(),
            m    = date.getMonth(),
            y    = date.getFullYear()

        const Calendar = FullCalendar.Calendar;


        const containerEl = document.getElementById('external-events');
        const calendarEl = document.getElementById('calendar');

        const calendar = new Calendar(calendarEl, {
            headerToolbar: {
                left  : 'prev,next today',
                center: 'title',
                right : 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            themeSystem: 'bootstrap',
            events: [
                {
                    title          : 'Libur 10 hari terakhir bulan ramadan',
                    start          : new Date(y, m, 3),
                    end            : new Date(2021, 7, 13),
                    backgroundColor: '#f39c12', //yellow
                    borderColor    : '#f39c12' //yellow
                },
            ],
            selectable:true,
            selectHelper:true,
            select:function(start, end, allDay)
            {
                var title = prompt("Enter Event Title");
                if(title)
                {
                    console.log(title);
                }
            },
            eventClick: function(cal, js, view) {
                console.log(cal + ' ' + js + ' ' + view);
            }
        });

        calendar.render();
    </script>
@endpush
