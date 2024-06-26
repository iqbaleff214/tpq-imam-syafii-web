@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Opsi SPP</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">SPP</li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.spp.opsi.index') }}">Opsi</a></li>
                            <li class="breadcrumb-item active">Baru</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <form action="{{ route('admin.spp.opsi.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <!-- Default box -->
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{ route('admin.spp.opsi.index') }}" class="btn btn-outline-danger">
                                        Kembali
                                    </a>
                                </h3>
                            </div>
                            <div class="card-body mb-3">

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Opsi</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('opsi') is-invalid @enderror"
                                               name="opsi" placeholder="Opsi" value="{{ old('opsi') }}">
                                        <span class="error invalid-feedback">{{ $errors->first('opsi') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Biaya</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="text" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah') }}" id="jumlah" placeholder="0" name="jumlah">
                                            <div class="input-group-append">
                                                <span class="input-group-text"> per bulan</span>
                                            </div>
                                            <span class="error invalid-feedback">{{ $errors->first('jumlah') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Keterangan</label>
                                    <div class="col-sm-10">
                                        <textarea name="keterangan" id="keterangan" cols="30" rows="3" placeholder="Keterangan (Opsional)"
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

@push('script')
    {{-- MaskMoney --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

    <script>
        $(function() {

            $('input[name=jumlah]').mask("000.000.000.000", {reverse: true});
            $("form").submit(function() {
                $("input[name=jumlah]").unmask();
            });
        });
    </script>
@endpush
