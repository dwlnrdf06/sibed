<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensusHarian extends Model
{
    protected $table = 'sensus_harian'; // ← wajib ada

    protected $fillable = [
        'tanggal',
        'pasien_awal',
        'pasien_baru',
        'pasien_pindahan',
        'pasien_rujukan',
        'pasien_dipindahkan',
        'pasien_pulang_sembuh',
        'pasien_pulang_paksa',
        'meninggal_lt48',
        'meninggal_gte48',
        'dirujuk',
        'pasien_masih_dirawat',
    ];
}