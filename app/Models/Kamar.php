<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $table = 'kamar';

    protected $fillable = [
        'nama_kamar',
        'jenis_kamar',
        'kelas_kamar',
        'kapasitas',
        'terisi',
        'status',
    ];

    // Otomatis hitung status berdasarkan kapasitas & terisi
    public function getStatusAutoAttribute()
    {
        if ($this->terisi == 0) return 'kosong';
        if ($this->terisi >= $this->kapasitas) return 'penuh';
        return 'sebagian';
    }

    // Hitung tempat tidur kosong
    public function getTersediaAttribute()
    {
        return $this->kapasitas - $this->terisi;
    }
}