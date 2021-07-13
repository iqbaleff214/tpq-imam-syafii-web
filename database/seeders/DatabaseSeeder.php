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
            'username' => 'kepala',
            'email' => 'kepala@tpq.com',
            'password' => Hash::make('admin'),
            'peran' => 'Kepala'
        ]);

        Administrator::create([
            'nama' => 'Kepala TPQ',
            'tempat_lahir' => 'Banjarmasin',
            'tanggal_lahir' => date('Y-m-d'),
            'jenis_kelamin' => 'L',
            'no_telp' => '082159142175',
            'alamat' => 'Jl. Kepala TPQ',
            'jabatan' => 'Kepala TPQ',
            'user_id' => $kepala->id,
        ]);

        $admin = User::create([
            'username' => 'admin',
            'email' => 'admin@tpq.com',
            'password' => Hash::make('admin'),
            'peran' => 'Admin'
        ]);

        Administrator::create([
            'nama' => 'Admin TPQ',
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
