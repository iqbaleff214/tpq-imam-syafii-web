<?php

namespace App\Imports;

use App\Models\Kas;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class KasImport implements ToModel, WithBatchInserts, WithHeadingRow
{
    private $data;
    public function __construct($data = null)
    {
        $this->data = $data;
    }

    /**
    * @param array $row
    *
    * @return Model|null
    */
    public function model(array $row)
    {
        return new Kas([
            'created_at' =>  Date::excelToTimestamp($row['tanggal']),
            'uraian' => $row['uraian'] ?? '-',
            'pemasukan' => $row['pemasukan'] ?? 0,
            'pengeluaran' => $row['pengeluaran'] ?? 0,
            'keterangan' => $row['keterangan'],
        ]);
    }

    public function batchSize(): int
    {
        return 50;
    }
}
