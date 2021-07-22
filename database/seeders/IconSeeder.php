<?php

namespace Database\Seeders;

use App\Models\Icon;
use Illuminate\Database\Seeder;

class IconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
    }
}
