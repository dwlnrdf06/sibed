<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasienMasuk extends Model
{
    protected $table = 'pasien_masuk';

    protected $fillable = [
        'pasien_id',
        'kamar_id',
        'cara_masuk',
        'rujukan_dari',
        'pindahan_dari',
        'tanggal_masuk',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    public function pasienKeluar()
    {
        return $this->hasOne(PasienKeluar::class, 'pasien_id', 'pasien_id');
    }
}