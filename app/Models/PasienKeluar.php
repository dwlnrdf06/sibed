<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasienKeluar extends Model
{
    protected $table = 'pasien_keluar'; // ← wajib ada

    protected $fillable = [
        'pasien_id',
        'pasien_masuk_id',
        'kamar_id',
        'tanggal_masuk',
        'tanggal_keluar',
        'lama_dirawat',
        'hari_perawatan',
        'cara_keluar',
        'dirujuk_ke',
        'kamar_pindahan_id',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }
    public function kamarPindahan()
{
    return $this->belongsTo(Kamar::class, 'kamar_pindahan_id');
}
}