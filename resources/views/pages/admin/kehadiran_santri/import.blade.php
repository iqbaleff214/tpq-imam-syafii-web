@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kehadiran Santri</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Kehadiran</li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.kehadiran.santri.index') }}">Santri</a></li>
                            <li class="breadcrumb-item active">Import</li>
                            <!-- <li class="breadcrumb-item active">Administrator</li> -->
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <form action="{{ route('admin.kehadiran.santri.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-6">
                        <!-- Default box -->
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{ route('admin.kehadiran.santri.index') }}" class="btn btn-outline-danger">
                                        Kembali
                                    </a>
                                </h3>
                            </div>
                            <div class="card-body mb-3">
                                <div class="form-group">
                                    <label class="form-label">Nama</label>
                                    <select name="santri" class="custom-select select2 @error('santri') is-invalid @enderror">
                                        @foreach($santri as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_lengkap }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error invalid-feedback">{{ $errors->first('santri') }}</span>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file"
                                                   class="custom-file-input @error('berkas') is-invalid @enderror"
                                                   name="berkas" id="berkas">
                                            <label class="custom-file-label" for="berkas">Unggah Berkas</label>
                                        </div>
                                    </div>
                                    @error('berkas')
                                    <span class="text-danger text-sm">{{ $errors->first('berkas') }}</span>
                                    @enderror
                                    <div class="form-text font-weight-lighter text-sm">Berkas: Excel, Spreadsheet</div>
                                    <div class="form-text font-weight-lighter text-sm">Maksimal: 2048KB</div>
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
                    <div class="col-12 col-md-6">
                        <div class="card card-maroon card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Instruksi</h3>
                            </div>
                            <div class="card-body">
                                <ul>
                                    <li>Silakan unduh contoh berkas di bawah sebagai acuan.</li>
                                    <li>Isi berkas tersebut sesuai dengan contoh format yang diberikan.</li>
                                    <li>Jika sudah diisi silakan unggah kembali berkas yang sudah diisi.</li>
                                    <li>Silakan pilih santri yang ingin diimport data kehadirannya.</li>
                                    <li>Pastikan tidak ada duplikasi data.</li>
                                </ul>
                                <a href="{{ asset('docs/template-kehadiran-santri.xlsx') }}" download class="btn bg-maroon btn-block mt-4">Download Template</a>
                            </div>
                        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script !src="">
        $(function () {
            bsCustomFileInput.init();
            //Initialize Select2 Elements
            $('.select2').select2();

        });
    </script>
@endpush
