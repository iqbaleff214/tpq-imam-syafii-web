@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kas</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <!-- <li class="breadcrumb-item"><a href="#">Kas</a></li> -->
                            <li class="breadcrumb-item active">Keuangan</li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.keuangan.kas.index') }}">Kas</a></li>
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
            <form action="{{ route('admin.keuangan.kas.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-6">
                        <!-- Default box -->
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{ route('admin.keuangan.kas.index') }}" class="btn btn-outline-danger">
                                        Kembali
                                    </a>
                                </h3>
                            </div>
                            <div class="card-body mb-3">


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
                                </ul>
                                <a href="{{ asset('docs/template-kas.xlsx') }}" download class="btn bg-maroon btn-block mt-4">Download Template</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
        <!-- /.content -->

    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script !src="">
        $(function () {
            bsCustomFileInput.init();
        });
    </script>
@endpush
