@extends('layouts.kepala')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Akun</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
                            <li class="breadcrumb-item active">Akun</li>
                            <!-- <li class="breadcrumb-item active">Administrator</li> -->
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <form action="{{ route('kepala.akun.update') }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <!-- Default box -->
                        <div class="card card-maroon card-outline">
                            <div class="card-body mb-3">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Username</label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                               class="form-control @error('username') is-invalid @enderror"
                                               placeholder="Nama Pengguna" name="username" autocomplete="off"
                                               value="{{ old('username', Auth::user()->username) }}">
                                        <span class="error invalid-feedback">{{ $errors->first('username') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email"
                                               name="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               placeholder="Surel" autocomplete="off"
                                               value="{{ old('email', Auth::user()->email) }}">
                                        <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Kata Sandi Lama</label>
                                    <div class="col-sm-10">
                                        <input type="password"
                                               class="form-control @error('password_lama') is-invalid @enderror"
                                               placeholder="Kata Sandi Lama" name="password_lama" autocomplete="off" autofocus>
                                        <span class="error invalid-feedback">{{ $errors->first('password_lama') }}</span>
                                        <div class="form-text font-weight-lighter text-sm">
                                            Konfirmasi kata sandi untuk mengubah.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Kata Sandi Baru</label>
                                    <div class="col-sm-10">
                                        <input type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               placeholder="Kata Sandi Baru (Opsional)" name="password" autocomplete="off">
                                        <span class="error invalid-feedback">{{ $errors->first('password') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Konfirmasi</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                               placeholder="Konfirmasi Kata Sandi Baru (Opsional)"
                                               name="password_confirmation">
                                        <span class="error invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
                                        <div class="form-text font-weight-lighter text-sm">
                                            Wajib diisi jika ingin mengganti kata sandi baru.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button class="btn bg-maroon" type="submit">
                                    Perbarui
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
