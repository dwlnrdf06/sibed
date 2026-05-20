<?php

namespace App\Http\Controllers;

use App\Models\Rekapitulasi;
use App\Models\PasienMasuk;
use App\Models\PasienKeluar;
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

            // Hitung pasien awal secara dinamis
            $tanggalKemarin = Carbon::parse($tanggal)->subDay()->toDateString();
            $pasienAwal = PasienMasuk::whereDate('tanggal_masuk', '<=', $tanggalKemarin)
                ->whereDoesntHave('pasienKeluar', function($q) use ($tanggalKemarin) {
                    $q->whereDate('tanggal_keluar', '<=', $tanggalKemarin);
                })
                ->count();

            // Hitung masih dirawat secara dinamis
            $masihDirawat = PasienMasuk::whereDate('tanggal_masuk', '<=', $tanggal)
                ->whereDoesntHave('pasienKeluar', function($q) use ($tanggal) {
                    $q->whereDate('tanggal_keluar', '<=', $tanggal);
                })
                ->count();

            // Hitung pasien masuk hari ini
            $masukHariIni   = PasienMasuk::whereDate('tanggal_masuk', $tanggal)->get();
            $pasienBaru     = $masukHariIni->where('cara_masuk', 'Pasien Baru')->count();
            $pasienPindahan = $masukHariIni->where('cara_masuk', 'Pindahan Ruangan')->count();
            $pasienRujukan  = $masukHariIni->where('cara_masuk', 'Rujukan')->count();

            // Hitung pasien keluar hari ini
            $keluarHariIni  = PasienKeluar::whereDate('tanggal_keluar', $tanggal)->get();
            $sembuh         = $keluarHariIni->where('cara_keluar', 'Sembuh')->count();
            $pulangPaksa    = $keluarHariIni->where('cara_keluar', 'Pulang Paksa')->count();
            $dirujuk        = $keluarHariIni->where('cara_keluar', 'Dirujuk')->count();
            $dipindahkan    = $keluarHariIni->where('cara_keluar', 'Dipindahkan')->count();
            $meninggalLt48  = $keluarHariIni->where('cara_keluar', 'Meninggal < 48 Jam')->count();
            $meninggalGte48 = $keluarHariIni->where('cara_keluar', 'Meninggal >= 48 Jam')->count();
            $jumlah_keluar  = $sembuh + $pulangPaksa + $dirujuk + $meninggalLt48 + $meninggalGte48;

            $bor   = $tempat_tidur > 0 ? round(($masihDirawat / $tempat_tidur) * 100, 2) : 0;
            $avlos = $jumlah_keluar > 0 ? round($masihDirawat / $jumlah_keluar, 2) : 0;
            $bto   = round($jumlah_keluar / $tempat_tidur, 2);
            $toi   = $jumlah_keluar > 0 ? round(($tempat_tidur - $masihDirawat) / $jumlah_keluar, 2) : 0;

            $rekap[] = [
                'tanggal'            => $hari,
                'pasien_awal'        => $pasienAwal,
                'pasien_baru'        => $pasienBaru,
                'pasien_pindahan'    => $pasienPindahan,
                'pasien_rujukan'     => $pasienRujukan,
                'jumlah_masuk'       => $pasienBaru + $pasienPindahan + $pasienRujukan,
                'pasien_dipindahkan' => $dipindahkan,
                'pulang_sembuh'      => $sembuh,
                'pulang_paksa'       => $pulangPaksa,
                'melarikan_diri'     => 0,
                'meninggal_lt48'     => $meninggalLt48,
                'meninggal_gte48'    => $meninggalGte48,
                'dirujuk'            => $dirujuk,
                'jumlah_keluar'      => $jumlah_keluar,
                'masih_dirawat'      => $masihDirawat,
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

            // Hitung pasien awal secara dinamis
            $tanggalKemarin = Carbon::parse($tanggal)->subDay()->toDateString();
            $pasienAwal = PasienMasuk::whereDate('tanggal_masuk', '<=', $tanggalKemarin)
                ->whereDoesntHave('pasienKeluar', function($q) use ($tanggalKemarin) {
                    $q->whereDate('tanggal_keluar', '<=', $tanggalKemarin);
                })
                ->count();

            // Hitung masih dirawat secara dinamis
            $masihDirawat = PasienMasuk::whereDate('tanggal_masuk', '<=', $tanggal)
                ->whereDoesntHave('pasienKeluar', function($q) use ($tanggal) {
                    $q->whereDate('tanggal_keluar', '<=', $tanggal);
                })
                ->count();

            // Hitung pasien masuk hari ini
            $masukHariIni   = PasienMasuk::whereDate('tanggal_masuk', $tanggal)->get();
            $pasienBaru     = $masukHariIni->where('cara_masuk', 'Pasien Baru')->count();
            $pasienPindahan = $masukHariIni->where('cara_masuk', 'Pindahan Ruangan')->count();
            $pasienRujukan  = $masukHariIni->where('cara_masuk', 'Rujukan')->count();

            // Hitung pasien keluar hari ini
            $keluarHariIni  = PasienKeluar::whereDate('tanggal_keluar', $tanggal)->get();
            $sembuh         = $keluarHariIni->where('cara_keluar', 'Sembuh')->count();
            $pulangPaksa    = $keluarHariIni->where('cara_keluar', 'Pulang Paksa')->count();
            $dirujuk        = $keluarHariIni->where('cara_keluar', 'Dirujuk')->count();
            $dipindahkan    = $keluarHariIni->where('cara_keluar', 'Dipindahkan')->count();
            $meninggalLt48  = $keluarHariIni->where('cara_keluar', 'Meninggal < 48 Jam')->count();
            $meninggalGte48 = $keluarHariIni->where('cara_keluar', 'Meninggal >= 48 Jam')->count();
            $jumlah_keluar  = $sembuh + $pulangPaksa + $dirujuk + $meninggalLt48 + $meninggalGte48;

            $bor   = $tempat_tidur > 0 ? round(($masihDirawat / $tempat_tidur) * 100, 2) : 0;
            $avlos = $jumlah_keluar > 0 ? round($masihDirawat / $jumlah_keluar, 2) : 0;
            $bto   = round($jumlah_keluar / $tempat_tidur, 2);
            $toi   = $jumlah_keluar > 0 ? round(($tempat_tidur - $masihDirawat) / $jumlah_keluar, 2) : 0;

            $rekap[] = [
                'tanggal'            => $hari,
                'pasien_awal'        => $pasienAwal,
                'pasien_baru'        => $pasienBaru,
                'pasien_pindahan'    => $pasienPindahan,
                'pasien_rujukan'     => $pasienRujukan,
                'jumlah_masuk'       => $pasienBaru + $pasienPindahan + $pasienRujukan,
                'pasien_dipindahkan' => $dipindahkan,
                'pulang_sembuh'      => $sembuh,
                'pulang_paksa'       => $pulangPaksa,
                'meninggal_lt48'     => $meninggalLt48,
                'meninggal_gte48'    => $meninggalGte48,
                'dirujuk'            => $dirujuk,
                'jumlah_keluar'      => $jumlah_keluar,
                'masih_dirawat'      => $masihDirawat,
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