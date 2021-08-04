<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Santri extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'santri';
    protected $guarded = [];

    public function wali()
    {
        return $this->hasMany(SantriWali::class);
    }

    public function spp()
    {
        return $this->belongsTo(SppOpsi::class, 'spp_opsi_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function kehadiran()
    {
        return $this->hasMany(KehadiranSantri::class);
    }
}
