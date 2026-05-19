<?php

namespace App\Http\Controllers;

use App\Models\Kamar;

class DashboardController extends Controller
{
    public function index()
    {
        $kamar          = Kamar::all();
        $totalKapasitas = $kamar->sum('kapasitas');  // total semua tempat tidur
        $terisi         = $kamar->sum('terisi');      // total terisi
        $tersedia       = $totalKapasitas - $terisi;  // total kosong

        return view('dashboard.index', compact('kamar', 'totalKapasitas', 'terisi', 'tersedia'));
    }
}