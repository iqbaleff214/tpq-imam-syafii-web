<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LembagaRekening extends Model
{
    use HasFactory;

    protected $table = 'profil_rekening';
    protected $guarded = [];

    public function lembaga()
    {
        return $this->belongsTo(Lembaga::class, 'profil_id');
    }
}
