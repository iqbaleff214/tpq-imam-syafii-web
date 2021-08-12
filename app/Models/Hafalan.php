<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hafalan extends Model
{
    use HasFactory;

    protected $table = 'hafalan';
    protected $guarded = [];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
