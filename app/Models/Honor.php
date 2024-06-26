<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Honor extends Model
{
    use HasFactory;

    protected $table = 'honor';
    protected $guarded = [];

    public function pengajar()
    {
        return $this->belongsTo(Pengajar::class);
    }
}
