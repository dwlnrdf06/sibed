<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PasienMasuk;
use App\Models\PasienKeluar;
use App\Models\SensusHarian;
use App\Models\Rekapitulasi;
use App\Models\Kamar;
use Carbon\Carbon;

class UpdateSensusHarian extends Command
{
    protected $signature   = 'sensus:update';
    protected $description = 'Update sensus harian dan rekapitulasi otomatis';

    public function handle()
    {
        $tanggalPertama = PasienMasuk::min('tanggal_masuk');

        if (!$tanggalPertama) {
            $this->info('Tidak ada data pasien.');
            return;
        }

        $start = Carbon::parse($tanggalPertama);
        $end   = Carbon::today();

        while ($start->lte($end)) {
            $tanggal = $start->toDateString();
            $this->updatePerTanggal($tanggal);
            $start->addDay();
        }

        $this->info('Sensus harian dan rekapitulasi berhasil diupdate!');
    }

    private function updatePerTanggal($tanggal)
    {
        $tanggalKemarin = Carbon::parse($tanggal)->subDay()->toDateString();

        // PASIEN AWAL
        $pasienAwal = PasienMasuk::whereDate('tanggal_masuk', '<=', $tanggalKemarin)
            ->where(function($q) use ($tanggalKemarin) {
                $q->whereDoesntHave('pasienKeluar')
                  ->orWhereHas('pasienKeluar', function($q2) use ($tanggalKemarin) {
                      $q2->whereDate('tanggal_keluar', '>', $tanggalKemarin);
                  });
            })->count();

        // PASIEN MASUK HARI INI
        $masukHariIni   = PasienMasuk::whereDate('tanggal_masuk', $tanggal)->get();
        $pasienBaru     = $masukHariIni->where('cara_masuk', 'Pasien Baru')->count();
        $pasienPindahan = $masukHariIni->where('cara_masuk', 'Pindahan Ruangan')->count();
        $pasienRujukan  = $masukHariIni->where('cara_masuk', 'Rujukan')->count();

        // PASIEN KELUAR HARI INI
        $keluarHariIni  = PasienKeluar::whereDate('tanggal_keluar', $tanggal)->get();
        $sembuh         = $keluarHariIni->where('cara_keluar', 'Sembuh')->count();
        $pulangPaksa    = $keluarHariIni->where('cara_keluar', 'Pulang Paksa')->count();
        $dirujuk        = $keluarHariIni->where('cara_keluar', 'Dirujuk')->count();
        $dipindahkan    = $keluarHariIni->where('cara_keluar', 'Dipindahkan')->count();
        $meninggalLt48  = $keluarHariIni->where('cara_keluar', 'Meninggal < 48 Jam')->count();
        $meninggalGte48 = $keluarHariIni->where('cara_keluar', 'Meninggal >= 48 Jam')->count();

        // PASIEN MASIH DIRAWAT
        $masihDirawat = PasienMasuk::whereDate('tanggal_masuk', '<=', $tanggal)
            ->where(function($q) use ($tanggal) {
                $q->whereDoesntHave('pasienKeluar')
                  ->orWhereHas('pasienKeluar', function($q2) use ($tanggal) {
                      $q2->whereDate('tanggal_keluar', '>', $tanggal);
                  });
            })->count();

        // PERHITUNGAN INDIKATOR
        $totalKeluar      = $sembuh + $pulangPaksa + $dirujuk + $meninggalLt48 + $meninggalGte48;
        $totalLamaDirawat = $keluarHariIni->sum('lama_dirawat');
        $totalTempat      = Kamar::sum('kapasitas');
        $hariPerawatan    = $masihDirawat;

        $bor   = $totalTempat > 0 ? round(($hariPerawatan / $totalTempat) * 100, 2) : 0;
        $avlos = $totalKeluar  > 0 ? round($totalLamaDirawat / $totalKeluar, 2) : 0;
        $bto   = $totalTempat  > 0 ? round($totalKeluar / $totalTempat, 2) : 0;
        $toi   = $totalKeluar  > 0 ? round((($totalTempat - $hariPerawatan) / $totalKeluar), 2) : 0;

        $data = [
            'pasien_awal'          => $pasienAwal,
            'pasien_baru'          => $pasienBaru,
            'pasien_pindahan'      => $pasienPindahan,
            'pasien_rujukan'       => $pasienRujukan,
            'pasien_dipindahkan'   => $dipindahkan,
            'pasien_pulang_sembuh' => $sembuh,
            'pasien_pulang_paksa'  => $pulangPaksa,
            'meninggal_lt48'       => $meninggalLt48,
            'meninggal_gte48'      => $meninggalGte48,
            'dirujuk'              => $dirujuk,
            'pasien_masih_dirawat' => $masihDirawat,
            'bor'                  => $bor,
            'avlos'                => $avlos,
            'bto'                  => $bto,
            'toi'                  => $toi,
        ];

        // SIMPAN SENSUS HARIAN
        SensusHarian::updateOrCreate(
            ['tanggal' => $tanggal],
            $data
        );

        // SIMPAN REKAPITULASI
        Rekapitulasi::updateOrCreate(
            ['tanggal' => $tanggal],
            array_merge($data, [
                'bulan' => Carbon::parse($tanggal)->month,
                'tahun' => Carbon::parse($tanggal)->year,
            ])
        );
    }
}