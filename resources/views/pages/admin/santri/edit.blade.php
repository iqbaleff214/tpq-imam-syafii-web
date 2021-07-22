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
                                        <input type="text" class="form-control" value="{{ $santri->nis }}" disabled="disabled">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nama Lengkap</label>
                                    <div class="col-sm-8">
                                        <input type="text"
                                               class="form-control @error('nama_lengkap') is-invalid @enderror"
                                               name="nama_lengkap" placeholder="Nama Lengkap"
                                               value="{{ old('nama_lengkap', $santri->nama_lengkap) }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nama Panggilan</label>
                                    <div class="col-sm-8">
                                        <input type="text"
                                               class="form-control @error('nama_panggilan') is-invalid @enderror"
                                               name="nama_panggilan" placeholder="Nama Panggilan (Opsional)"
                                               value="{{ old('nama_panggilan', $santri->nama_panggilan) }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Tempat Lahir</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" placeholder="Tempat Lahir" value="{{ old('tempat_lahir', $santri->tempat_lahir) }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{ old('tanggal_lahir', date('Y-m-d', strtotime($santri->tanggal_lahir))) }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-8">
                                        <select name="jenis_kelamin" class="form-control select2">
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
                                                <input type="number" name="anak_ke"
                                                       class="form-control @error('anak_ke') is-invalid @enderror"
                                                       placeholder="Anak ke-... (Opsional)"
                                                       value="{{ old('anak_ke', $santri->anak_ke) }}">
                                            </div>
                                            <div class="col-12 col-md-6 my-2 my-md-0">
                                                <input type="number" name="jumlah_saudara"
                                                       class="form-control @error('jumlah_saudara') is-invalid @enderror"
                                                       placeholder="Dari ... bersaudara (Opsional)"
                                                       value="{{ old('jumlah_saudara', $santri->jumlah_saudara) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Alamat</label>
                                    <div class="col-sm-8">
                                        <textarea name="alamat" cols="30" rows="3" placeholder="Alamat"
                                                  class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $santri->alamat) }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Status</label>
                                    <div class="col-sm-8">
                                        <select name="status" class="form-control select2">
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
                                <button class="btn btn-outline-danger float-right" type="button" id="add-wali">
                                    Tambah
                                </button>
                            </div>
                            <div class="card-body" id="container-wali">
                                @foreach($santri->wali as $item)
                                <div class="form-group row">
                                    <div class="col-12 col-sm-4 col-md-4">
                                        <input type="text" class="form-control nama_wali"
                                               placeholder="Nama Wali" value="{{ $item->nama_wali }}">
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 mt-sm-0 mt-2">
                                        <select class="form-control select2 hubungan">
                                            @foreach($hubungan as $val)
                                                <option value="{{ $val }}" {{ $val == $item->hubungan ? 'selected' : "" }}>{{ $val }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 mt-sm-0 mt-2">
                                        <div class="input-group mb-3" id="newRow">
                                            <input type="text" class="form-control no_telp" value="{{ $item->no_telp }}">
                                            <div class="input-group-append">
                                                <button type="button" data-id="{{ $item->id }}" class="btn btn-success editRow">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button type="button" data-id="{{ $item->id }}" class="btn btn-outline-danger {{ $loop->first ? 'disabled' : 'removeRow' }}">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
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
                                        <select name="spp_opsi_id" class="form-control select2">
                                            @foreach($opsi as $item)
                                                <option
                                                    value="{{ $item->id }}" {{ $santri->spp_opsi_id == $item->id ? 'active' : '' }}>{{ $item->opsi . ' (Rp'. number_format($item->jumlah, 2, ',', '.') . ')' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Kelas</label>
                                    <div class="col-sm-8">
                                        <select name="kelas_id" class="form-control select2">
                                            <option disabled="disabled" {{ $santri->kelas_id ?: 'selected="selected"' }}>Kelas (Opsional)</option>
                                            @foreach($kelas as $item)
                                                <option value="{{ $item->id }}" {{ $santri->kelas_id == $item->id ? 'active' : '' }}>{{ $item->nama_kelas }}</option>
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
                                <img src="{{ \App\Helpers\UserHelpers::getUserImage($santri->foto, $santri->jenis_kelamin) }}" class="img-thumbnail img-preview" style="width: 100%;" alt="Santri">
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

    <script>
        $(function () {
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


            var wali = {{ $santri->wali->count() }};

            $('#add-wali').click(function () {
                if (wali == 2) return false;
                wali++;
                const newRow = `
                            <div class="form-group row newRow">
                                <div class="col-12 col-sm-4 col-md-4">
                                    <input type="text" class="form-control nama_wali" placeholder="Nama Wali" required>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 mt-sm-0 mt-2">
                                    <select class="form-control select2 hubungan">
                                        <option disabled="disabled" selected="selected">Hubungan</option>
                                        @foreach($hubungan as $val) <option value="{{ $val }}">{{ $val }}</option> @endforeach
                </select>
            </div>
            <div class="col-12 col-sm-4 col-md-4 mt-sm-0 mt-2">
               <div class="input-group mb-3">
                    <input type="text" class="form-control no_telp" placeholder="Nomor Telepon">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-success saveRow">
                            <i class="fas fa-check"></i>
                        </button>
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

            $(document).on('click', '.saveRow', function() {
                console.log($(this).closest('.nama_wali').val());
                console.log($(this).closest('.hubungan').val());
                console.log($(this).closest('.no_telp').val());
            });


            $(document).on('click', '.removeRow', function () {
                if ($(this).attr('data-id')) {
                    console.log('hapus wali');
                } else {
                    wali--;
                    $(this).closest('.newRow').remove();
                }
            });
        });

        $(document).on('click', '.editRow', function() {
            var nama = $(this).closest('.nama_wali');
            if ($(this).attr('data-id')) {
                console.log(nama.val());
                console.log($(this).closest('.hubungan').val());
                console.log($(this).closest('.no_telp').val());
            }
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
