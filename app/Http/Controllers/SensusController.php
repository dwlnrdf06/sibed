<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasienMasuk;
use App\Models\PasienKeluar;
use App\Models\SensusHarian;
use Carbon\Carbon;

class SensusController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tanggal dari filter, default hari ini
        $tanggal = $request->tanggal ?? Carbon::today()->toDateString();

        // Data pasien masuk berdasarkan tanggal
        $pasienMasuk = PasienMasuk::with(['pasien', 'kamar'])
                        ->whereDate('tanggal_masuk', $tanggal)
                        ->get();

        // Data pasien keluar berdasarkan tanggal
        $pasienKeluar = PasienKeluar::with(['pasien', 'kamar', 'kamarPindahan'])
                        ->whereDate('tanggal_keluar', $tanggal)
                        ->get();

        // Pasien awal = sisa pasien dari hari sebelumnya
        $tanggalKemarin = Carbon::parse($tanggal)->subDay()->toDateString();
        $pasienAwal = PasienMasuk::whereDate('tanggal_masuk', '<=', $tanggalKemarin)
                        ->whereDoesntHave('pasienKeluar', function($q) use ($tanggalKemarin) {
                            $q->whereDate('tanggal_keluar', '<=', $tanggalKemarin);
                        })
                        ->with(['pasien', 'kamar'])
                        ->get();

        return view('sensus.index', compact(
            'pasienMasuk',
            'pasienKeluar',
            'pasienAwal',
            'tanggal'
        ));
    }

    public function print($tanggal)
    {
    $pasienMasuk = PasienMasuk::with(['pasien', 'kamar'])
                    ->whereDate('tanggal_masuk', $tanggal)
                    ->get();

    $pasienKeluar = PasienKeluar::with(['pasien', 'kamar', 'kamarPindahan'])
                    ->whereDate('tanggal_keluar', $tanggal)
                    ->get();

    $tanggalKemarin = Carbon::parse($tanggal)->subDay()->toDateString();
    $pasienAwal = PasienMasuk::whereDate('tanggal_masuk', '<=', $tanggalKemarin)
                    ->whereDoesntHave('pasienKeluar', function($q) use ($tanggalKemarin) {
                        $q->whereDate('tanggal_keluar', '<=', $tanggalKemarin);
                    })
                    ->with(['pasien', 'kamar'])
                    ->get();

    return view('sensus.print', compact('pasienMasuk', 'pasienKeluar', 'pasienAwal', 'tanggal'));
    }
}