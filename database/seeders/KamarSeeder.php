<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Kamar;

class KamarSeeder extends Seeder
{
    public function run(): void
    {
        // Matikan foreign key dulu
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        Kamar::truncate();
        
        // Nyalakan lagi foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $kamar = [
            // Kelas 1 → 2 tempat tidur
            ['nama_kamar' => 'Tulip 1a',     'jenis_kamar' => 'Reguler', 'kelas_kamar' => 'Kelas 1', 'kapasitas' => 2, 'terisi' => 0],
            ['nama_kamar' => 'Tulip 1b',     'jenis_kamar' => 'Reguler', 'kelas_kamar' => 'Kelas 1', 'kapasitas' => 2, 'terisi' => 0],
            ['nama_kamar' => 'Tulip 1c',     'jenis_kamar' => 'Reguler', 'kelas_kamar' => 'Kelas 1', 'kapasitas' => 2, 'terisi' => 0],
            ['nama_kamar' => 'Tulip 1d',     'jenis_kamar' => 'Reguler', 'kelas_kamar' => 'Kelas 1', 'kapasitas' => 2, 'terisi' => 0],
            ['nama_kamar' => 'Tulip 1e',     'jenis_kamar' => 'Reguler', 'kelas_kamar' => 'Kelas 1', 'kapasitas' => 2, 'terisi' => 0],

            // Kelas 2 → 3 tempat tidur
            ['nama_kamar' => 'Flamboyan 2a', 'jenis_kamar' => 'Reguler', 'kelas_kamar' => 'Kelas 2', 'kapasitas' => 3, 'terisi' => 0],
            ['nama_kamar' => 'Flamboyan 2b', 'jenis_kamar' => 'Reguler', 'kelas_kamar' => 'Kelas 2', 'kapasitas' => 3, 'terisi' => 0],
            ['nama_kamar' => 'Flamboyan 2c', 'jenis_kamar' => 'Reguler', 'kelas_kamar' => 'Kelas 2', 'kapasitas' => 3, 'terisi' => 0],
            ['nama_kamar' => 'Flamboyan 2d', 'jenis_kamar' => 'Reguler', 'kelas_kamar' => 'Kelas 2', 'kapasitas' => 3, 'terisi' => 0],
            ['nama_kamar' => 'Flamboyan 2e', 'jenis_kamar' => 'Reguler', 'kelas_kamar' => 'Kelas 2', 'kapasitas' => 3, 'terisi' => 0],

            // Kelas 3 → 4 tempat tidur
            ['nama_kamar' => 'Melati 3a',    'jenis_kamar' => 'Reguler', 'kelas_kamar' => 'Kelas 3', 'kapasitas' => 4, 'terisi' => 0],
            ['nama_kamar' => 'Melati 3b',    'jenis_kamar' => 'Reguler', 'kelas_kamar' => 'Kelas 3', 'kapasitas' => 4, 'terisi' => 0],
            ['nama_kamar' => 'Melati 3c',    'jenis_kamar' => 'Reguler', 'kelas_kamar' => 'Kelas 3', 'kapasitas' => 4, 'terisi' => 0],
            ['nama_kamar' => 'Melati 3d',    'jenis_kamar' => 'Reguler', 'kelas_kamar' => 'Kelas 3', 'kapasitas' => 4, 'terisi' => 0],

            // VIP → 1 tempat tidur
            ['nama_kamar' => 'Mawar a',      'jenis_kamar' => 'VIP',     'kelas_kamar' => 'VIP',     'kapasitas' => 1, 'terisi' => 0],
            ['nama_kamar' => 'Mawar b',      'jenis_kamar' => 'VIP',     'kelas_kamar' => 'VIP',     'kapasitas' => 1, 'terisi' => 0],
            ['nama_kamar' => 'Mawar c',      'jenis_kamar' => 'VIP',     'kelas_kamar' => 'VIP',     'kapasitas' => 1, 'terisi' => 0],

            // VVIP → 1 tempat tidur
            ['nama_kamar' => 'Anggrek a',    'jenis_kamar' => 'VVIP',    'kelas_kamar' => 'VVIP',    'kapasitas' => 1, 'terisi' => 0],
            ['nama_kamar' => 'Anggrek b',    'jenis_kamar' => 'VVIP',    'kelas_kamar' => 'VVIP',    'kapasitas' => 1, 'terisi' => 0],
            ['nama_kamar' => 'Anggrek c',    'jenis_kamar' => 'VVIP',    'kelas_kamar' => 'VVIP',    'kapasitas' => 1, 'terisi' => 0],
        ];

        foreach ($kamar as $k) {
            Kamar::create($k);
        }
    }
}