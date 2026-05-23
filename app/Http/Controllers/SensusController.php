<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasienMasuk;
use App\Models\PasienKeluar;
use App\Models\SensusPindahan;
use Carbon\Carbon;

class SensusController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tanggal filter
        $tanggal = $request->tanggal ?? Carbon::today()->toDateString();

        // ================= PASIEN MASUK =================

        $pasienMasuk = PasienMasuk::with(['pasien', 'kamar'])
            ->whereDate('tanggal_masuk', $tanggal)
            ->get();

        // Kelompok pasien masuk
        $pasienBaru = $pasienMasuk
            ->where('cara_masuk', 'Pasien Baru');

        $pasienPindahan = $pasienMasuk
            ->where('cara_masuk', 'Pindahan Ruangan');

        $pasienRujukan = $pasienMasuk
            ->where('cara_masuk', 'Rujukan');

        // ================= PASIEN KELUAR =================

        $pasienKeluar = PasienKeluar::with(['pasien', 'kamar'])
            ->whereDate('tanggal_keluar', $tanggal)
            ->get();

        // ================= SENSUS PINDAHAN =================

        $pindahanKeluar = SensusPindahan::whereDate(
            'tanggal',
            $tanggal
        )->get();

        // ================= PASIEN AWAL =================

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
            ->with(['pasien', 'kamar'])
            ->get();

        // ================= TAMPILKAN VIEW =================

        return view('sensus.index', compact(
            'pasienMasuk',
            'pasienBaru',
            'pasienPindahan',
            'pasienRujukan',
            'pasienKeluar',
            'pindahanKeluar',
            'pasienAwal',
            'tanggal'
        ));
    }

    public function print($tanggal)
    {
        // ================= PASIEN MASUK =================

        $pasienMasuk = PasienMasuk::with(['pasien', 'kamar'])
            ->whereDate('tanggal_masuk', $tanggal)
            ->get();

        // Kelompok pasien masuk
        $pasienBaru = $pasienMasuk
            ->where('cara_masuk', 'Pasien Baru');

        $pasienPindahan = $pasienMasuk
            ->where('cara_masuk', 'Pindahan Ruangan');

        $pasienRujukan = $pasienMasuk
            ->where('cara_masuk', 'Rujukan');

        // ================= PASIEN KELUAR =================

        $pasienKeluar = PasienKeluar::with(['pasien', 'kamar'])
            ->whereDate('tanggal_keluar', $tanggal)
            ->get();

        // ================= SENSUS PINDAHAN =================

        $pindahanKeluar = SensusPindahan::whereDate(
            'tanggal',
            $tanggal
        )->get();

        // ================= PASIEN AWAL =================

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
            ->with(['pasien', 'kamar'])
            ->get();

        // ================= PRINT VIEW =================

        return view('sensus.print', compact(
            'pasienMasuk',
            'pasienBaru',
            'pasienPindahan',
            'pasienRujukan',
            'pasienKeluar',
            'pindahanKeluar',
            'pasienAwal',
            'tanggal'
        ));
    }
}