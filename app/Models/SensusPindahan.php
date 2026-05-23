<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensusPindahan extends Model
{
    protected $table = 'sensus_pindahan';

    protected $fillable = [
        'tanggal',
        'nama_pasien',
        'no_rm',
        'dari_kamar',
        'ke_kamar',
    ];
}