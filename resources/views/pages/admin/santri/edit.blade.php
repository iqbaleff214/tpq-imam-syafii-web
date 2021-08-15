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
                            <li class="breadcrumb-item active">Edit</li>
                            <!-- <li class="breadcrumb-item active">Administrator</li> -->
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <form action="{{ route('admin.santri.update', $santri) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
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
                                        <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis', $santri->nis) }}" placeholder="NIS">
                                        <span class="error invalid-feedback">{{ $errors->first('nis') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nama Lengkap</label>
                                    <div class="col-sm-8">
                                        <input type="text"
                                               class="form-control @error('nama_lengkap') is-invalid @enderror"
                                               name="nama_lengkap" placeholder="Nama Lengkap"
                                               value="{{ old('nama_lengkap', $santri->nama_lengkap) }}">
                                        <span class="error invalid-feedback">{{ $errors->first('nama_lengkap') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nama Panggilan</label>
                                    <div class="col-sm-8">
                                        <input type="text"
                                               class="form-control @error('nama_panggilan') is-invalid @enderror"
                                               name="nama_panggilan" placeholder="Nama Panggilan (Opsional)"
                                               value="{{ old('nama_panggilan', $santri->nama_panggilan) }}">
                                        <span class="error invalid-feedback">{{ $errors->first('nama_panggilan') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Tempat Lahir</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" placeholder="Tempat Lahir" value="{{ old('tempat_lahir', $santri->tempat_lahir) }}">
                                        <span class="error invalid-feedback">{{ $errors->first('tempat_lahir') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{ old('tanggal_lahir', date('Y-m-d', strtotime($santri->tanggal_lahir))) }}">
                                        <span class="error invalid-feedback">{{ $errors->first('tanggal_lahir') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-8">
                                        <select name="jenis_kelamin" class="custom-select select2">
                                            <option {{ $santri->jenis_kelamin=='L' ? 'selected' : '' }} value="L">Laki-laki</option>
                                            <option {{ $santri->jenis_kelamin=='P' ? 'selected' : '' }} value="P">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Saudara</label>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <input type="number" name="anak_ke" min="1"
                                                       class="form-control @error('anak_ke') is-invalid @enderror"
                                                       placeholder="Anak ke-... (Opsional)"
                                                       value="{{ old('anak_ke', $santri->anak_ke) }}">
                                                <span class="error invalid-feedback">{{ $errors->first('anak_ke') }}</span>
                                            </div>
                                            <div class="col-12 col-md-6 my-2 my-md-0">
                                                <input type="number" name="jumlah_saudara" min="1"
                                                       class="form-control @error('jumlah_saudara') is-invalid @enderror"
                                                       placeholder="Dari ... bersaudara (Opsional)"
                                                       value="{{ old('jumlah_saudara', $santri->jumlah_saudara) }}">
                                                <span class="error invalid-feedback">{{ $errors->first('jumlah_saudara') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Alamat</label>
                                    <div class="col-sm-8">
                                        <textarea name="alamat" cols="30" rows="3" placeholder="Alamat"
                                                  class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $santri->alamat) }}</textarea>
                                        <span class="error invalid-feedback">{{ $errors->first('alamat') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Status</label>
                                    <div class="col-sm-8">
                                        <select name="status" class="custom-select select2">
                                            @foreach($status as $key => $val)
                                                <option value="{{ $key }}" {{ $santri->status == $key ? 'selected' : '' }}>{{ $val }}</option>
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
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-12 col-sm-4 col-md-4">
                                        <label>Nama Wali</label>
                                        <input type="hidden" name="id_wali" value="{{ $santri->wali[0]->id }}">
                                        <input type="text" class="form-control @error('nama_wali') is-invalid @enderror"
                                               placeholder="Nama Wali" name="nama_wali" value="{{ old('nama_wali', $santri->wali[0]->nama_wali) }}">
                                        <span class="error invalid-feedback">{{ $errors->first('nama_wali') }}</span>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 mt-sm-0 mt-2">
                                        <label>Hubungan</label>
                                        <select name="hubungan" class="custom-select select2 @error('hubungan') is-invalid @enderror">
                                            @foreach($hubungan as $val)
                                                <option value="{{ $val }}" {{ $santri->wali[0]->hubungan == $val ? 'selected' : '' }}>{{ $val }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error invalid-feedback">{{ $errors->first('hubungan') }}</span>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 mt-sm-0 mt-2">
                                        <label>Nomor Telepon</label>
                                        <input type="text" class="form-control @error('no_telp') is-invalid @enderror"
                                               placeholder="Nomor Telepon" name="no_telp" value="{{ old('no_telp', $santri->wali[0]->no_telp) }}">
                                        <span class="error invalid-feedback">{{ $errors->first('no_telp') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 col-sm-4 col-md-4">
                                        @if($santri->wali->count() > 1)
                                        <input type="hidden" name="id_wali_opsional" value="{{ $santri->wali[1]->id }}">
                                        @endif
                                        <input type="text" class="form-control @error('nama_wali_opsional') is-invalid @enderror"
                                               placeholder="Nama Wali (Opsional)" name="nama_wali_opsional" value="{{ old('nama_wali_opsional', $santri->wali[1]->nama_wali ?? null) }}">
                                        <span class="error invalid-feedback">{{ $errors->first('nama_wali_opsional') }}</span>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 mt-sm-0 mt-2">
                                        <select name="hubungan_opsional" class="custom-select select2 @error('hubungan_opsional') is-invalid @enderror">
                                            @if($santri->wali->count() == 1)
                                                <option disabled="disabled" selected="selected">Hubungan (Opsional)</option>
                                            @endif
                                            @foreach($hubungan as $val)
                                                <option value="{{ $val }}" {{ ($santri->wali[1]->hubungan ?? null) == $val ? 'selected' : '' }}>{{ $val }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error invalid-feedback">{{ $errors->first('hubungan_opsional') }}</span>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 mt-sm-0 mt-2">
                                        <input type="text" class="form-control @error('no_telp_opsional') is-invalid @enderror"
                                               placeholder="Nomor Telepon (Opsional)" name="no_telp_opsional" value="{{ old('no_telp_opsional', $santri->wali[1]->no_telp ?? null) }}">
                                        <span class="error invalid-feedback">{{ $errors->first('no_telp_opsional') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
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
                                        <select name="spp_opsi_id" class="custom-select select2 @error('spp_opsi_id') is-invalid @enderror">
                                            @foreach($opsi as $item)
                                                <option
                                                    value="{{ $item->id }}" {{ $santri->spp_opsi_id == $item->id ? 'selected' : '' }}>{{ $item->opsi . ' (Rp'. number_format($item->jumlah, 2, ',', '.') . ')' }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error invalid-feedback">{{ $errors->first('opp_opsi_id') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Kelas</label>
                                    <div class="col-sm-8">
                                        <select name="kelas_id" class="custom-select select2 @error('kelas_id') is-invalid @enderror">
                                            <option disabled="disabled" {{ $santri->kelas_id ?: 'selected="selected"' }}>Belum Masuk</option>
                                            @foreach($kelas as $item)
                                                @continue(($santri->jenis_kelamin == 'L' ? 'Ikhwan' : 'Akhwat') != $item->jenis_kelas)
                                                <option value="{{ $item->id }}" {{ $santri->kelas_id == $item->id ? 'selected' : '' }}>{{ $item->nama_kelas . ' (' . $item->jenis_kelas . ')' }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error invalid-feedback">{{ $errors->first('kelas_id') }}</span>
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
                                    @error('foto')
                                    <span class="text-danger text-sm">{{ $errors->first('foto') }}</span>
                                    @enderror
                                    <div class="form-text font-weight-lighter text-sm">
                                        Maksimal: 2048KB
                                    </div>
                                </div>
                                <img src="{{ \App\Helpers\UserHelpers::getSantriImage($santri->foto, $santri->jenis_kelamin) }}" class="img-thumbnail img-preview" style="width: 100%;" alt="Santri">
                                @if($santri->foto)
                                    <button type="submit" form="unlink" class="btn btn-outline-danger btn-sm position-absolute mt-3 ml-n5"><i class="fas fa-times"></i></button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <form action="{{ route('admin.santri.unlink', $santri) }}" id="unlink" method="post">
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

            $('#jenis_kelamin').on('change', function () {
                const jk = $(this).val();
                const img = $('.img-preview');
                if (jk == 'L') {
                    img.attr('src', "{{ asset('images/ikhwan-santri.svg') }}");
                } else {
                    img.attr('src', "{{ asset('images/akhwat-santri.svg') }}");
                }
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
