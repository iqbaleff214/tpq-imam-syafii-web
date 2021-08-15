@extends('layouts.mail')

@section('title', 'Penerimaan Santri Baru')

@push('style')
    <style>
        .display-6 {
            color: maroon;
        }
    </style>
@endpush

@section('body')
    <div class="col-lg-6 mx-auto">
        <h3 class="display-6">Penerimaan Santri Baru</h3>
        <p class="lead my-4">Bismillahirrahmanirrahim, </p>
        <p class="lead my-4">TPQ Imam Syafi'i Banjarmasin dengan surat ini menyatakan bahwa calon santri atas nama <span class="fw-bold">{{ strtoupper($santri->nama_lengkap) }}</span> dinyatakan <span class="fw-bold">{{ $santri->status == 'Aktif' ? 'DITERIMA' : 'BELUM DITERIMA' }}</span>.</p>
        @if($santri->status == 'Aktif')
        <p>
            Untuk mengetahui informasi lebih lanjut silakan hubungi administrator atau langsung masuk ke sistem <a href="{{ route('login') }}" class="text-decoration-none fw-bold">{{ getenv('APP_NAME') }}</a> dengan akun berikut:
        </p>
            <table class="table table-borderless">
                <tr>
                    <th class="text-end" style="width: 48%">Username</th>
                    <td>:</td>
                    <td class="text-start" style="width: 48%">{{ $santri->akun->username }}</td>
                </tr>
                <tr>
                    <th class="text-end">Kata Sandi</th>
                    <td>:</td>
                    <td class="text-start">[Kata Sandi yang didaftarkan]</td>
                </tr>
            </table>
        <p>Harap informasi akun di atas tidak dibagikan dengan siapapun. Barakallahu fiikum.</p>
        @else
            <p>Untuk mengetahui informasi lebih lanjut silakan hubungi administrator. Barakallahu fiikum</p>
        @endif
    </div>
@endsection
