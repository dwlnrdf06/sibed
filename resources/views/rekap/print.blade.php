<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Print Rekapitulasi - {{ $listBulan[$bulan] }} {{ $tahun }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h5 { font-weight: bold; margin: 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 3px 5px; text-align: center; }
        th { background-color: #d0e4f7; font-weight: bold; }
        tr.total { background-color: #fff3cd; font-weight: bold; }
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>

{{-- TOMBOL PRINT --}}
<div class="no-print mb-3 p-3">
    <button onclick="window.print()" class="btn btn-success">🖨️ Print</button>
    <a href="{{ route('rekap') }}" class="btn btn-danger">← Kembali</a>
</div>

{{-- HEADER --}}
<div class="header">
    <h5>REKAPITULASI SENSUS HARIAN RAWAT INAP</h5>
    <h5>RUMAH SAKIT AKADEMIKA POLITEKNIK NEGERI JEMBER</h5>
    <p>Bulan: {{ $listBulan[$bulan] }} {{ $tahun }}</p>
</div>

{{-- TABEL --}}
<table>
    <thead>
        <tr>
            <th rowspan="2">Tgl</th>
            <th rowspan="2">Pasien Awal</th>
            <th rowspan="2">Pasien Baru</th>
            <th rowspan="2">Pindahan</th>
            <th rowspan="2">Rujukan</th>
            <th rowspan="2">Jml Masuk</th>
            <th rowspan="2">Dipindahkan</th>
            <th colspan="3">Jumlah Pulang</th>
            <th colspan="2">Meninggal</th>
            <th rowspan="2">Dirujuk</th>
            <th rowspan="2">Jml Keluar</th>
            <th rowspan="2">Masih Dirawat</th>
            <th rowspan="2">BOR</th>
            <th rowspan="2">AVLOS</th>
            <th rowspan="2">BTO</th>
            <th rowspan="2">TOI</th>
        </tr>
        <tr>
            <th>Sembuh</th>
            <th>Paksa</th>
            <th>Kabur</th>
            <th>&lt;48</th>
            <th>≥48</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rekap as $r)
        <tr>
            <td>{{ $r['tanggal'] }}</td>
            <td>{{ $r['pasien_awal'] ?: 0 }}</td>
            <td>{{ $r['pasien_baru'] ?: 0 }}</td>
            <td>{{ $r['pasien_pindahan'] ?: 0 }}</td>
            <td>{{ $r['pasien_rujukan'] ?: 0 }}</td>
            <td>{{ $r['jumlah_masuk'] ?: 0 }}</td>
            <td>{{ $r['pasien_dipindahkan'] ?: 0 }}</td>
            <td>{{ $r['pulang_sembuh'] ?: 0 }}</td>
            <td>{{ $r['pulang_paksa'] ?: 0 }}</td>
            <td>-</td>
            <td>{{ $r['meninggal_lt48'] ?: 0 }}</td>
            <td>{{ $r['meninggal_gte48'] ?: 0 }}</td>
            <td>{{ $r['dirujuk'] ?: 0 }}</td>
            <td>{{ $r['jumlah_keluar'] ?: 0 }}</td>
            <td>{{ $r['masih_dirawat'] ?: 0 }}</td>
            <td>{{ $r['bor'] ? $r['bor'].'%' : 0 }}</td>
            <td>{{ $r['avlos'] ?: 0 }}</td>
            <td>{{ $r['bto'] ?: 0 }}</td>
            <td>{{ $r['toi'] ?: 0 }}</td>
        </tr>
        @endforeach

        {{-- BARIS TOTAL --}}
        <tr class="total">
            <td>Total</td>
            <td>{{ collect($rekap)->sum('pasien_awal') }}</td>
            <td>{{ collect($rekap)->sum('pasien_baru') }}</td>
            <td>{{ collect($rekap)->sum('pasien_pindahan') }}</td>
            <td>{{ collect($rekap)->sum('pasien_rujukan') }}</td>
            <td>{{ collect($rekap)->sum('jumlah_masuk') }}</td>
            <td>{{ collect($rekap)->sum('pasien_dipindahkan') }}</td>
            <td>{{ collect($rekap)->sum('pulang_sembuh') }}</td>
            <td>{{ collect($rekap)->sum('pulang_paksa') }}</td>
            <td>-</td>
            <td>{{ collect($rekap)->sum('meninggal_lt48') }}</td>
            <td>{{ collect($rekap)->sum('meninggal_gte48') }}</td>
            <td>{{ collect($rekap)->sum('dirujuk') }}</td>
            <td>{{ collect($rekap)->sum('jumlah_keluar') }}</td>
            <td>{{ collect($rekap)->last()['masih_dirawat'] }}</td>
            <td>{{ round(collect($rekap)->avg('bor'), 2) }}%</td>
            <td>{{ round(collect($rekap)->avg('avlos'), 2) }}</td>
            <td>{{ round(collect($rekap)->avg('bto'), 2) }}</td>
            <td>{{ round(collect($rekap)->avg('toi'), 2) }}</td>
        </tr>
    </tbody>
</table>

</body>
</html>