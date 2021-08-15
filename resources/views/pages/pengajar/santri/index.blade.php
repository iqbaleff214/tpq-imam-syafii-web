@extends('layouts.pengajar')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"> {{ $title }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container">
                @if ($santri->count())
                    <div class="card-columns">
                        @foreach($santri as $item)
                            <div class="card mb-3 card-maroon card-outline">
                                <div class="row no-gutters">
                                    <div class="col-md-4">
                                        <img
                                            src="{{ \App\Helpers\UserHelpers::getSantriImage($item->foto, $item->jenis_kelamin) }}"
                                            alt="{{ $item->nama }}" width="100%">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h4 class="">
                                                <a href="{{ route('pengajar.santri.show', $item) }}">
                                                    {{ $item->nama_panggilan }} <span class="text-sm">({{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }} thn)</span>
                                                </a>
                                            </h4>
                                            <h5 class="card-title text-muted">{{ $item->nama_lengkap }}</h5>
                                            <p class="card-text mt-4">
                                                <small class="text-muted d-block">{{ $item->nis }}</small>
                                                @if($bacaan = $item->pembelajaran()->orderBy('created_at', 'desc')->first())
                                                <small class="text-muted">{{ $bacaan->bacaan->materi . ': ' . ($bacaan->mulai==$bacaan->selesai ? $bacaan->mulai : "{$bacaan->mulai}-{$bacaan->selesai}") }}</small>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="row mt-5">
                        <div class="col-md-4 offset-md-4 text-center">
                            <p>Belum ada santri.</p>
                        </div>
                    </div>
                @endif
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
