<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KurikulumMetode extends Model
{
    use HasFactory;
    protected $table = 'kurikulum_metode';
    protected $fillable = ['metode', 'kurikulum_id'];
}
