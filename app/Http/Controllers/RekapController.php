<?php

namespace App\Http\Controllers;

use App\Models\Rekapitulasi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? Carbon::now()->month;
        $tahun = $request->tahun ?? Carbon::now()->year;

        $jumlahHari = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;

        $rekap = [];
        for ($hari = 1; $hari <= $jumlahHari; $hari++) {
            $tanggal = Carbon::createFromDate($tahun, $bulan, $hari)->toDateString();

            // ← Ambil dari tabel rekapitulasi ya (bukan sensus_harian)
            $data = Rekapitulasi::where('tanggal', $tanggal)->first();

            $rekap[] = [
                'tanggal'            => $hari,
                'pasien_awal'        => $data->pasien_awal ?? 0,
                'pasien_baru'        => $data->pasien_baru ?? 0,
                'pasien_pindahan'    => $data->pasien_pindahan ?? 0,
                'pasien_rujukan'     => $data->pasien_rujukan ?? 0,
                'jumlah_masuk'       => ($data->pasien_baru ?? 0) + ($data->pasien_pindahan ?? 0) + ($data->pasien_rujukan ?? 0),
                'pasien_dipindahkan' => $data->pasien_dipindahkan ?? 0,
                'pulang_sembuh'      => $data->pasien_pulang_sembuh ?? 0,
                'pulang_paksa'       => $data->pasien_pulang_paksa ?? 0,
                'melarikan_diri'     => 0,
                'meninggal_lt48'     => $data->meninggal_lt48 ?? 0,
                'meninggal_gte48'    => $data->meninggal_gte48 ?? 0,
                'dirujuk'            => $data->dirujuk ?? 0,
                'jumlah_keluar'      => ($data->pasien_pulang_sembuh ?? 0) + ($data->pasien_pulang_paksa ?? 0) + ($data->meninggal_lt48 ?? 0) + ($data->meninggal_gte48 ?? 0) + ($data->dirujuk ?? 0),
                'masih_dirawat'      => $data->pasien_masih_dirawat ?? 0,
                'bor'                => $data->bor ?? 0,
                'avlos'              => $data->avlos ?? 0,
                'bto'                => $data->bto ?? 0,
                'toi'                => $data->toi ?? 0,
            ];
        }

        $listBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $listTahun = range(2026, Carbon::now()->year + 5);

        return view('rekap.index', compact('rekap', 'bulan', 'tahun', 'listBulan', 'listTahun'));
    }

    public function print($bulan, $tahun)
    {
    $jumlahHari = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;

    $rekap = [];
    for ($hari = 1; $hari <= $jumlahHari; $hari++) {
        $tanggal = Carbon::createFromDate($tahun, $bulan, $hari)->toDateString();
        $data    = Rekapitulasi::where('tanggal', $tanggal)->first();

        $rekap[] = [
            'tanggal'            => $hari,
            'pasien_awal'        => $data->pasien_awal ?? 0,
            'pasien_baru'        => $data->pasien_baru ?? 0,
            'pasien_pindahan'    => $data->pasien_pindahan ?? 0,
            'pasien_rujukan'     => $data->pasien_rujukan ?? 0,
            'jumlah_masuk'       => ($data->pasien_baru ?? 0) + ($data->pasien_pindahan ?? 0) + ($data->pasien_rujukan ?? 0),
            'pasien_dipindahkan' => $data->pasien_dipindahkan ?? 0,
            'pulang_sembuh'      => $data->pasien_pulang_sembuh ?? 0,
            'pulang_paksa'       => $data->pasien_pulang_paksa ?? 0,
            'meninggal_lt48'     => $data->meninggal_lt48 ?? 0,
            'meninggal_gte48'    => $data->meninggal_gte48 ?? 0,
            'dirujuk'            => $data->dirujuk ?? 0,
            'jumlah_keluar'      => ($data->pasien_pulang_sembuh ?? 0) + ($data->pasien_pulang_paksa ?? 0) + ($data->meninggal_lt48 ?? 0) + ($data->meninggal_gte48 ?? 0) + ($data->dirujuk ?? 0),
            'masih_dirawat'      => $data->pasien_masih_dirawat ?? 0,
            'bor'                => $data->bor ?? 0,
            'avlos'              => $data->avlos ?? 0,
            'bto'                => $data->bto ?? 0,
            'toi'                => $data->toi ?? 0,
        ];
    }

    $listBulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
        4 => 'April', 5 => 'Mei', 6 => 'Juni',
        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
        10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];

    return view('rekap.print', compact('rekap', 'bulan', 'tahun', 'listBulan'));
    }
}