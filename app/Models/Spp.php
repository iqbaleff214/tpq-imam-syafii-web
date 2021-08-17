<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spp extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'spp';
    protected $guarded = [];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
