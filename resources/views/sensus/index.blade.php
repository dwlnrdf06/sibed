@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Sensus Harian Rawat Inap</h4>

    {{-- FILTER TANGGAL --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('sensus') }}" method="GET" class="row align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Pilih Tanggal:</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}">
                </div>
                <div class="col-md-auto mt-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                    <a href="{{ route('sensus') }}" class="btn btn-secondary">Hari Ini</a>
                </div>
            </form>
        </div>
    </div>

    {{-- TABEL PASIEN MASUK --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white text-center fw-bold">
            PASIEN MASUK - {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-sm text-center align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th rowspan="2" style="font-weight: bold;">NO</th>
                            <th colspan="3" style="font-weight: bold;">PASIEN AWAL</th>
                            <th colspan="3" style="font-weight: bold;">PASIEN BARU</th>
                            <th colspan="4" style="font-weight: bold;">PASIEN PINDAHAN</th>
                            <th colspan="4" style="font-weight: bold;">PASIEN RUJUKAN</th>
                        </tr>
                        <tr>
                            <th style="font-weight: normal;">Nama</th>
                            <th style="font-weight: normal;">No RM</th>
                            <th style="font-weight: normal;">Nama Kamar</th>
                            <th style="font-weight: normal;">Nama</th>
                            <th style="font-weight: normal;">No RM</th>
                            <th style="font-weight: normal;">Nama Kamar</th>
                            <th style="font-weight: normal;">Nama</th>
                            <th style="font-weight: normal;">No RM</th>
                            <th style="font-weight: normal;">Nama Kamar</th>
                            <th style="font-weight: normal;">Dari</th>
                            <th style="font-weight: normal;">Nama</th>
                            <th style="font-weight: normal;">No RM</th>
                            <th style="font-weight: normal;">Rujukan</th>
                            <th style="font-weight: normal;">Nama Kamar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $awal     = $pasienAwal->values();
                            $baru     = $pasienMasuk->where('cara_masuk', 'Pasien Baru')->values();
                            $pindahan = $pasienMasuk->where('cara_masuk', 'Pindahan Ruangan')->values();
                            $rujukan  = $pasienMasuk->where('cara_masuk', 'Rujukan')->values();

                            // ← Hapus angka 1, jadi 0 kalau tidak ada data
                            $maxRows = max(
                                $awal->count(),
                                $baru->count(),
                                $pindahan->count(),
                                $rujukan->count()
                            );
                        @endphp

                        {{-- ← Kalau tidak ada data tampil pesan --}}
                        @if($maxRows == 0)
                        <tr>
                            <td colspan="15" class="text-center text-muted fst-italic">Belum ada data</td>
                        </tr>
                        @else
                        @for($i = 0; $i < $maxRows; $i++)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            {{-- Pasien Awal --}}
                            <td>{{ isset($awal[$i]) ? $awal[$i]->pasien->nama_pasien : '' }}</td>
                            <td>{{ isset($awal[$i]) ? $awal[$i]->pasien->no_rm : '' }}</td>
                            <td>{{ isset($awal[$i]) ? $awal[$i]->kamar->nama_kamar : '' }}</td>
                            {{-- Pasien Baru --}}
                            <td>{{ isset($baru[$i]) ? $baru[$i]->pasien->nama_pasien : '' }}</td>
                            <td>{{ isset($baru[$i]) ? $baru[$i]->pasien->no_rm : '' }}</td>
                            <td>{{ isset($baru[$i]) ? $baru[$i]->kamar->nama_kamar : '' }}</td>
                            {{-- Pasien Pindahan --}}
                            <td>{{ isset($pindahan[$i]) ? $pindahan[$i]->pasien->nama_pasien : '' }}</td>
                            <td>{{ isset($pindahan[$i]) ? $pindahan[$i]->pasien->no_rm : '' }}</td>
                            <td>{{ isset($pindahan[$i]) ? $pindahan[$i]->kamar->nama_kamar : '' }}</td>
                            <td>{{ isset($pindahan[$i]) ? $pindahan[$i]->rujukan_dari : '' }}</td>
                            {{-- Pasien Rujukan --}}
                            <td>{{ isset($rujukan[$i]) ? $rujukan[$i]->pasien->nama_pasien : '' }}</td>
                            <td>{{ isset($rujukan[$i]) ? $rujukan[$i]->pasien->no_rm : '' }}</td>
                            <td>{{ isset($rujukan[$i]) ? $rujukan[$i]->rujukan_dari : '' }}</td>
                            <td>{{ isset($rujukan[$i]) ? $rujukan[$i]->kamar->nama_kamar : '' }}</td>
                        </tr>
                        @endfor
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- TABEL PASIEN KELUAR --}}
    <div class="card shadow-sm">
        <div class="card-header bg-danger text-white text-center fw-bold">
            PASIEN KELUAR - {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-sm text-center align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th rowspan="3" style="font-weight: bold;">NO</th>
                            <th colspan="4" style="font-weight: bold;">DIPINDAHKAN</th>
                            <th colspan="9" style="font-weight: bold;">KELUAR RUMAH SAKIT</th>
                            <th rowspan="3" style="font-weight: bold;">LD</th>
                            <th rowspan="3" style="font-weight: bold;">HP</th>
                        </tr>
                        <tr>
                            <th rowspan="2" style="font-weight: normal;">Nama</th>
                            <th rowspan="2" style="font-weight: normal;">No RM</th>
                            <th rowspan="2" style="font-weight: normal;">Kelas</th>
                            <th rowspan="2" style="font-weight: normal;">Ke Kamar</th>
                            <th rowspan="2" style="font-weight: normal;">Nama</th>
                            <th rowspan="2" style="font-weight: normal;">No RM</th>
                            <th rowspan="2" style="font-weight: normal;">Nama Kamar</th>
                            <th rowspan="2" style="font-weight: normal;">Tgl Masuk</th>
                            <th colspan="5" style="font-weight: normal;">Cara Keluar</th>
                        </tr>
                        <tr>
                            <th style="font-weight: normal;">Dirujuk</th>
                            <th style="font-weight: normal;">Pulang</th>
                            <th style="font-weight: normal;">Paksa</th>
                            <th style="font-weight: normal;">&lt;48 Jam</th>
                            <th style="font-weight: normal;">≥48 Jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse($pasienKeluar as $pk)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $pk->cara_keluar == 'Dipindahkan' ? $pk->pasien->nama_pasien : '' }}</td>
                            <td>{{ $pk->cara_keluar == 'Dipindahkan' ? $pk->pasien->no_rm : '' }}</td>
                            <td>{{ $pk->cara_keluar == 'Dipindahkan' ? $pk->kamar->kelas_kamar : '' }}</td>
                            <td>{{ $pk->cara_keluar == 'Dipindahkan' ? ($pk->kamarPindahan->nama_kamar ?? '-') : '' }}</td>
                            <td>{{ $pk->cara_keluar != 'Dipindahkan' ? $pk->pasien->nama_pasien : '' }}</td>
                            <td>{{ $pk->cara_keluar != 'Dipindahkan' ? $pk->pasien->no_rm : '' }}</td>
                            <td>{{ $pk->cara_keluar != 'Dipindahkan' ? $pk->kamar->nama_kamar : '' }}</td>
                            <td>{{ $pk->tanggal_masuk }}</td>
                            <td>{{ $pk->cara_keluar == 'Dirujuk' ? '✓' : '' }}</td>
                            <td>{{ $pk->cara_keluar == 'Sembuh' ? '✓' : '' }}</td>
                            <td>{{ $pk->cara_keluar == 'Pulang Paksa' ? '✓' : '' }}</td>
                            <td>{{ $pk->cara_keluar == 'Meninggal < 48 Jam' ? '✓' : '' }}</td>
                            <td>{{ $pk->cara_keluar == 'Meninggal >= 48 Jam' ? '✓' : '' }}</td>
                            <td>{{ $pk->lama_dirawat }}</td>
                            <td>{{ $pk->hari_perawatan }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="16" class="text-center text-muted fst-italic">Belum ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12 mt-2 mb-3 d-flex justify-content-end">
        <a href="{{ route('sensus.print', $tanggal) }}"
            target="_blank"
            class="btn text-white fw-bold px-4"
            style="background-color: #28a745; border: none;">
            🖨️ Print
        </a>
    </div>


</div>
@endsection