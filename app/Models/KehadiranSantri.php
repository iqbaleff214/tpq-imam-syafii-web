<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KehadiranSantri extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kehadiran_santri';
    protected $guarded = [];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
