@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Pengumuman</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.pengumuman.index') }}">Pengumuman</a>
                            </li>
                            <li class="breadcrumb-item active">Baru</li>
                            <!-- <li class="breadcrumb-item active">Administrator</li> -->
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <form action="{{ route('admin.pengumuman.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-8">
                        <!-- Default box -->
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-outline-danger">
                                        Kembali
                                    </a>
                                </h3>
                            </div>
                            <div class="card-body mb-3">

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Judul</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                               name="judul" placeholder="Judul" value="{{ old('judul') }}">
                                        <span class="error invalid-feedback">{{ $errors->first('judul') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Konten</label>
                                    <div class="col-sm-10">
                                        <textarea name="konten" id="konten" cols="30" rows="30"
                                                  class="form-control @error('konten') is-invalid @enderror">{{ old('konten') }}</textarea>
                                        <span class="error invalid-feedback">{{ $errors->first('konten') }}</span>
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
                    <div class="col-12 col-md-4">
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Gambar
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('foto') is-invalid @enderror" name="foto" id="image">
                                            <label class="custom-file-label" for="image">Pilih Gambar (Opsional)</label>
                                        </div>
                                    </div>
                                    @error('foto')
                                    <span class="text-danger text-sm">{{ $errors->first('foto') }}</span>
                                    @enderror
                                    <div class="form-text font-weight-lighter text-sm">
                                        Maksimal: 2048KB
                                    </div>
                                </div>
                                <img src="<?= asset('images/info.jpg') ?>" class="img-thumbnail img-preview"
                                     style="width: 100%;" alt="Administrator">
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
    <script src="https://cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js"></script>
    <script>
        $(function () {
            ClassicEditor
                .create(document.querySelector('#konten'), {
                    toolbar: [ 'bold', 'italic', 'link', 'undo', 'redo']
                })
                .catch(error => {
                    console.error(error);
                });

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
