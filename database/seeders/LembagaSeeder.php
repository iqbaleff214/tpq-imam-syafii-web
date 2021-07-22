<?php

namespace Database\Seeders;

use App\Models\Lembaga;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LembagaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lembaga::create([
            'nama' => "TPQ Imam Syafi'i Banjarmasin",
            'email' => 'tpqimamsyafiibanjarmasin@gmail.com',
            'alamat' => "Jl. AMD XII Manunggal Banjarmasin, Kalimantan Selatan",
            'no_telp' => '082159142175',
            'foto' => null,
            'visi' => "Membina dan mencetak generasi yang shalih dan shalihah, berakhlak mulia, pandai membaca Al-Qur’an dan mempunyai akidah berdasarkan Al-Qur’an dan as-Sunnah.",
            'is_active' => true,
            'deskripsi' => "TPQ Imam Syafi'i adalah Taman Pendidikan Al-Qur'an yang berada di bawah naungan pengurus Dewan Kemakmuran Masjid Imam Syafi'i Banjarmasin.",
            'created_at' => Carbon::now()
        ]);
    }
}
