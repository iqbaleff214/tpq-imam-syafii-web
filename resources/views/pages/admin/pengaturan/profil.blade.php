@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Profil</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
                            <li class="breadcrumb-item active">Profil</li>
                            <!-- <li class="breadcrumb-item active">Administrator</li> -->
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <form action="{{ route('admin.profil.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12 col-md-8">
                        <!-- Default box -->
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Biodata
                                </h3>
                            </div>
                            <div class="card-body mb-3">

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nama</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Nama" value="{{ old('nama', Auth::user()->administrator->nama) }}" autofocus>
                                        <span class="error invalid-feedback">{{ $errors->first('nama') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Jabatan</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control @error('jabatan') is-invalid @enderror" placeholder="Jabatan" value="{{ old('jabatan', Auth::user()->administrator->jabatan) }}" readonly>
                                        <span class="error invalid-feedback">{{ $errors->first('jabatan') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Tempat Lahir</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" placeholder="Tempat Lahir" value="{{ old('tempat_lahir', Auth::user()->administrator->tempat_lahir) }}">
                                        <span class="error invalid-feedback">{{ $errors->first('tempat_lahir') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{ old('tanggal_lahir', date('Y-m-d', strtotime(Auth::user()->administrator->tanggal_lahir))) }}">
                                        <span class="error invalid-feedback">{{ $errors->first('tanggal_lahir') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-8">
                                        <select name="jenis_kelamin" id="" class="custom-select select2">
                                            <option {{ Auth::user()->administrator->jenis_kelamin=='L' ? 'selected' : '' }} value="L">Laki-laki</option>
                                            <option {{ Auth::user()->administrator->jenis_kelamin=='P' ? 'selected' : '' }} value="P">Perempuan</option>
                                        </select>
                                        <span class="error invalid-feedback">{{ $errors->first('jenis_kelamin') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nomor Telepon</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control @error('no_telp') is-invalid @enderror" placeholder="Nomor Telepon" name="no_telp" value="{{ old('no_telp', Auth::user()->administrator->no_telp) }}">
                                        <span class="error invalid-feedback">{{ $errors->first('no_telp') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Alamat</label>
                                    <div class="col-sm-8">
                                        <textarea name="alamat" id="" cols="30" rows="3" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat">{{ old('alamat', Auth::user()->administrator->alamat) }}</textarea>
                                        <span class="error invalid-feedback">{{ $errors->first('alamat') }}</span>
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
                    <div class="col-12 col-md-4">
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Foto
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('foto') is-invalid @enderror" name="foto" id="image">
                                            <label class="custom-file-label" for="image">Pilih Foto (Opsional)</label>
                                        </div>
                                    </div>
                                    @error('foto')
                                    <span class="text-danger text-sm">{{ $errors->first('foto') }}</span>
                                    @enderror
                                    <div class="form-text font-weight-lighter text-sm">
                                        Maksimal: 2048KB
                                    </div>
                                </div>
                                <img src="{{ Auth::user()->administrator->foto ? asset("storage/".Auth::user()->administrator->foto) : asset(Auth::user()->administrator->jenis_kelamin=="L" ? 'images/ikhwan.svg' : 'images/akhwat.svg') }}" class="img-thumbnail img-preview" style="width: 100%;" alt="Administrator">
                                @if(Auth::user()->administrator->foto)
                                    <button type="submit" form="unlink" class="btn btn-outline-danger btn-sm position-absolute mt-3 ml-n5"><i class="fas fa-times"></i></button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <form action="{{ route('admin.profil.unlink') }}" id="unlink" method="post">
                @csrf
                @method('DELETE')
            </form>
        </section>
        <!-- /.content -->

    </div>
@endsection

@push('link')
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" integrity="sha512-kq3FES+RuuGoBW3a9R2ELYKRywUEQv0wvPTItv3DSGqjpbNtGWVdvT8qwdKkqvPzT93jp8tSF4+oN4IeTEIlQA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('script')
    <!--Select2-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(function() {
            $(document).on("click", "button[type=submit].position-absolute", function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Anda yakin ingin menghapus?',
                    text: "Tindakan tidak dapat dibatalkan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya, saya yakin!',
                    cancelButtonText: 'Batalkan',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#unlink').submit();
                    }
                });
                return false;
            });

            //Initialize Select2 Elements
            $('.select2').select2();

            $('#image').on('change', function() {
                previewImage();
            });
        });

        function previewImage() {
            const cover = document.querySelector('.custom-file-input');
            const coverLabel = document.querySelector('.custom-file-label');
            const imgPreview = document.querySelector('.img-preview');
            coverLabel.textContent = cover.files[0].name;
            const coverFile = new FileReader();
            coverFile.readAsDataURL(cover.files[0]);
            coverFile.onload = function (e) {
                imgPreview.src = e.target.result;
            }
        }
    </script>
@endpush
