<?php

namespace App\Imports;

use App\Models\KehadiranSantri;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Hijri;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KehadiranSantriImport implements ToModel, WithBatchInserts, WithHeadingRow
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
    /**
    * @param array $row
    *
    * @return Model|null
    */
    public function model(array $row)
    {
        Hijri::setDefaultAdjustment(-1);
        Date::setTranslation(new Indonesian());

        $keterangan = ucfirst(strtolower($row['keterangan']));
        $createdAt = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($row['tanggal']);

        return new KehadiranSantri([
            'created_at' => $createdAt,
            'nilai_adab' => $row['nilai_adab'],
            'catatan' => $row['catatan'],
            'keterangan' => in_array($keterangan, ['Hadir', 'Sakit', 'Izin', 'Absen']) ? $keterangan : 'Absen',
            'bulan' => Hijri::convertToHijri($createdAt)->format('F o'),
            'santri_id' => $this->id,
        ]);
    }

    public function batchSize(): int
    {
        return 100;
    }
}
