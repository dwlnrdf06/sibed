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
        $tempat_tidur = 100;

        $rekap = [];
        for ($hari = 1; $hari <= $jumlahHari; $hari++) {
            $tanggal = Carbon::createFromDate($tahun, $bulan, $hari)->toDateString();

            $data = Rekapitulasi::where('tanggal', $tanggal)->first();

            $jumlah_keluar = ($data->pasien_pulang_sembuh ?? 0) + ($data->pasien_pulang_paksa ?? 0) + ($data->meninggal_lt48 ?? 0) + ($data->meninggal_gte48 ?? 0) + ($data->dirujuk ?? 0);
            $hari_perawatan = $data->pasien_masih_dirawat ?? 0;

            $bor   = $tempat_tidur > 0 ? round(($hari_perawatan / $tempat_tidur) * 100, 2) : 0;
            $avlos = $jumlah_keluar > 0 ? round($hari_perawatan / $jumlah_keluar, 2) : 0;
            $bto   = round($jumlah_keluar / $tempat_tidur, 2);
            $toi   = $jumlah_keluar > 0 ? round(($tempat_tidur - $hari_perawatan) / $jumlah_keluar, 2) : 0;

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
                'jumlah_keluar'      => $jumlah_keluar,
                'masih_dirawat'      => $hari_perawatan,
                'bor'                => $bor,
                'avlos'              => $avlos,
                'bto'                => $bto,
                'toi'                => $toi,
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
        $tempat_tidur = 100;

        $rekap = [];
        for ($hari = 1; $hari <= $jumlahHari; $hari++) {
            $tanggal = Carbon::createFromDate($tahun, $bulan, $hari)->toDateString();
            $data    = Rekapitulasi::where('tanggal', $tanggal)->first();

            $jumlah_keluar = ($data->pasien_pulang_sembuh ?? 0) + ($data->pasien_pulang_paksa ?? 0) + ($data->meninggal_lt48 ?? 0) + ($data->meninggal_gte48 ?? 0) + ($data->dirujuk ?? 0);
            $hari_perawatan = $data->pasien_masih_dirawat ?? 0;

            $bor   = $tempat_tidur > 0 ? round(($hari_perawatan / $tempat_tidur) * 100, 2) : 0;
            $avlos = $jumlah_keluar > 0 ? round($hari_perawatan / $jumlah_keluar, 2) : 0;
            $bto   = round($jumlah_keluar / $tempat_tidur, 2);
            $toi   = $jumlah_keluar > 0 ? round(($tempat_tidur - $hari_perawatan) / $jumlah_keluar, 2) : 0;

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
                'jumlah_keluar'      => $jumlah_keluar,
                'masih_dirawat'      => $hari_perawatan,
                'bor'                => $bor,
                'avlos'              => $avlos,
                'bto'                => $bto,
                'toi'                => $toi,
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