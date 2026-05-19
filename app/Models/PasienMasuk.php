<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasienMasuk extends Model
{
    protected $table = 'pasien_masuk'; // ← tambah ini agar tidak auto jadi 'pasien_masuks'

    protected $fillable = [
        'pasien_id',
        'kamar_id',
        'cara_masuk',
        'rujukan_dari',
        'tanggal_masuk',
    ];

    // Relasi ke tabel pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    // Relasi ke tabel kamar
    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }
    public function pasienKeluar()
    {
    return $this->hasOne(PasienKeluar::class, 'pasien_masuk_id', 'id');
    }
}