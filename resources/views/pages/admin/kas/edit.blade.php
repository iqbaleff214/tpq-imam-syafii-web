@extends('layouts.admin')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kas</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <!-- <li class="breadcrumb-item"><a href="#">Kas</a></li> -->
                            <li class="breadcrumb-item active">Keuangan</li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.keuangan.kas.index') }}">Kas</a></li>
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
            <form action="{{ route('admin.keuangan.kas.update', $kas) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12 col-md-8">
                        <!-- Default box -->
                        <div class="card card-solid">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{ route('admin.keuangan.kas.index') }}" class="btn btn-outline-danger">
                                        Kembali
                                    </a>
                                </h3>
                            </div>
                            <div class="card-body mb-3">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Uraian</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control @error('uraian') is-invalid @enderror" placeholder="Uraian" name="uraian" value="{{ old('uraian', $kas->uraian) }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" id="jumlah-label">{{ $kas->pemasukan ? 'Pemasukan' : 'Pengeluaran' }}</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="number" class="form-control @error($kas->pemasukan ? 'pemasukan' : 'pengeluaran') is-invalid @enderror" id="jumlah-input" placeholder="0" name="{{ $kas->pemasukan ? 'pemasukan' : 'pengeluaran' }}" value="{{ old($kas->pemasukan ? 'pemasukan' : 'pengeluaran', $kas->pemasukan?:$kas->pengeluaran) }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text">,00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Keterangan</label>
                                    <div class="col-sm-8">
                                        <textarea name="keterangan" id="" placeholder="Keterangan (Opsinal)" cols="30" rows="3" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $kas->keterangan) }}</textarea>
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
                                    Bukti
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="foto" id="image">
                                            <label class="custom-file-label" for="image">Pilih Bukti (Opsional)</label>
                                        </div>
                                    </div>
                                </div>
                                <img src="{{ $kas->bukti ? asset("storage/$kas->bukti") : asset('images/cash.jpg') }}" class="img-thumbnail img-preview" style="width: 100%;" alt="Pengajar">
                                @if($kas->bukti)
                                    <button type="submit" form="unlink" class="btn btn-outline-danger btn-sm position-absolute mt-3 ml-n5"><i class="fas fa-times"></i></button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <form action="{{ route('admin.keuangan.kas.unlink', $kas) }}" id="unlink" method="post">
                @csrf
                @method('DELETE')
            </form>
        </section>
        <!-- /.content -->

    </div>
@endsection

@push('script')

    <script>
        $(function() {
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
