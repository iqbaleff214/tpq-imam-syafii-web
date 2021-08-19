@extends('layouts.kepala')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $title }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                            <!-- <li class="breadcrumb-item active">Administrator</li> -->
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <form action="{{ route('kepala.lembaga.update', $profil) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12 col-md-6">
                        <!-- Default box -->
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Profil Lembaga
                                </h3>
                            </div>
                            <div class="card-body mb-3">

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Lembaga</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                               name="nama" placeholder="Lembaga" value="{{ old('nama', $profil->nama) }}">
                                        <span class="error invalid-feedback">{{ $errors->first('nama') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Deskripsi</label>
                                    <div class="col-sm-8">
                                        <textarea name="deskripsi" id="" cols="30" rows="7"
                                                  class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $profil->deskripsi) }}</textarea>
                                        <span class="error invalid-feedback">{{ $errors->first('deskripsi') }}</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Visi</label>
                                    <div class="col-sm-8">
                                        <textarea name="visi" id="" cols="30" rows="5"
                                                  class="form-control @error('visi') is-invalid @enderror">{{ old('visi', $profil->visi) }}</textarea>
                                        <span class="error invalid-feedback">{{ $errors->first('visi') }}</span>
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
                    <div class="col-12 col-md-6">

                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">Kontak</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Email</label>
                                    <div class="col-sm-8">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               placeholder="Surel" name="email"
                                               value="{{ old('email', $profil->email) }}">
                                        <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nomor Telepon</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control @error('no_telp') is-invalid @enderror"
                                               placeholder="Nomor Telepon" name="no_telp"
                                               value="{{ old('no_telp', $profil->no_telp) }}">
                                        <span class="error invalid-feedback">{{ $errors->first('no_telp') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Alamat</label>
                                    <div class="col-sm-8">
                                        <textarea name="alamat" id="" cols="30" rows="3"
                                                  class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $profil->alamat) }}</textarea>
                                        <span class="error invalid-feedback">{{ $errors->first('alamat') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">Sosial Media</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Facebook</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control @error('facebook') is-invalid @enderror"
                                               placeholder="Facebook (Opsional)" name="facebook"
                                               value="{{ old('facebook', $profil->facebook) }}">
                                        <span class="error invalid-feedback">{{ $errors->first('facebook') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Twitter</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control @error('twitter') is-invalid @enderror"
                                               placeholder="Twitter (Opsional)" name="twitter"
                                               value="{{ old('twitter', $profil->twitter) }}">
                                        <span class="error invalid-feedback">{{ $errors->first('twitter') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">WhatsApp</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control @error('whatsapp') is-invalid @enderror"
                                               placeholder="WhatsApp (Opsional)" name="whatsapp"
                                               value="{{ old('whatsapp', $profil->whatsapp) }}">
                                        <span class="error invalid-feedback">{{ $errors->first('whatsapp') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Instagram</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control @error('instagram') is-invalid @enderror"
                                               placeholder="Instagram (Opsional)" name="instagram"
                                               value="{{ old('instagram', $profil->instagram) }}">
                                        <span class="error invalid-feedback">{{ $errors->first('instagram') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Logo
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('foto') is-invalid @enderror" name="foto" id="image">
                                            <label class="custom-file-label" for="image">Pilih Logo (Opsional)</label>
                                        </div>
                                    </div>
                                    @error('foto')
                                    <span class="text-danger text-sm">{{ $errors->first('foto') }}</span>
                                    @enderror
                                    <div class="form-text font-weight-lighter text-sm">
                                        Maksimal: 2048KB
                                    </div>
                                </div>
                                <img src="{{ $profil->foto ? asset("storage/".$profil->foto) : asset('logo.png') }}"
                                     class="img-thumbnail img-preview" style="width: 100%;" alt="Administrator">
                                @if($profil->foto)
                                    <button type="submit" form="unlink"
                                            class="btn btn-outline-danger btn-sm position-absolute mt-3 ml-n5"><i
                                            class="fas fa-times"></i></button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <form action="{{ route('kepala.lembaga.unlink') }}" id="unlink" method="post">
                @csrf
                @method('DELETE')
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

            $('#image').on('change', function () {
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
