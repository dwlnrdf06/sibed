<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\PasienKeluar;
use App\Models\PasienMasuk;
use App\Models\Kamar;
use App\Models\SensusHarian;
use App\Models\Rekapitulasi;
use App\Models\SensusPindahan;
use Carbon\Carbon;

class PasienKeluarController extends Controller
{
    public function index()
    {
        $kamar = Kamar::where('terisi', '>', 0)->get();

        return view('pasien-keluar.index', compact('kamar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pasien'    => 'required',
            'no_rm'          => 'required',
            'kamar_id'       => 'required',
            'cara_keluar'    => 'required',
            'tanggal_masuk'  => 'required|date',
            'tanggal_keluar' => 'required|date',
        ]);

        $pasien = Pasien::where('no_rm', $request->no_rm)->first();

        // Cari entri pasien masuk yang belum keluar
        $pasienMasuk = PasienMasuk::where('pasien_id', $pasien->id)
            ->whereNotIn('id', function($q) {
                $q->select('pasien_masuk_id')
                ->from('pasien_keluar')
                ->whereNotNull('pasien_masuk_id');
            })
            ->latest('tanggal_masuk')
            ->first();

        $masuk  = Carbon::parse($request->tanggal_masuk);
        $keluar = Carbon::parse($request->tanggal_keluar);

        $lama = $masuk->diffInDays($keluar);

        if ($masuk->isSameDay($keluar)) {

            $lama          = 1;
            $hariPerawatan = 1;

        } else {

            $hariPerawatan = $lama + 1;
        }

        // ================= SIMPAN PASIEN KELUAR =================

        PasienKeluar::create([
            'pasien_id'       => $pasien->id,
            'pasien_masuk_id' => $pasienMasuk?->id,
            'kamar_id'        => $request->kamar_id,
            'tanggal_masuk'   => $request->tanggal_masuk,
            'tanggal_keluar'  => $request->tanggal_keluar,
            'lama_dirawat'    => $hariPerawatan,
            'cara_keluar'     => $request->cara_keluar,
            'dirujuk_ke'      => $request->dirujuk_ke,
            'pindahan_dari'   => $request->pindahan_dari,
        ]);

        // ================= SIMPAN KE SENSUS PINDAHAN =================

        if ($request->cara_keluar == 'Dipindahkan') {

            $kamarAsal = Kamar::find($request->kamar_id);

            SensusPindahan::create([
                'tanggal'      => $request->tanggal_keluar,
                'nama_pasien'  => $request->nama_pasien,
                'no_rm'        => $request->no_rm,
                'dari_kamar'   => $kamarAsal?->nama_kamar,
                'ke_kamar'     => $request->pindahan_dari,
            ]);
        }

        // ================= UPDATE KAMAR =================

        $kamar = Kamar::find($request->kamar_id);

        $kamar->decrement('terisi');

        if ($kamar->terisi <= 0) {

            $kamar->update([
                'status' => 'kosong',
                'terisi' => 0
            ]);

        } elseif ($kamar->terisi >= $kamar->kapasitas) {

            $kamar->update([
                'status' => 'terisi'
            ]);

        } else {

            $kamar->update([
                'status' => 'sebagian'
            ]);
        }

        // ================= UPDATE SENSUS =================

        $this->updateSensus($request->tanggal_keluar);

        return back()->with(
            'success',
            'Data pasien keluar berhasil disimpan!'
        );
    }

    public function cariPasienAktif(Request $request)
    {
        $keyword = $request->get('keyword');

        // Cari pasien masuk yang BELUM ADA pasien keluarnya
        // berdasarkan pasien_masuk_id (bukan pasien_id)
        $pasienMasuk = PasienMasuk::with(['pasien', 'kamar'])
            ->whereHas('pasien', function ($q) use ($keyword) {
                $q->where('nama_pasien', 'LIKE', "%$keyword%")
                ->orWhere('no_rm', 'LIKE', "%$keyword%");
            })
            ->whereNotIn('id', function($q) {
                $q->select('pasien_masuk_id')
                ->from('pasien_keluar')
                ->whereNotNull('pasien_masuk_id');
            })
            ->latest('tanggal_masuk')
            ->first();

        if ($pasienMasuk) {
            return response()->json([
                'found'         => true,
                'nama_pasien'   => $pasienMasuk->pasien->nama_pasien,
                'no_rm'         => $pasienMasuk->pasien->no_rm,
                'kamar_id'      => $pasienMasuk->kamar_id,
                'nama_kamar'    => $pasienMasuk->kamar->nama_kamar,
                'tanggal_masuk' => $pasienMasuk->tanggal_masuk,
            ]);
        }

        return response()->json([
            'found' => false
        ]);
    }

    private function updateSensus($tanggal)
    {
        $masukHariIni = PasienMasuk::whereDate(
            'tanggal_masuk',
            $tanggal
        )->get();

        $pasienBaru = $masukHariIni
            ->where('cara_masuk', 'Pasien Baru')
            ->count();

        $pasienPindahan = $masukHariIni
            ->where('cara_masuk', 'Pindahan Ruangan')
            ->count();

        $pasienRujukan = $masukHariIni
            ->where('cara_masuk', 'Rujukan')
            ->count();

        $tanggalKemarin = Carbon::parse($tanggal)
            ->subDay()
            ->toDateString();

        $pasienAwal = PasienMasuk::whereDate(
                'tanggal_masuk',
                '<=',
                $tanggalKemarin
            )
            ->whereDoesntHave('pasienKeluar', function ($q) use ($tanggalKemarin) {

                $q->whereDate(
                    'tanggal_keluar',
                    '<=',
                    $tanggalKemarin
                );
            })
            ->count();

        $keluarHariIni = PasienKeluar::whereDate(
            'tanggal_keluar',
            $tanggal
        )->get();

        $sembuh = $keluarHariIni
            ->where('cara_keluar', 'Sembuh')
            ->count();

        $pulangPaksa = $keluarHariIni
            ->where('cara_keluar', 'Pulang Paksa')
            ->count();

        $dirujuk = $keluarHariIni
            ->where('cara_keluar', 'Dirujuk')
            ->count();

        $dipindahkan = $keluarHariIni
            ->where('cara_keluar', 'Dipindahkan')
            ->count();

        $meninggalLt48 = $keluarHariIni
            ->where('cara_keluar', 'Meninggal < 48 Jam')
            ->count();

        $meninggalGte48 = $keluarHariIni
            ->where('cara_keluar', 'Meninggal >= 48 Jam')
            ->count();

        $masihDirawat = PasienMasuk::whereDate(
                'tanggal_masuk',
                '<=',
                $tanggal
            )
            ->whereDoesntHave('pasienKeluar')
            ->count();

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

        SensusHarian::updateOrCreate(
            ['tanggal' => $tanggal],
            $data
        );

        Rekapitulasi::updateOrCreate(
            ['tanggal' => $tanggal],
            array_merge($data, [
                'bulan' => Carbon::parse($tanggal)->month,
                'tahun' => Carbon::parse($tanggal)->year,
            ])
        );
    }
}