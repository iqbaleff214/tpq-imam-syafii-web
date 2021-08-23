<?php

namespace App\Imports;

use Alkoumi\LaravelHijriDate\Hijri;
use App\Models\Santri;
use App\Models\SantriWali;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class SantriImport implements WithHeadingRow, WithBatchInserts, ToCollection
{
    private $kelas_id;

    public function __construct($kelas_id)
    {
        $this->kelas_id = $kelas_id;
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if(!$row['email']) break;
            if(User::where('email', $row['email'])->count()) continue;
            $nis = $row['nis'];

            if (!$nis) {
                $newNis = $row['jenis_kelamin'] == 'L' ? 'I' : 'A';
                $newNis .= Hijri::Date('ym');
                $no = Santri::withTrashed()->where('nis', 'like', '%' . $newNis . '%')->count() + 1;
                $nis = sprintf("$newNis%02d", $no);
            }

            if(Santri::where('nis', $nis)->count()) continue;

            $akun = User::create([
                'username' => $nis,
                'email' => $row['email'],
                'password' => bcrypt($row['email']),
                'peran' => 'Santri',
            ]);

            $santri = Santri::create([
                'nis' => $nis,
                'nama_lengkap' => $row['nama_lengkap'],
                'nama_panggilan' => $row['nama_panggilan'] ?? $row['nama_lengkap'],
                'tempat_lahir' => $row['tempat_lahir'],
                'tanggal_lahir' => Date::excelToDateTimeObject($row['tanggal_lahir']),
                'jenis_kelamin' => strtoupper($row['jenis_kelamin']),
                'anak_ke' => $row['anak_ke'] ?? 1,
                'jumlah_saudara' => $row['jumlah_saudara'] ?? 1,
                'alamat' => $row['alamat'],
                'status' => 'Aktif',
                'foto' => null,
                'user_id' => $akun->id,
                'spp_opsi_id' => 1,
                'kelas_id' => $this->kelas_id,
            ]);

            SantriWali::create([
                'nama_wali' => $row['nama_ayah'],
                'hubungan' => 'Ayah',
                'no_telp' => $row['nomor_telepon'],
                'santri_id' => $santri->id
            ]);

        }
    }
}
