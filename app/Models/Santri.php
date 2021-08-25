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

    public function akun()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function wali()
    {
        return $this->hasMany(SantriWali::class);
    }

    public function sppOpsi()
    {
        return $this->belongsTo(SppOpsi::class, 'spp_opsi_id');
    }

    public function spp()
    {
        return $this->hasMany(Spp::class, 'santri_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function kehadiran()
    {
        return $this->hasMany(KehadiranSantri::class);
    }

    public function latest_kehadiran()
    {
        return $this->hasOne(KehadiranSantri::class, 'santri_id')->latestOfMany();
    }

    public function pembelajaran()
    {
        return $this->hasMany(Pembelajaran::class);
    }

    public function latestBacaan()
    {
        return $this->hasOne(Pembelajaran::class, 'santri_id')->with(['bacaan'])->latestOfMany();
    }

    public function hafalan()
    {
        return $this->hasMany(Hafalan::class);
    }

    public function latestHafalan()
    {
        return $this->hasOne(Hafalan::class, 'santri_id')->with(['hafalan'])->latestOfMany();
    }
}
