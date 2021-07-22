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

    public function kelas()
    {
        return $this->hasOne(Kelas::class);
    }
}
