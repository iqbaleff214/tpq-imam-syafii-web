@extends('layouts.santri')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">SPP</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container">
                <form action="{{ route('santri.spp.update', $spp) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12 col-md-8">
                            <!-- Default box -->
                            <div class="card card-solid">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <a href="{{ route('santri.spp.index') }}" class="btn btn-outline-danger">
                                            Kembali
                                        </a>
                                    </h3>
                                </div>
                                <div class="card-body mb-3">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Bulan</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('bulan') is-invalid @enderror"
                                                   value="{{ old('bulan', $spp->bulan) }}" placeholder="Bulan" readonly>
                                            <span class="error invalid-feedback">{{ $errors->first('bulan') }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Nama</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                                   value="{{ old('nama', $spp->santri->nama_lengkap) }}"
                                                   placeholder="Nama" readonly>
                                            <span class="error invalid-feedback">{{ $errors->first('nama') }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Nominal</label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp</span>
                                                </div>
                                                <input type="text"
                                                       class="form-control @error('jumlah') is-invalid @enderror"
                                                       id="jumlah" placeholder="0" name="jumlah"
                                                       {{ $spp->status == 0 ? '' : 'readonly' }} value="{{ old('jumlah', $spp->jumlah)}}">
                                                <span
                                                    class="error invalid-feedback">{{ $errors->first('jumlah') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button class="btn bg-maroon" type="submit">
                                        Konfirmasi
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
                                        Bukti
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input @error('foto') is-invalid @enderror" name="foto" id="image">
                                                <label class="custom-file-label" for="image">Pilih Bukti (Opsional)</label>
                                            </div>
                                        </div>
                                        @error('foto')
                                        <span class="text-danger text-sm">{{ $errors->first('foto') }}</span>
                                        @enderror
                                        <div class="form-text font-weight-lighter text-sm">
                                            Maksimal: 2048KB
                                        </div>
                                    </div>
                                    <img src="<?= asset('images/cash.jpg') ?>" class="img-thumbnail img-preview" style="width: 100%;" alt="Administrator">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
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
    {{-- MaskMoney --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();

            $('input[name=jumlah]').mask("000.000.000.000", {reverse: true});
            $("form").submit(function () {
                $("input[name=jumlah]").unmask();
            });


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

