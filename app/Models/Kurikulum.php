<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kurikulum extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kurikulum';
    protected $guarded = [];

    public function bahan()
    {
        return $this->hasMany(KurikulumBahan::class);
    }

    public function materi()
    {
        return $this->hasMany(KurikulumMateri::class);
    }

    public function metode()
    {
        return $this->hasMany(KurikulumMetode::class);
    }
}
