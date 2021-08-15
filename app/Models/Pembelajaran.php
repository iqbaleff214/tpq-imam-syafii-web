<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembelajaran extends Model
{
    use HasFactory;

    protected $table = 'pembelajaran';
    protected $guarded = [];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function bacaan()
    {
        return $this->belongsTo(Materi::class, 'materi_id');
    }
}
