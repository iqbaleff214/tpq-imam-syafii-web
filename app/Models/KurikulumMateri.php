<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KurikulumMateri extends Model
{
    use HasFactory;
    protected $table = 'kurikulum_materi';
    protected $fillable = ['materi', 'kurikulum_id'];
}
