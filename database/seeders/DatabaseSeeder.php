<?php

namespace Database\Seeders;

use App\Models\Administrator;
use App\Models\Icon;
use App\Models\Lembaga;
use App\Models\Materi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        # Kepala account
        $kepala = User::create([
            'username' => 'rizki',
            'email' => 'rizkikhairani26@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'peran' => 'Kepala'
        ]);
        Administrator::create([
            'nama' => 'Akhmad Rizki Khairani',
            'tempat_lahir' => 'Banjarmasin',
            'tanggal_lahir' => date('Y-m-d'),
            'jenis_kelamin' => 'L',
            'no_telp' => '082159142175',
            'alamat' => 'Jl. Kepala TPQ',
            'jabatan' => 'Kepala Sekolah',
            'user_id' => $kepala->id,
        ]);

        # Administrator account
        $admin = User::create([
            'username' => 'abdullah',
            'email' => 'abdullahaminnakir@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'peran' => 'Admin'
        ]);
        Administrator::create([
            'nama' => 'Abdullah',
            'tempat_lahir' => 'Banjarmasin',
            'tanggal_lahir' => date('Y-m-d'),
            'jenis_kelamin' => 'L',
            'no_telp' => '082159142175',
            'alamat' => 'Jl. Admin TPQ',
            'jabatan' => 'Sekretaris',
            'user_id' => $admin->id,
        ]);

        # Icons
        $icons = [
            'fas fa-user' => 'Pengguna',
            'fas fa-users' => 'Para Pengguna',

            'fas fa-envelope' => 'Surel',
            'fas fa-map-marker' => 'Lokasi',
            'fas fa-chalkboard' => 'Papan Tulis',
            'fas fa-chalkboard-teacher' => 'Guru',
            'fas fa-book' => 'Buku',
            'fas fa-book-reader' => 'Membaca Buku',
            'fas fa-pray' => 'Berdoa',
            'fas fa-mosque' => 'Masjid',
            'fas fa-smile-beam' => 'Senyum',
            'fas fa-calendar' => 'Kalender',

            'fas fa-desktop' => 'Layar',
            'fas fa-coins' => 'Uang Koin',
            'fas fa-table' => 'Tabel',
            'fas fa-boxes' => 'Kardus',
            'fas fa-handshake' => 'Jabat Tangan',
            'fas fa-info' => 'Informasi',

            'fas fa-chevron-up' => 'Panah Atas',
            'fas fa-chevron-down' => 'Panah Bawah',
            'fas fa-chevron-left' => 'Panah Kiri',
            'fas fa-chevron-right' => 'Panah Kanan',

            'fas fa-bars' => 'Hamburger Bar',
            'fas fa-key' => 'Kunci',
            'fas fa-lock' => 'Gembok Terkunci',
            'fas fa-unlock-alt' => 'Gembok Terbuka',

            'fas fa-male' => 'Laki-laki',
            'fas fa-female' => 'Perempuan',

            'fab fa-facebook' => 'Facebook',
            'fab fa-twitter' => 'Twitter',
            'fab fa-youtube' => 'Youtube',
            'fab fa-instagram' => 'Instagram',
            'fab fa-whatsapp' => 'Whatsapp',
        ];
        foreach ($icons as $icon => $name) Icon::create(['nama' => $name, 'icon' => $icon]);

        # Institution
        Lembaga::create([
            'nama' => "TPQ Imam Syafi'i Banjarmasin",
            'email' => 'tpq@tpqmis.com',
            'alamat' => "Jl. AMD XII Manunggal Banjarmasin",
            'no_telp' => '082159142175',
            'foto' => null,
            'visi' => "Membina dan mencetak generasi yang shalih dan shalihah, berakhlak mulia, pandai membaca Al-Qur’an dan mempunyai akidah berdasarkan Al-Qur’an dan as-Sunnah.",
            'is_active' => true,
            'deskripsi' => "TPQ Imam Syafi'i adalah Taman Pendidikan Al-Qur'an yang berada di bawah naungan pengurus Dewan Kemakmuran Masjid Imam Syafi'i Banjarmasin.",
            'created_at' => Carbon::now()
        ]);

        # Materi
        $materials = [
            # Al-Qur'an
            'Al-Fatihah' => 'QURAN',
            'Al-Baqarah' => 'QURAN',
            'Ali \'Imran' => 'QURAN',
            'An-Nisa' => 'QURAN',
            'Al-Maidah' => 'QURAN',
            'Al-An\'am' => 'QURAN',
            'Al-A\'raf' => 'QURAN',
            'Al-Anfal' => 'QURAN',
            'At-Taubah' => 'QURAN',
            'Yunus' => 'QURAN',
            'Hud' => 'QURAN',
            'Yusuf' => 'QURAN',
            'Ar-Ra\'d' => 'QURAN',
            'Ibrahim' => 'QURAN',
            'Al-Hijr' => 'QURAN',
            'An-Nahl' => 'QURAN',
            'Al-Isra' => 'QURAN',
            'Al-Kahfi' => 'QURAN',
            'Maryam' => 'QURAN',
            'Thaha' => 'QURAN',
            'Al-Anbiya' => 'QURAN',
            'Al-Hajj' => 'QURAN',
            'Al-Mu`minun' => 'QURAN',
            'An-Nur' => 'QURAN',
            'Al-Furqan' => 'QURAN',
            'Asy-Syu\'ara' => 'QURAN',
            'An-Naml' => 'QURAN',
            'Al-Qashas' => 'QURAN',
            'Al-Ankabut' => 'QURAN',
            'Ar-Rum' => 'QURAN',
            'Luqman' => 'QURAN',
            'As-Sajdah' => 'QURAN',
            'Al-Ahzab' => 'QURAN',
            'Saba' => 'QURAN',
            'Fathir' => 'QURAN',
            'Yasin' => 'QURAN',
            'Ash-Shaffat' => 'QURAN',
            'Shad' => 'QURAN',
            'Az-Zumar' => 'QURAN',
            'Ghafir' => 'QURAN',
            'Fushilat' => 'QURAN',
            'Asy-Syura' => 'QURAN',
            'Az-Zukhruf' => 'QURAN',
            'Ad-Dukhan' => 'QURAN',
            'Al-Jatsiah' => 'QURAN',
            'Al-Ahqaf' => 'QURAN',
            'Muhammad' => 'QURAN',
            'Al-Fath' => 'QURAN',
            'Al-Hujurat' => 'QURAN',
            'Qaf' => 'QURAN',
            'Adz-Dzariyat' => 'QURAN',
            'Ath-Thur' => 'QURAN',
            'An-Najm' => 'QURAN',
            'Al-Qamar' => 'QURAN',
            'Ar-Rahman' => 'QURAN',
            'Al-Waqi\'ah' => 'QURAN',
            'Al-Hadid' => 'QURAN',
            'Al-Mujadilah' => 'QURAN',
            'Al-Hasyr' => 'QURAN',
            'Al-Mumtahanah' => 'QURAN',
            'Ash-Shaf' => 'QURAN',
            'Al-Jumu\'ah' => 'QURAN',
            'Al-Munafiqun' => 'QURAN',
            'At-Taghabun' => 'QURAN',
            'Ath-Thalaq' => 'QURAN',
            'At-Tahrim' => 'QURAN',
            'Al-Mulk' => 'QURAN',
            'Al-Qalam' => 'QURAN',
            'Al-Haqqah' => 'QURAN',
            'Al-Ma\'arij' => 'QURAN',
            'Nuh' => 'QURAN',
            'Al-Jin' => 'QURAN',
            'Al-Muzzammil' => 'QURAN',
            'Al-Muddatsir' => 'QURAN',
            'Al-Qiyamah' => 'QURAN',
            'Al-Insan' => 'QURAN',
            'Al-Mursalat' => 'QURAN',
            'An-Naba' => 'QURAN',
            'An-Nazi\'at' => 'QURAN',
            '\'Abasa' => 'QURAN',
            'At-Takwir' => 'QURAN',
            'Al-Infithar' => 'QURAN',
            'Al-Muthaffifin' => 'QURAN',
            'Al-Insyiqaq' => 'QURAN',
            'Al-Buruj' => 'QURAN',
            'At-Tariq' => 'QURAN',
            'Al-A\'la' => 'QURAN',
            'Al-Ghasyiyah' => 'QURAN',
            'Al-Fajr' => 'QURAN',
            'Al-Balad' => 'QURAN',
            'Asy-Syams' => 'QURAN',
            'Al-Layl' => 'QURAN',
            'Adh-Dhuha' => 'QURAN',
            'Asy-Syarh' => 'QURAN',
            'At-Tin' => 'QURAN',
            'Al-\'Alaq' => 'QURAN',
            'Al-Qadr' => 'QURAN',
            'Al-Bayyinah' => 'QURAN',
            'Az-Zalzalah' => 'QURAN',
            'Al-\'Adiyat' => 'QURAN',
            'Al-Qari\'ah' => 'QURAN',
            'At-Takatsur' => 'QURAN',
            'Al-\'Ashr' => 'QURAN',
            'Al-Humazah' => 'QURAN',
            'Al-Fil' => 'QURAN',
            'Quraysy' => 'QURAN',
            'Al-Ma\'un' => 'QURAN',
            'Al-Kautsar' => 'QURAN',
            'Al-Kafirun' => 'QURAN',
            'An-Nashr' => 'QURAN',
            'Al-Lahab' => 'QURAN',
            'Al-Ikhlash' => 'QURAN',
            'Al-Falaq' => 'QURAN',
            'An-Nas' => 'QURAN',
            # Hadits
            'Niat yang ikhlas' => 'HADIS',
            'Bertaqwa di mana saja' => 'HADIS',
            'Ilmu memudahkan jalan ke Surga' => 'HADIS',
            'Jagalah Allah ta\'ala' => 'HADIS',
            'Larangan berbuat bid\'ah' => 'HADIS',
            'Mintalah kepada Allah ta\'ala' => 'HADIS',
            'Sholat tiang agama' => 'HADIS',
            'Larangan meninggalkan sholat' => 'HADIS',
            'Akhlaq yang baik' => 'HADIS',
            'Rukun Islam' => 'HADIS',
            'Rukun Iman' => 'HADIS',
            # Iqro
            'Jilid 1' => 'IQRO',
            'Jilid 2' => 'IQRO',
            'Jilid 3' => 'IQRO',
            'Jilid 4' => 'IQRO',
            'Jilid 5' => 'IQRO',
            'Jilid 6' => 'IQRO',
            # Doa
            'Masuk wc' => 'DOA',
            'Keluar wc' => 'DOA',
            'Ketika turun hujan' => 'DOA',
            'Setelah turun hujan' => 'DOA',
            'Ingin tidur' => 'DOA',
            'Bangun tidur' => 'DOA',
            'Berbuka puasa' => 'DOA',
            'Mau makan' => 'DOA',
            'Setelah makan' => 'DOA',
            'Mau wudhu' => 'DOA',
            'Setelah wudhu' => 'DOA',
            'Masuk rumah' => 'DOA',
            'Keluar rumah' => 'DOA',
            'Masuk Masjid' => 'DOA',
            'Keluar Masjid' => 'DOA',
            'Memakai pakaian' => 'DOA',
            'Melepas pakaian' => 'DOA',
            'Masuk pasar' => 'DOA',
            'Menjenguk orang sakit' => 'DOA',
            'Selesai azan' => 'DOA',
            'Naik kendaraan' => 'DOA',
            'Mandi' => 'DOA',
        ];
        foreach ($materials as $materi => $jenis) Materi::create(['materi' => $materi, 'jenis' => $jenis]);
    }
}
