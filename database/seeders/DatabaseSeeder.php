<?php

namespace Database\Seeders;

use App\Models\Administrator;
use App\Models\User;
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
    }
}
