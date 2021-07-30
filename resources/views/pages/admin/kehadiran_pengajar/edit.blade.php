@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kehadiran Pengajar</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Kehadiran</li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.kehadiran.pengajar.index') }}">Pengajar</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <form action="{{ route('admin.kehadiran.pengajar.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <!-- Default box -->
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{ route('admin.kehadiran.pengajar.index') }}"
                                       class="btn btn-outline-danger">
                                        Kembali
                                    </a>
                                </h3>
                            </div>
                            <div class="card-body mb-3">

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Tanggal</label>
                                    <div class="col-sm-10">
                                        <input type="date"
                                               class="form-control @error('created_at') is-invalid @enderror"
                                               name="created_at"
                                               value="{{ old('created_at', $presensi->created_at->isoFormat('Y-MM-D')) }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <select name="pengajar_id" id="pengajar_id" class="form-control select2" disabled>
                                            @foreach($pengajar as $item)
                                                <option
                                                    value="{{ $item->id }}" {{ $item->id == $presensi->pengajar_id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                        <select class="custom-select select2" id="keterangan" name="keterangan">
                                            <?php $status = ['Hadir', 'Sakit', 'Izin'] ?>
                                            @foreach($status as $item)
                                                <option value="{{ $item }}" {{ $presensi->keterangan == $item ? 'selected' : '' }}>{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row form-waktu">
                                    <label class="col-sm-2 col-form-label">Waktu</label>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="time" name="datang" class="form-control" value="{{ old('datang', $presensi->datang) }}">
                                            </div>
                                            <div class="col-6">
                                                <input type="time" name="pulang" class="form-control" value="{{ old('pulang', $presensi->pulang) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button class="btn bg-maroon" type="submit">
                                    Simpan
                                </button>
                                <button class="btn btn-outline-danger float-right" type="reset">
                                    Reset
                                </button>
                            </div>
                            <!-- /.card-footer-->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </form>
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
@endpush

@push('script')
    <!--Select2-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();

            if ($('#keterangan').val() == 'Hadir') {
                $('.form-waktu').show();
            } else {
                $('.form-waktu').hide();
            }

            $(document).on('change', '#keterangan', function () {
                let keterangan = $(this).val();
                if (keterangan == 'Hadir') {
                    $('.form-waktu').show();
                } else {
                    $('.form-waktu').hide();
                }
            });
        });
    </script>
@endpush

