<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasien'; // ← wajib ada

    protected $fillable = [
        'nama_pasien',
        'no_rm',
    ];
}