<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Administrator extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'admin';
    protected $guarded = [];

    public function akun()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function menulis()
    {
        return $this->hasMany(Pengumuman::class, 'admin_id');
    }
}
