<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\PasienMasuk;
use App\Models\Kamar;
use App\Models\SensusHarian;
use App\Models\Rekapitulasi;
use Carbon\Carbon;

class PasienMasukController extends Controller
{
    public function index()
    {
        $kamar = Kamar::whereColumn('terisi', '<', 'kapasitas')->get();
        return view('pasien-masuk.index', compact('kamar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pasien'   => 'required',
            'no_rm'         => 'required',
            'cara_masuk'    => 'required',
            'kamar_id'      => 'required',
            'tanggal_masuk' => 'required|date',
        ]);

        // Kalau pasien sudah ada (dipilih dari dropdown) pakai data lama
        // Kalau belum ada, buat baru
        $pasien = Pasien::firstOrCreate(
            ['no_rm' => $request->no_rm],
            ['nama_pasien' => $request->nama_pasien]
        );

        PasienMasuk::create([
            'pasien_id'     => $pasien->id,
            'kamar_id'      => $request->kamar_id,
            'cara_masuk'    => $request->cara_masuk,
            'rujukan_dari'  => $request->rujukan_dari,
            'tanggal_masuk' => $request->tanggal_masuk,
        ]);

        $kamar = Kamar::find($request->kamar_id);
        $kamar->increment('terisi');

        if ($kamar->terisi >= $kamar->kapasitas) {
            $kamar->update(['status' => 'terisi']);
        } else {
            $kamar->update(['status' => 'sebagian']);
        }

        $this->updateSensus($request->tanggal_masuk);

        return back()->with('success', 'Data pasien masuk berhasil disimpan!');
    }

    private function updateSensus($tanggal)
    {
        $masukHariIni   = PasienMasuk::whereDate('tanggal_masuk', $tanggal)->get();
        $pasienBaru     = $masukHariIni->where('cara_masuk', 'Pasien Baru')->count();
        $pasienPindahan = $masukHariIni->where('cara_masuk', 'Pindahan Ruangan')->count();
        $pasienRujukan  = $masukHariIni->where('cara_masuk', 'Rujukan')->count();

        // Hitung pasien awal (sisa dari hari sebelumnya)
        $tanggalKemarin = Carbon::parse($tanggal)->subDay()->toDateString();
        $pasienAwal     = PasienMasuk::whereDate('tanggal_masuk', '<=', $tanggalKemarin)
                            ->where(function($q) use ($tanggalKemarin) {
                                $q->whereDoesntHave('pasienKeluar')
                                ->orWhereHas('pasienKeluar', function($q2) use ($tanggalKemarin) {
                                    $q2->whereDate('tanggal_keluar', '>', $tanggalKemarin);
                                });
                            })->count();

        $keluarHariIni  = \App\Models\PasienKeluar::whereDate('tanggal_keluar', $tanggal)->get();
        $sembuh         = $keluarHariIni->where('cara_keluar', 'Sembuh')->count();
        $pulangPaksa    = $keluarHariIni->where('cara_keluar', 'Pulang Paksa')->count();
        $dirujuk        = $keluarHariIni->where('cara_keluar', 'Dirujuk')->count();
        $dipindahkan    = $keluarHariIni->where('cara_keluar', 'Dipindahkan')->count();
        $meninggalLt48  = $keluarHariIni->where('cara_keluar', 'Meninggal < 48 Jam')->count();
        $meninggalGte48 = $keluarHariIni->where('cara_keluar', 'Meninggal >= 48 Jam')->count();

        $masihDirawat     = PasienMasuk::whereDate('tanggal_masuk', '<=', $tanggal)
                                ->whereDoesntHave('pasienKeluar')
                                ->count();

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
        ];

        // ← Simpan ke tabel sensus_harian
        SensusHarian::updateOrCreate(
            ['tanggal' => $tanggal],
            $data
        );

        // ← Simpan ke tabel rekapitulasi (tabel terpisah) ← TAMBAHAN BARU
        Rekapitulasi::updateOrCreate(
            ['tanggal' => $tanggal],
            array_merge($data, [
                'bulan' => Carbon::parse($tanggal)->month,
                'tahun' => Carbon::parse($tanggal)->year,
            ])
        );
    }
}