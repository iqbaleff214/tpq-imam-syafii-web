<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengajar extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pengajar';
    protected $guarded = [];

    public function akun()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas()
    {
        return $this->hasOne(Kelas::class);
    }

    public function kehadiran()
    {
        return $this->hasMany(KehadiranPengajar::class);
    }

    public function latest_kehadiran()
    {
        return $this->hasOne(KehadiranPengajar::class, 'pengajar_id')->latestOfMany();
    }

    public function honor()
    {
        return $this->hasMany(Honor::class);
    }
}
