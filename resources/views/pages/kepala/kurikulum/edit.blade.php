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
                            <li class="breadcrumb-item"><a href="{{ route('kepala.kurikulum.index') }}">Kurikulum</a>
                            </li>
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
            <div class="row">
                <div class="col-12 col-md-6">
                    <!-- Default box -->
                    <form action="{{ route('kepala.kurikulum.update', $kurikulum) }}" method="post">
                        @csrf
                        @method('PUT')
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
                                        <input type="text" class="form-control @error('tingkat') is-invalid @enderror"
                                               name="tingkat" placeholder="Tingkat"
                                               value="{{ old('tingkat', $kurikulum->tingkat) }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Jadwal</label>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <select name="mulai" id="mulai" class="form-control select2">
                                                    @foreach($days as $day)
                                                        <option
                                                            value="{{ $day }}" {{ $day==$kurikulum->mulai ? 'selected' : '' }}>{{ $day }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" value="s.d." class="form-control" readonly>
                                            </div>
                                            <div class="col-sm-5">
                                                <select name="selesai" id="selesai" class="form-control select2">
                                                    @foreach($days as $day)
                                                        <option
                                                            value="{{ $day }}" {{ $day==$kurikulum->selesai ? 'selected' : '' }}>{{ $day }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Target</label>
                                    <div class="col-sm-10">
                                        <textarea name="target" rows="5"
                                                  class="form-control @error('target') is-invalid @enderror"
                                                  placeholder="Target">{{ old('target', $kurikulum->target) }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Catatan</label>
                                    <div class="col-sm-10">
                                        <textarea name="keterangan" rows="5"
                                                  class="form-control @error('keterangan') is-invalid @enderror"
                                                  placeholder="Catatan">{{ old('keterangan', $kurikulum->keterangan) }}</textarea>
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
                    </form>
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
                            @foreach($kurikulum->bahan as $bahan)
                                <div class="input-group mb-3 newRow">
                                    <input type="text" name="bahan"
                                           data-id="{{ $bahan->id }}"
                                           value="{{ $bahan->bahan }}"
                                           class="form-control inputRow">
                                    <div class="input-group-append">
                                        <button data-id="{{ $bahan->id }}" data-type="bahan" type="button"
                                                class="btn btn-outline-success editRow">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button data-id="{{ $bahan->id }}" data-type="bahan" type="button"
                                                class="btn btn-danger removeRow">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
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
                            @foreach($kurikulum->materi as $materi)
                                <div class="input-group mb-3 newRow">
                                    <input type="text" name="materi"
                                           data-id="{{ $materi->id }}"
                                           value="{{ $materi->materi }}"
                                           class="form-control inputRow">
                                    <div class="input-group-append">
                                        <button data-id="{{ $materi->id }}" data-type="materi" type="button"
                                                class="btn btn-outline-success editRow">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button data-id="{{ $materi->id }}" data-type="materi" type="button"
                                                class="btn btn-danger removeRow">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
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
                            @foreach($kurikulum->metode as $metode)
                                <div class="input-group mb-3 newRow">
                                    <textarea name="metode" rows="2" class="form-control inputRow"
                                              data-id="{{ $metode->id }}"
                                              placeholder="Metode Pembelajaran">{{ $metode->metode }}</textarea>
                                    <div class="input-group-append">
                                        <button data-id="{{ $metode->id }}" data-type="metode" type="button"
                                                class="btn btn-outline-success editRow">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button data-id="{{ $metode->id }}" data-type="metode" type="button"
                                                class="btn btn-danger removeRow">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
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

@endpush

<script>
    document.addEventListener("DOMContentLoaded", function () {
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();

            $('#add-bahan').click(function () {
                const newRow = `
                    <div class="input-group mb-3 newRow">
                        <input type="text" class="form-control inputRow" placeholder="Bahan Pendidikan">
                        <div class="input-group-append">
                            <button data-type="bahan" type="button"
                                    class="btn btn-success addRow">
                                <i class="fas fa-check"></i>
                            </button>
                            <button data-type="bahan" type="button"
                                    class="btn btn-danger removeRow">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
                $('#container-bahan').append(newRow);
            });
            $('#add-materi').click(function () {
                const newRow = `
                    <div class="input-group mb-3 newRow">
                        <input type="text" class="form-control inputRow" placeholder="Materi Kurikulum">
                        <div class="input-group-append">
                            <button data-type="materi" type="button"
                                    class="btn btn-success addRow">
                                <i class="fas fa-check"></i>
                            </button>
                            <button data-type="materi" type="button"
                                    class="btn btn-danger removeRow">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
                $('#container-materi').append(newRow);
            });
            $('#add-metode').click(function () {
                const newRow = `
                    <div class="input-group mb-3 newRow">
                        <textarea name="metode" rows="2" class="form-control inputRow" placeholder="Metode Pembelajaran"></textarea>
                        <div class="input-group-append">
                            <button data-type="metode" type="button"
                                    class="btn btn-success addRow">
                                <i class="fas fa-check"></i>
                            </button>
                            <button data-type="metode" type="button"
                                    class="btn btn-danger removeRow">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
                $('#container-metode').append(newRow);
            });

        });

        $(document).on('click', '.removeRow', function () {
            if (!confirm('Yakin ingin menghapus?')) return false;
            const el = $(this).closest('.newRow');
            if ($(this).attr('data-id')) {
                const id = $(this).data('id');
                const type = $(this).data('type');
                $.ajax({
                    url: "{{ route('kepala.kurikulum.delete') }}",
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        type: type
                    },
                    success: function (response) {
                        if (response) {
                            el.remove();
                        } else {
                            Swal.fire({
                                title: 'Gagal menghapus!',
                                icon: 'error',
                                showConfirmButton: false
                            })
                        }
                    }
                });
            } else {
                el.remove();
            }
        });

        $(document).on('click', '.editRow', function () {
            const id = $(this).data('id');
            const type = $(this).data('type');
            const el = $(this).closest('.newRow');
            const input = el.find('.inputRow');
            if (id) {
                $.ajax({
                    url: "{{ route('kepala.kurikulum.mod') }}",
                    type: "PUT",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        type: type,
                        data: input.val()
                    },
                    success: function (response) {
                        if (!response) {
                            Swal.fire({
                                title: 'Gagal mengedit!',
                                icon: 'error',
                                showConfirmButton: false
                            })
                        }
                    }
                });
            }
        });

        $(document).on('click', '.addRow', function () {
            const button = $(this);
            const type = $(this).data('type');
            const el = $(this).closest('.newRow');
            const input = el.find('.inputRow');
            const remove = el.find('.removeRow');
            if (input.val() != '') {
                $.ajax({
                    url: "{{ route('kepala.kurikulum.mod') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: "{{ $kurikulum->id }}",
                        type: type,
                        data: input.val()
                    },
                    success: function (response) {
                        if (response) {
                            button.removeClass('btn-success addRow').addClass('btn-outline-success editRow');
                            button.attr('data-id', response);
                            remove.attr('data-id', response);
                        } else {
                            Swal.fire({
                                title: 'Gagal menambahkan!',
                                icon: 'error',
                                showConfirmButton: false
                            })
                        }
                    }
                });
            }
        });
    });
</script>
