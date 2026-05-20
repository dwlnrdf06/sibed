<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasienMasuk;
use App\Models\PasienKeluar;
use Carbon\Carbon;

class SensusController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tanggal dari filter, default hari ini
        $tanggal = $request->tanggal ?? Carbon::today()->toDateString();

        // Data semua pasien masuk hari ini
        $pasienMasuk = PasienMasuk::with(['pasien', 'kamar'])
                        ->whereDate('tanggal_masuk', $tanggal)
                        ->get();

        // Pisahkan berdasarkan kategori untuk tabel sensus
        $pasienBaru     = $pasienMasuk->where('cara_masuk', 'Pasien Baru');
        $pasienPindahan = $pasienMasuk->where('cara_masuk', 'Pindahan Ruangan');
        $pasienRujukan  = $pasienMasuk->where('cara_masuk', 'Rujukan');

        // Data pasien keluar
        $pasienKeluar = PasienKeluar::with(['pasien', 'kamar', 'kamarPindahan'])
                        ->whereDate('tanggal_keluar', $tanggal)
                        ->get();

        // Pasien Awal (sisa dari hari sebelumnya)
        $tanggalKemarin = Carbon::parse($tanggal)->subDay()->toDateString();
        $pasienAwal = PasienMasuk::whereDate('tanggal_masuk', '<=', $tanggalKemarin)
                        ->whereDoesntHave('pasienKeluar', function($q) use ($tanggalKemarin) {
                            $q->whereDate('tanggal_keluar', '<=', $tanggalKemarin);
                        })
                        ->with(['pasien', 'kamar'])
                        ->get();

        return view('sensus.index', compact(
            'pasienMasuk',
            'pasienBaru',
            'pasienPindahan',
            'pasienRujukan',      // ← Variabel ini sekarang dikirim
            'pasienKeluar',
            'pasienAwal',
            'tanggal'
        ));
    }

    public function print($tanggal)
    {
        // Data semua pasien masuk pada tanggal tertentu
        $pasienMasuk = PasienMasuk::with(['pasien', 'kamar'])
                        ->whereDate('tanggal_masuk', $tanggal)
                        ->get();

        // Pisahkan berdasarkan kategori
        $pasienBaru     = $pasienMasuk->where('cara_masuk', 'Pasien Baru');
        $pasienPindahan = $pasienMasuk->where('cara_masuk', 'Pindahan Ruangan');
        $pasienRujukan  = $pasienMasuk->where('cara_masuk', 'Rujukan');

        // Data pasien keluar
        $pasienKeluar = PasienKeluar::with(['pasien', 'kamar', 'kamarPindahan'])
                        ->whereDate('tanggal_keluar', $tanggal)
                        ->get();

        // Pasien Awal
        $tanggalKemarin = Carbon::parse($tanggal)->subDay()->toDateString();
        $pasienAwal = PasienMasuk::whereDate('tanggal_masuk', '<=', $tanggalKemarin)
                        ->whereDoesntHave('pasienKeluar', function($q) use ($tanggalKemarin) {
                            $q->whereDate('tanggal_keluar', '<=', $tanggalKemarin);
                        })
                        ->with(['pasien', 'kamar'])
                        ->get();

        return view('sensus.print', compact(
            'pasienMasuk',
            'pasienBaru',
            'pasienPindahan',
            'pasienRujukan',
            'pasienKeluar',
            'pasienAwal',
            'tanggal'
        ));
    }
}