@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Fasilitas</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.fasilitas.index') }}">Fasilitas</a>
                            </li>
                            <li class="breadcrumb-item active">Baru</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <form action="{{ route('admin.fasilitas.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <!-- Default box -->
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{ route('admin.fasilitas.index') }}" class="btn btn-outline-danger">
                                        Kembali
                                    </a>
                                </h3>
                            </div>
                            <div class="card-body mb-3">

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Fasilitas</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('fasilitas') is-invalid @enderror"
                                               name="fasilitas" placeholder="Fasilitas" value="{{ old('fasilitas') }}">
                                        <span class="error invalid-feedback">{{ $errors->first('fasilitas') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Ikon</label>
                                    <div class="col-sm-10 row">
                                        <div class="col-10">
                                            <select name="icon" id="icon-select" class="custom-select select2 @error('icon') is-invalid @enderror">
                                                @foreach($icon as $item)
                                                    <option value="{{ $item->icon }}">{{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                            <span class="error invalid-feedback">{{ $errors->first('icon') }}</span>
                                        </div>
                                        <div class="col-2 text-center">
                                            <h2>
                                                <i class="fas fa-user" id="icon-show"></i>
                                            </h2>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Keterangan</label>
                                    <div class="col-sm-10">
                                        <textarea name="keterangan" id="keterangan" cols="30" rows="3"
                                                  placeholder="Keterangan (Opsional)"
                                                  class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                                    <span class="error invalid-feedback">{{ $errors->first('keterangan') }}</span>
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

            $(document).on('change', '#icon-select', function () {
                $('#icon-show').removeClass();
                $('#icon-show').addClass($(this).val());
            });
        });
    </script>
@endpush
