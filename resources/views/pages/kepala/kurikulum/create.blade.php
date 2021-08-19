@extends('layouts.kepala')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kurikulum</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('kepala.kurikulum.index') }}">Kurikulum</a></li>
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
            <form action="{{ route('kepala.kurikulum.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-6">
                        <!-- Default box -->
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{ route('kepala.kurikulum.index') }}" class="btn btn-outline-danger">
                                        Kembali
                                    </a>
                                </h3>
                            </div>
                            <div class="card-body mb-3">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Tingkat</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('tingkat') is-invalid @enderror" name="tingkat" placeholder="Tingkat" value="{{ old('tingkat') }}">
                                        <span class="error invalid-feedback">{{ $errors->first('tingkat') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Jadwal</label>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <select name="mulai" id="" class="custom-select select2">
                                                    @foreach($days as $day)
                                                        <option value="{{ $day }}" {{ $day=='Senin' ? 'selected' : '' }}>{{ $day }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="error invalid-feedback">{{ $errors->first('mulai') }}</span>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" value="s.d." class="form-control" readonly>
                                            </div>
                                            <div class="col-sm-5">
                                                <select name="selesai" id="" class="custom-select select2">
                                                    @foreach($days as $day)
                                                        <option value="{{ $day }}" {{ $day=='Kamis' ? 'selected' : '' }}>{{ $day }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="error invalid-feedback">{{ $errors->first('selesai') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Target</label>
                                    <div class="col-sm-10">
                                        <textarea name="target" rows="5" class="form-control @error('target') is-invalid @enderror" placeholder="Target">{{ old('target') }}</textarea>
                                        <span class="error invalid-feedback">{{ $errors->first('target') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Catatan</label>
                                    <div class="col-sm-10">
                                        <textarea name="catatan" rows="5" class="form-control @error('catatan') is-invalid @enderror" placeholder="Catatan">{{ old('catatan') }}</textarea>
                                        <span class="error invalid-feedback">{{ $errors->first('catatan') }}</span>
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
                    <div class="col-12 col-md-6">
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Bahan Pendidikan
                                </h3>
                                <button class="btn btn-outline-danger float-right" type="button" id="add-bahan">
                                    Tambah
                                </button>
                            </div>
                            <div class="card-body" id="container-bahan">
                                <div class="form-group">
                                    <input type="text" class="form-control @error('bahan[]') is-invalid @enderror" placeholder="Bahan Pendidikan Utama" name="bahan[]" autocomplete="off" required>
                                </div>

                            </div>
                        </div>
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Materi Kurikulum
                                </h3>
                                <button class="btn btn-outline-danger float-right" type="button" id="add-materi">
                                    Tambah
                                </button>
                            </div>
                            <div class="card-body" id="container-materi">
                                <div class="form-group">
                                    <input type="text" class="form-control @error('materi[]') is-invalid @enderror" placeholder="Materi Kurikulum" name="materi[]" autocomplete="off" required>
                                </div>

                            </div>
                        </div>
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Metode Pembelajaran
                                </h3>
                                <button class="btn btn-outline-danger float-right" type="button" id="add-metode">
                                    Tambah
                                </button>
                            </div>
                            <div class="card-body" id="container-metode">
                                <div class="form-group">
                                    <textarea name="metode[]" rows="2" class="form-control @error('metode[]') is-invalid @enderror" placeholder="Metode Pembelajaran" required></textarea>
                                </div>
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

            $('#add-bahan').click(function() {
                const newRow = `
                    <div class="input-group mb-3" id="newRow">
                        <input type="text" name="bahan[]" class="form-control @error('bahan[]') is-invalid @enderror" placeholder="Bahan Pendidikan (Opsional)" autocomplete="off">
                        <div class="input-group-append">
                            <button id="removeRow" type="button" class="btn btn-danger">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
                $('#container-bahan').append(newRow);
            });
            $('#add-materi').click(function() {
                const newRow = `
                    <div class="input-group mb-3" id="newRow">
                        <input type="text" name="materi[]" class="form-control @error('materi[]') is-invalid @enderror" placeholder="Materi Kurikulum (Opsional)" autocomplete="off">
                        <div class="input-group-append">
                            <button id="removeRow" type="button" class="btn btn-danger">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
                $('#container-materi').append(newRow);
            });
            $('#add-metode').click(function() {
                const newRow = `
                    <div class="input-group mb-3" id="newRow">
                        <textarea name="metode[]" rows="2" class="form-control @error('metode[]') is-invalid @enderror" placeholder="Metode Pembelajaran (Opsional)"></textarea>
                        <div class="input-group-append">
                            <button id="removeRow" type="button" class="btn btn-danger">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
                $('#container-metode').append(newRow);
            });

            $(document).on('click', '#removeRow', function() {
                $(this).closest('#newRow').remove();
            });
        });
    </script>
@endpush
