<?php

namespace App\Imports;

use App\Models\KehadiranPengajar;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Hijri;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KehadiranPengajarImport implements ToModel, WithHeadingRow, WithBatchInserts
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

        return new KehadiranPengajar([
            'datang' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['datang']),
            'pulang' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['pulang']),
            'created_at' => $createdAt,
            'keterangan' => in_array($keterangan, ['Hadir', 'Sakit', 'Izin']) ? $keterangan : 'Izin',
            'bulan' => Hijri::convertToHijri($createdAt)->format('F o'),
            'pengajar_id' => $this->id,
        ]);
    }

    public function batchSize(): int
    {
        return 100;
    }
}
