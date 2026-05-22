<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Print Sensus Harian - {{ $tanggal }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h5 {
            font-weight: bold;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: center;
        }

        th {
            background-color: #d0e4f7;
            font-weight: bold;
        }

        @media print {
            .no-print {
                display: none !important;
            }
            body {
                margin: 0;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }

    </style>

</head>

<body>

{{-- TOMBOL PRINT --}}
<div class="no-print mb-3 p-3 d-flex gap-2 align-items-center bg-light rounded shadow-sm">
    <a href="{{ route('sensus') }}" class="btn btn-outline-danger">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
    
    <button onclick="window.print()" class="btn btn-success fw-bold">
        <i class="bi bi-printer-fill me-2"></i> Print
    </button>
</div>

{{-- HEADER --}}
<div class="header">

    <h5>SENSUS HARIAN RAWAT INAP</h5>

    <h5>
        RUMAH SAKIT AKADEMIKA POLITEKNIK NEGERI JEMBER
    </h5>

    <p>
        <p style="font-size: 20px; font-weight: 500; margin-top: 5px;">
        Tanggal
        {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
        
    </p>

</div>

{{-- TABEL PASIEN MASUK --}}
<p><strong>PASIEN MASUK</strong></p>

<table>

    <thead>

        <tr>
            <th rowspan="2">NO</th>

            <th colspan="3">PASIEN AWAL</th>

            <th colspan="3">PASIEN BARU</th>

            <th colspan="4">PASIEN PINDAHAN</th>

            <th colspan="4">PASIEN RUJUKAN</th>
        </tr>

        <tr>

            <th>Nama</th>
            <th>No RM</th>
            <th>Kamar</th>

            <th>Nama</th>
            <th>No RM</th>
            <th>Kamar</th>

            <th>Nama</th>
            <th>No RM</th>
            <th>Kamar</th>
            <th>Dari</th>

            <th>Nama</th>
            <th>No RM</th>
            <th>Rujukan</th>
            <th>Kamar</th>

        </tr>

    </thead>

    <tbody>

        @php

            $maxRows = max(
                $pasienAwal->count(),
                $pasienMasuk->where('cara_masuk', 'Pasien Baru')->count(),
                $pasienMasuk->where('cara_masuk', 'Pindahan Ruangan')->count(),
                $pasienMasuk->where('cara_masuk', 'Rujukan')->count(),
                1
            );

            $awal     = $pasienAwal->values();

            $baru     = $pasienMasuk->where('cara_masuk', 'Pasien Baru')->values();

            $pindahan = $pasienMasuk->where('cara_masuk', 'Pindahan Ruangan')->values();

            $rujukan  = $pasienMasuk->where('cara_masuk', 'Rujukan')->values();

        @endphp

        @for($i = 0; $i < $maxRows; $i++)

        <tr>

            <td>{{ $i + 1 }}</td>

            <td>{{ isset($awal[$i]) ? $awal[$i]->pasien->nama_pasien : '' }}</td>
            <td>{{ isset($awal[$i]) ? $awal[$i]->pasien->no_rm : '' }}</td>
            <td>{{ isset($awal[$i]) ? $awal[$i]->kamar->nama_kamar : '' }}</td>

            <td>{{ isset($baru[$i]) ? $baru[$i]->pasien->nama_pasien : '' }}</td>
            <td>{{ isset($baru[$i]) ? $baru[$i]->pasien->no_rm : '' }}</td>
            <td>{{ isset($baru[$i]) ? $baru[$i]->kamar->nama_kamar : '' }}</td>

            <td>{{ isset($pindahan[$i]) ? $pindahan[$i]->pasien->nama_pasien : '' }}</td>
            <td>{{ isset($pindahan[$i]) ? $pindahan[$i]->pasien->no_rm : '' }}</td>
            <td>{{ isset($pindahan[$i]) ? $pindahan[$i]->kamar->nama_kamar : '' }}</td>
            <td>{{ isset($pindahan[$i]) ? $pindahan[$i]->rujukan_dari : '' }}</td>

            <td>{{ isset($rujukan[$i]) ? $rujukan[$i]->pasien->nama_pasien : '' }}</td>
            <td>{{ isset($rujukan[$i]) ? $rujukan[$i]->pasien->no_rm : '' }}</td>
            <td>{{ isset($rujukan[$i]) ? $rujukan[$i]->rujukan_dari : '' }}</td>
            <td>{{ isset($rujukan[$i]) ? $rujukan[$i]->kamar->nama_kamar : '' }}</td>

        </tr>

        @endfor

    </tbody>

</table>

<br>

{{-- TABEL PASIEN KELUAR --}}
<p><strong>PASIEN KELUAR</strong></p>

<table>

    <thead>

        <tr>

            <th rowspan="3">NO</th>

            <th colspan="4">DIPINDAHKAN</th>

            <th colspan="9">KELUAR RUMAH SAKIT</th>

            <th rowspan="3">Lama Dirawat</th>

            <th rowspan="3">Hari Perawatan</th>

        </tr>

        <tr>

            <th rowspan="2">Nama</th>
            <th rowspan="2">No RM</th>
            <th rowspan="2">Kelas</th>
            <th rowspan="2">Ke Kamar</th>

            <th rowspan="2">Nama</th>
            <th rowspan="2">No RM</th>
            <th rowspan="2">Nama Kamar</th>
            <th rowspan="2">Tgl Masuk</th>

            <th colspan="5">Cara Keluar</th>

        </tr>

        <tr>

            <th>Dirujuk</th>
            <th>Pulang</th>
            <th>Paksa</th>
            <th>&lt;48 Jam</th>
            <th>≥48 Jam</th>

        </tr>

    </thead>

    <tbody>

        @forelse($pasienKeluar as $i => $pk)

        <tr>

            <td>{{ $i + 1 }}</td>

            <td>{{ $pk->cara_keluar == 'Dipindahkan' ? $pk->pasien->nama_pasien : '' }}</td>

            <td>{{ $pk->cara_keluar == 'Dipindahkan' ? $pk->pasien->no_rm : '' }}</td>

            <td>{{ $pk->cara_keluar == 'Dipindahkan' ? $pk->kamar->kelas_kamar : '' }}</td>

            <td>{{ $pk->cara_keluar == 'Dipindahkan' ? ($pk->kamarPindahan->nama_kamar ?? '-') : '' }}</td>

            <td>{{ $pk->cara_keluar != 'Dipindahkan' ? $pk->pasien->nama_pasien : '' }}</td>

            <td>{{ $pk->cara_keluar != 'Dipindahkan' ? $pk->pasien->no_rm : '' }}</td>

            <td>{{ $pk->cara_keluar != 'Dipindahkan' ? $pk->kamar->nama_kamar : '' }}</td>

            <td>{{ $pk->tanggal_masuk }}</td>

            <td>{{ $pk->cara_keluar == 'Dirujuk' ? $pk->dirujuk_ke : '' }}</td>

            <td>{{ $pk->cara_keluar == 'Sembuh' ? '✓' : '' }}</td>

            <td>{{ $pk->cara_keluar == 'Pulang Paksa' ? '✓' : '' }}</td>

            <td>{{ $pk->cara_keluar == 'Meninggal < 48 Jam' ? '✓' : '' }}</td>

            <td>{{ $pk->cara_keluar == 'Meninggal >= 48 Jam' ? '✓' : '' }}</td>

            <td>{{ $pk->lama_dirawat }}</td>

            <td>{{ $pk->hari_perawatan }}</td>

        </tr>

        @empty

        <tr>
            <td colspan="16">
                Belum ada data
            </td>
        </tr>

        @endforelse

    </tbody>

</table>

{{-- TANDA TANGAN --}}
<div style="width:100%; margin-top:40px;">

    <table style="width:100%; border:none;">

        <tr style="border:none;">

            {{-- KIRI --}}
            <td style="width:50%; border:none; text-align:center;">

                Mengetahui,<br>
                <strong>PMIK</strong>

                <br><br><br><br>

                (........................................)

            </td>

            {{-- KANAN --}}
            <td style="width:50%; border:none; text-align:center;">

                Mengetahui,<br>
                <strong>Perawat</strong>

                <br><br><br><br>

                (........................................)

            </td>

        </tr>

    </table>

</div>

</body>
</html>