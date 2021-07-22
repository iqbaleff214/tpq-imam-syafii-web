@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Santri</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.santri.index') }}">Santri</a></li>
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
            <form action="{{ route('admin.santri.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-8">
                        <!-- Default box -->
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{ route('admin.santri.index') }}" class="btn btn-outline-danger">
                                        Kembali
                                    </a>
                                </h3>
                            </div>
                            <div class="card-body mb-3">

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">NIS</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control @error('nis') is-invalid @enderror"
                                               name="nis" placeholder="NIS (Opsional)" value="{{ old('nis') }}">
                                        <div class="form-text font-weight-lighter text-sm">Dibuat otomatis jika
                                            kosong.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nama Lengkap</label>
                                    <div class="col-sm-8">
                                        <input type="text"
                                               class="form-control @error('nama_lengkap') is-invalid @enderror"
                                               name="nama_lengkap" placeholder="Nama Lengkap"
                                               value="{{ old('nama_lengkap') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nama Panggilan</label>
                                    <div class="col-sm-8">
                                        <input type="text"
                                               class="form-control @error('nama_panggilan') is-invalid @enderror"
                                               name="nama_panggilan" placeholder="Nama Panggilan (Opsional)"
                                               value="{{ old('nama_panggilan') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Tempat Lahir</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="tempat_lahir"
                                               class="form-control @error('tempat_lahir') is-invalid @enderror"
                                               placeholder="Tempat Lahir" value="{{ old('tempat_lahir') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-8">
                                        <input type="date"
                                               class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                               name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-8">
                                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control select2">
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Saudara</label>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <input type="number" name="anak_ke"
                                                       class="form-control @error('anak_ke') is-invalid @enderror"
                                                       placeholder="Anak ke-... (Opsional)"
                                                       value="{{ old('anak_ke') }}">
                                            </div>
                                            <div class="col-12 col-md-6 my-2 my-md-0">
                                                <input type="number" name="jumlah_saudara"
                                                       class="form-control @error('jumlah_saudara') is-invalid @enderror"
                                                       placeholder="Dari ... bersaudara (Opsional)"
                                                       value="{{ old('jumlah_saudara') }}">
                                            </div>
                                        </div>
                                        <div class="form-text font-weight-lighter text-sm">Boleh dikosongkan jika anak
                                            tunggal.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Alamat</label>
                                    <div class="col-sm-8">
                                        <textarea name="alamat" cols="30" rows="3" placeholder="Alamat"
                                                  class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Status</label>
                                    <div class="col-sm-8">
                                        <select name="status" class="form-control select2">
                                            @foreach($status as $key => $val)
                                                <option value="{{ $key }}">{{ $val }}</option>
                                            @endforeach
                                        </select>
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
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Wali Santri
                                </h3>
                                <button class="btn btn-outline-danger float-right" type="button" id="add-wali">
                                    Tambah
                                </button>
                            </div>
                            <div class="card-body" id="container-wali">
                                <div class="form-group row">
                                    <div class="col-12 col-sm-4 col-md-4">
                                        <input type="text" class="form-control"
                                               placeholder="Nama Wali" name="nama_wali[]"
                                               required>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 mt-sm-0 mt-2">
                                        <select name="hubungan[]" class="form-control select2">
                                            <option disabled="disabled" selected="selected">Hubungan</option>
                                            @foreach($hubungan as $val)
                                                <option value="{{ $val }}">{{ $val }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 mt-sm-0 mt-2">
                                        <input type="text" class="form-control"
                                               placeholder="Nomor Telepon" name="no_telp[]"
                                               required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Akun
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Username</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                                               placeholder="Pengguna (Opsional)" name="username" autocomplete="off"
                                               value="{{ old('username') }}">
                                        <div class="form-text font-weight-lighter text-sm">Sama dengan NIS jika
                                            kosong.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Email</label>
                                    <div class="col-sm-8">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               placeholder="Surel" name="email" autocomplete="off"
                                               value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Kata Sandi</label>
                                    <div class="col-sm-8">
                                        <input type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               placeholder="Kata Sandi" name="password" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Konfirmasi</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" placeholder="Konfirmasi Kata Sandi"
                                               name="password_confirmation">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Administrasi
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">SPP</label>
                                    <div class="col-sm-8">
                                        <select name="spp_opsi_id" class="form-control select2">
                                            @foreach($opsi as $item)
                                                <option
                                                    value="{{ $item->id }}">{{ $item->opsi . ' (Rp'. number_format($item->jumlah, 2, ',', '.') . ')' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Kelas</label>
                                    <div class="col-sm-8">
                                        <select name="kelas_id" class="form-control select2">
                                            <option disabled="disabled" selected="selected">Kelas (Opsional)</option>
                                            @foreach($kelas as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                            <input type="file" class="custom-file-input" name="foto" id="image">
                                            <label class="custom-file-label" for="image">Pilih Foto (Opsional)</label>
                                        </div>
                                    </div>
                                </div>
                                <img src="<?= asset('images/ikhwan.jpg') ?>" class="img-thumbnail img-preview"
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

@endpush
<script>
    document.addEventListener('DOMContentLoaded', function () {
        //Initialize Select2 Elements
        $('.select2').select2();

        $('#image').on('change', function () {
            previewImage();
        });

        $('#jenis_kelamin').on('change', function () {
            const jk = $(this).val();
            const img = $('.img-preview');
            if (jk == 'L') {
                img.attr('src', "{{ asset('images/ikhwan.jpg') }}");
            } else {
                img.attr('src', "{{ asset('images/akhwat.jpg') }}");
            }
        });

        var wali = 1;

        $('#add-wali').click(function () {
            if (wali == 2) return false;
            wali++;
            const newRow = `
                            <div class="form-group row newRow">
                                <div class="col-12 col-sm-4 col-md-4">
                                    <input type="text" class="form-control" placeholder="Nama Wali" name="nama_wali[]"required>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 mt-sm-0 mt-2">
                                    <select name="hubungan[]" class="form-control select2">
                                        <option disabled="disabled" selected="selected">Hubungan</option>
                                        @foreach($hubungan as $val) <option value="{{ $val }}">{{ $val }}</option> @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 mt-sm-0 mt-2">
                                   <div class="input-group mb-3" id="newRow">
                                        <input type="text" class="form-control" placeholder="Nomor Telepon" name="no_telp[]">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-danger removeRow">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
            $('#container-wali').append(newRow);
            $('.select2').select2();
        });

        $(document).on('click', '.removeRow', function () {
            wali--;
            $(this).closest('.newRow').remove();
        });

    }, false);

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
