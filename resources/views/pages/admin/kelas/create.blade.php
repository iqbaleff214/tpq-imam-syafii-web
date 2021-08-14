@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kelas</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.kelas.index') }}">Kelas</a></li>
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
            <form action="{{ route('admin.kelas.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-6">
                        <!-- Default box -->
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{ route('admin.kelas.index') }}" class="btn btn-outline-danger">
                                        Kembali
                                    </a>
                                </h3>
                            </div>
                            <div class="card-body mb-3">

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nama Kelas</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" name="nama_kelas" placeholder="Nama" value="{{ old('nama_kelas') }}">
                                        <span class="error invalid-feedback">{{ $errors->first('nama_kelas') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Jenis Kelas</label>
                                    <div class="col-sm-8">
                                        <select name="jenis_kelas" id="jenis_kelas" class="custom-select select2 @error('jenis_kelas') is-invalid @enderror">
                                            <option value="Ikhwan">Ikhwan</option>
                                            <option value="Akhwat">Akhwat</option>
                                        </select>
                                        <span class="error invalid-feedback">{{ $errors->first('jenis_kelas') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Tingkat</label>
                                    <div class="col-sm-8">
                                        <select name="kurikulum_id" class="custom-select select2 @error('kurikulum_id') is-invalid @enderror">
                                            @foreach($kurikulum as $item)
                                                <option value="{{ $item->id }}">{{ $item->tingkat }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error invalid-feedback">{{ $errors->first('kurikulum_id') }}</span>
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
                                    Pengajar
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Pengajar</label>
                                    <div class="col-sm-8">
                                        <select name="pengajar_id" id="pengajar_id" class="custom-select select2 @error('pengajar_id') is-invalid @enderror">
                                            @foreach($pengajar as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error invalid-feedback">{{ $errors->first('pengajar_id') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Foto</label>
                                    <div class="col-sm-8">
                                        <img src="{{ asset('images/ikhwan.jpg') }}" class="img-thumbnail img-preview" style="width: 100%;" alt="Administrator">
                                    </div>
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

            generateData();

            $('#jenis_kelas').on('change', function() {
                const pengajar = $('#pengajar_id');
                const jenis_kelamin = $(this).val() == 'Akhwat' ? 'P' : 'L';
                $.ajax({
                    url: "{{ route('admin.kelas.create') }}",
                    type: 'get',
                    data: {
                        jenis_kelamin: jenis_kelamin,
                        type: 'jk'
                    },
                    success: function(response) {
                        let option = '';
                        response.forEach(e => option += `<option value="` + e.id +`">` + e.nama +`</option>` );
                        pengajar.html(option);
                        generateData();
                    }
                });
            });

            $('#pengajar_id').on('change', function() {
                generateData();
            });
        });

        function generateData() {
            const id = $('#pengajar_id').val();
            const img = $('.img-preview');
            $.ajax({
                url: "{{ route('admin.kelas.create') }}",
                type: "get",
                data: {
                    type: 'foto',
                    id: id
                },
                success: function(response) {
                    let foto = response.jenis_kelamin == 'L' ? "{{ asset('images/ikhwan.jpg') }}" : "{{ asset('images/akhwat.jpg') }}";
                    if (response.foto) {
                        foto = "{{ asset('storage') }}/"+response.foto;
                    }

                    img.attr('src', foto);
                }
            });
        }

    </script>
@endpush
