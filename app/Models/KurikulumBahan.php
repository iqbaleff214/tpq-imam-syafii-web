<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KurikulumBahan extends Model
{
    use HasFactory;

    protected $table = 'kurikulum_bahan';
    protected $fillable = ['bahan', 'kurikulum_id'];
}
