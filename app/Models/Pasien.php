<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasien';

    protected $fillable = [
        'nama_pasien',
        'no_rm',
    ];

    public function setNamaPasienAttribute($value)
    {
        $this->attributes['nama_pasien'] = strtoupper($value);
    }

    public function setNoRmAttribute($value)
    {
        $this->attributes['no_rm'] = strtoupper($value);
    }
}