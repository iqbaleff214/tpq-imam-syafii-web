@extends('layouts.kepala')

@section('body')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Administrator</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('kepala.admin.index') }}">Administrator</a></li>
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
        <form action="{{ route('kepala.admin.update', $admin) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">        
            <div class="col-12 col-md-8">        
                <!-- Default box -->
                <div class="card card-solid">
                    <div class="card-header">
                        <h3 class="card-title">
                            <a href="{{ route('kepala.admin.index') }}" class="btn btn-outline-danger">
                                Kembali
                            </a>
                        </h3>
                    </div>
                    <div class="card-body mb-3">
                        
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Nama</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Nama" value="{{ old('nama', $admin->nama) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Jabatan</label>
                            <div class="col-sm-8">
                                <select name="jabatan" id="" class="form-control select2">
                                    <option {{ $admin->jabatan=='Sekretaris' ? 'selected' : '' }} value="Sekretaris">Sekretaris</option>
                                    <option {{ $admin->jabatan=='Bendahara' ? 'selected' : '' }} value="Bendahara">Bendahara</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Tempat Lahir</label>
                            <div class="col-sm-8">
                                <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" placeholder="Tempat Lahir" value="{{ old('tempat_lahir', $admin->tempat_lahir) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{ old('tanggal_lahir', date('Y-m-d', strtotime($admin->tanggal_lahir))) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Jenis Kelamin</label>
                            <div class="col-sm-8">
                                <select name="jenis_kelamin" id="" class="form-control select2">
                                    <option {{ $admin->jenis_kelamin=='L' ? 'selected' : '' }} value="L">Laki-laki</option>
                                    <option {{ $admin->jenis_kelamin=='P' ? 'selected' : '' }} value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Nomor Telepon</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('no_telp') is-invalid @enderror" placeholder="Nomor Telepon" name="no_telp" value="{{ old('no_telp', $admin->no_telp) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Alamat</label>
                            <div class="col-sm-8">
                                <textarea name="alamat" id="" cols="30" rows="3" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $admin->alamat) }}</textarea>
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
                                    <input type="file" class="custom-file-input" name="foto" id="image">
                                    <label class="custom-file-label" for="image">Pilih foto</label>
                                </div>
                            </div>
                        </div>
                        <img src="{{ $admin->foto ? asset("storage/$admin->foto") : asset($admin->jenis_kelamin=="L" ? 'images/ikhwan.jpg' : 'images/akhwat.jpg') }}" class="img-thumbnail img-preview" style="width: 100%;" alt="Administrator">
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