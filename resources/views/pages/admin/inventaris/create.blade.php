@extends('layouts.admin')

@section('body')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Inventaris</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.inventaris.index') }}">Inventaris</a></li>
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
        <form action="{{ route('admin.inventaris.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12 col-md-8">
                <!-- Default box -->
                <div class="card card-solid">
                    <div class="card-header">
                        <h3 class="card-title">
                            <a href="{{ route('admin.inventaris.index') }}" class="btn btn-outline-danger">
                                Kembali
                            </a>
                        </h3>
                    </div>
                    <div class="card-body mb-3">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Kode</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('kode_barang') is-invalid @enderror" name="kode_barang" placeholder="Kode Barang" value="{{ old('kode_barang') }}">
                                <span class="error invalid-feedback">{{ $errors->first('kode_barang') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Barang</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" name="nama_barang" placeholder="Nama" value="{{ old('nama_barang') }}">
                                <span class="error invalid-feedback">{{ $errors->first('nama_barang') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Satuan</label>
                            <div class="col-sm-8">
                                <input type="text" name="satuan" class="form-control @error('satuan') is-invalid @enderror" placeholder="Satuan" value="{{ old('satuan') }}">
                                <span class="error invalid-feedback">{{ $errors->first('satuan') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Jumlah</label>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-6">
                                        <input class="form-control @error('jumlah_baik') is-invalid @enderror" placeholder="Kondisi Baik" name="jumlah_baik" value="{{ old('jumlah_baik') }}">
                                        <span class="error invalid-feedback">{{ $errors->first('jumlah_baik') }}</span>
                                        <div class="text-sm ml-2">Jumlah baik</div>
                                    </div>
                                    <div class="col-6">
                                        <input class="form-control @error('jumlah_rusak') is-invalid @enderror" placeholder="Kondisi Rusak" name="jumlah_rusak" value="{{ old('jumlah_rusak') }}">
                                        <span class="error invalid-feedback">{{ $errors->first('jumlah_rusak') }}</span>
                                        <div class="text-sm ml-2">Jumlah rusak</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Keterangan</label>
                            <div class="col-sm-8">
                                <textarea placeholder="Keterangan (Opsional)" name="keterangan" id="" cols="30" rows="3" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
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
                        <img src="<?= asset('images/inventory.jpg') ?>" class="img-thumbnail img-preview" style="width: 100%;" alt="Administrator">
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" integrity="sha512-kq3FES+RuuGoBW3a9R2ELYKRywUEQv0wvPTItv3DSGqjpbNtGWVdvT8qwdKkqvPzT93jp8tSF4+oN4IeTEIlQA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('script')
<!--Select2-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(function() {
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
