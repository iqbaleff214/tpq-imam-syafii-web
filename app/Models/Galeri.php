<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeri';
    protected $guarded = [];

    public function kategori()
    {
        return $this->belongsTo(KategoriGaleri::class, 'kategori_galeri_id');
    }
}
