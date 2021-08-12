<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SppOpsi extends Model
{
    use HasFactory;

    protected $table = 'spp_opsi';
    protected $guarded = [];
}
