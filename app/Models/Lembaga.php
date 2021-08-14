<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lembaga extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'profil';
    protected $guarded = [];

    public function rekening()
    {
        return $this->hasMany(LembagaRekening::class, 'profil_id');
    }
}
