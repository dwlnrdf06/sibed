<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rekapitulasi extends Model
{
    protected $table = 'rekapitulasi';

    protected $fillable = [
        'bulan',
        'tahun',
        'tanggal',
        'pasien_awal',
        'pasien_baru',
        'pasien_pindahan',
        'pasien_rujukan',
        'pasien_dipindahkan',
        'pasien_pulang_sembuh',
        'pasien_pulang_paksa',
        'pasien_kabur',
        'meninggal_lt48',
        'meninggal_gte48',
        'dirujuk',
        'pasien_masih_dirawat',
        'bor',
        'avlos',
        'bto',
        'toi',
    ];
}