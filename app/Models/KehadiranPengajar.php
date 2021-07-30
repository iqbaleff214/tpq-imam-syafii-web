<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KehadiranPengajar extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kehadiran_pengajar';
    protected $guarded = [];

    public function pengajar()
    {
        return $this->belongsTo(Pengajar::class);
    }
}
