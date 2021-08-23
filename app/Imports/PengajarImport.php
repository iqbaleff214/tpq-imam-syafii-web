<?php

namespace App\Imports;

use App\Models\Pengajar;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PengajarImport implements ToCollection, WithBatchInserts, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if(!$row['email']) break;
            $akun = User::create([
                'username' => $row['email'],
                'email' => $row['email'],
                'password' => bcrypt($row['email']),
                'peran' => 'Pengajar',
            ]);

            Pengajar::create([
                'nama' => $row['nama'],
                'tempat_lahir' => $row['tempat_lahir'],
                'tanggal_lahir' => Date::excelToDateTimeObject($row['tanggal_lahir']),
                'jenis_kelamin' => strtoupper($row['jenis_kelamin']),
                'alamat' => $row['alamat'],
                'no_telp' => $row['nomor_telepon'],
                'user_id' => $akun->id,
            ]);
        }
    }

    public function batchSize(): int
    {
        return 100;
    }
}
