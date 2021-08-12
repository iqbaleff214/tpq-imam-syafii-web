@extends('layouts.pengajar')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kehadiran Pengajar</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container">
                <form action="{{ route('pengajar.kehadiran.update', $presensi) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12">
                            <!-- Default box -->
                            <div class="card card-solid">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <a href="{{ route('pengajar.kehadiran.index') }}"
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
                                                   disabled
                                                   class="form-control @error('created_at') is-invalid @enderror"
                                                   value="{{ old('created_at', $presensi->created_at->isoFormat('Y-MM-DD')) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Nama</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" disabled value="{{ Auth::user()->pengajar->nama }}">
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
            </div>
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

