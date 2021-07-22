<?php

namespace App\Models;

use App\Http\Controllers\Admin\SantriController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SantriWali extends Model
{
    use HasFactory;

    protected $table = 'santri_wali';
    protected $guarded = [];

    public function santri()
    {
        return $this->belongsTo(SantriController::class);
    }
}
