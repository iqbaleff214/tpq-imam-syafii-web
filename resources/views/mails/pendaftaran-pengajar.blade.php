@extends('layouts.mail')

@section('title', 'Pendaftaran Akun')

@section('body')
    <div class="col-lg-6 mx-auto">
        <h3 class="display-6">Pendaftaran Akun</h3>
        <p class="lead my-4">Bismillahirrahmanirrahim, </p>
        <p class="lead my-4">TPQ Imam Syafi'i Banjarmasin dengan surat ini menyatakan bahwa akun atas nama <span class="fw-bold">{{ strtoupper($pengajar->nama) }}</span> sebagai <span class="fw-bold">PENGAJAR</span> berhasil dibuat.</p>
        <p>
            Untuk mengetahui informasi lebih lanjut silakan hubungi administrator atau langsung masuk ke sistem <a href="{{ route('login') }}" class="text-decoration-none fw-bold">{{ getenv('APP_NAME') }}</a> dengan akun berikut:
        </p>
            <table class="table table-borderless">
                <tr>
                    <th class="text-end" style="width: 48%">Username</th>
                    <td>:</td>
                    <td class="text-start" style="width: 48%">{{ $pengajar->akun->username }}</td>
                </tr>
                <tr>
                    <th class="text-end">Kata Sandi</th>
                    <td>:</td>
                    <td class="text-start">{{ $data['password']}}</td>
                </tr>
            </table>
        <p>Harap informasi akun di atas tidak dibagikan dengan siapapun. Barakallahu fiikum.</p>
    </div>
@endsection
