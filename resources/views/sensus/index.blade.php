@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h4 style="font-weight: bold; color: #333; margin-bottom: 5px;">
        <i class="bi bi-clipboard2-pulse menu-icon" style="color:black;"></i>
        Sensus Harian Rawat Inap
    </h4>

    {{-- FILTER TANGGAL --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('sensus') }}" method="GET" class="row align-items-end">
                
                <div class="col-md-4">
                    <label class="form-label fw-bold">
                        Pilih Tanggal:
                    </label>

                    <input 
                        type="date"
                        name="tanggal"
                        class="form-control"
                        value="{{ $tanggal }}"
                    >
                </div>

                <div class="col-md-auto mt-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Tampilkan
                    </button>

                    <a href="{{ route('sensus') }}" class="btn btn-secondary">
                        Hari Ini
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- ================= PASIEN MASUK ================= --}}
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

                            <th colspan="3" style="font-weight: bold;">
                                PASIEN AWAL
                            </th>

                            <th colspan="3" style="font-weight: bold;">
                                PASIEN BARU
                            </th>

                            <th colspan="4" style="font-weight: bold;">
                                PASIEN PINDAHAN
                            </th>

                            <th colspan="4" style="font-weight: bold;">
                                PASIEN RUJUKAN
                            </th>
                        </tr>

                        <tr>

                            {{-- PASIEN AWAL --}}
                            <th>Nama</th>
                            <th>No RM</th>
                            <th>Nama Kamar</th>

                            {{-- PASIEN BARU --}}
                            <th>Nama</th>
                            <th>No RM</th>
                            <th>Nama Kamar</th>

                            {{-- PASIEN PINDAHAN --}}
                            <th>Nama</th>
                            <th>No RM</th>
                            <th>Nama Kamar</th>
                            <th>Dari</th>

                            {{-- PASIEN RUJUKAN --}}
                            <th>Nama</th>
                            <th>No RM</th>
                            <th>Rujukan Dari</th>
                            <th>Nama Kamar</th>

                        </tr>

                    </thead>

                    <tbody>

                        @php
                            $awal     = $pasienAwal->values();

                            $baru     = $pasienMasuk
                                            ->where('cara_masuk', 'Pasien Baru')
                                            ->values();

                            $pindahan = $pasienMasuk
                                            ->where('cara_masuk', 'Pindahan Ruangan')
                                            ->values();

                            $rujukan  = $pasienMasuk
                                            ->where('cara_masuk', 'Rujukan')
                                            ->values();

                            $maxRows = max(
                                $awal->count(),
                                $baru->count(),
                                $pindahan->count(),
                                $rujukan->count()
                            );
                        @endphp

                        @if($maxRows == 0)

                            <tr>
                                <td colspan="15" class="text-center text-muted py-4">
                                    Belum ada data pasien masuk
                                </td>
                            </tr>

                        @else

                            @for($i = 0; $i < $maxRows; $i++)

                            <tr>

                                <td>{{ $i + 1 }}</td>

                                {{-- PASIEN AWAL --}}
                                <td>{{ $awal[$i]->pasien->nama_pasien ?? '' }}</td>

                                <td>{{ $awal[$i]->pasien->no_rm ?? '' }}</td>

                                <td>{{ $awal[$i]->kamar->nama_kamar ?? '' }}</td>

                                {{-- PASIEN BARU --}}
                                <td>{{ $baru[$i]->pasien->nama_pasien ?? '' }}</td>

                                <td>{{ $baru[$i]->pasien->no_rm ?? '' }}</td>

                                <td>{{ $baru[$i]->kamar->nama_kamar ?? '' }}</td>

                                {{-- PASIEN PINDAHAN --}}
                                <td>{{ $pindahan[$i]->pasien->nama_pasien ?? '' }}</td>

                                <td>{{ $pindahan[$i]->pasien->no_rm ?? '' }}</td>

                                <td>{{ $pindahan[$i]->kamar->nama_kamar ?? '' }}</td>

                                <td>{{ $pindahan[$i]->pindahan_dari ?? '-' }}</td>

                                {{-- PASIEN RUJUKAN --}}
                                <td>{{ $rujukan[$i]->pasien->nama_pasien ?? '' }}</td>

                                <td>{{ $rujukan[$i]->pasien->no_rm ?? '' }}</td>

                                <td>{{ $rujukan[$i]->rujukan_dari ?? '-' }}</td>

                                <td>{{ $rujukan[$i]->kamar->nama_kamar ?? '' }}</td>

                            </tr>

                            @endfor

                        @endif

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- ================= PASIEN KELUAR ================= --}}
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

                            <th colspan="4" style="font-weight: bold;">
                                DIPINDAHKAN
                            </th>

                            <th colspan="9" style="font-weight: bold;">
                                KELUAR RUMAH SAKIT
                            </th>

                            <th rowspan="3" style="font-weight: bold;">LD</th>

                            <th rowspan="3" style="font-weight: bold;">HP</th>

                        </tr>

                        <tr>

                            {{-- DIPINDAHKAN --}}
                            <th rowspan="2">Nama</th>
                            <th rowspan="2">No RM</th>
                            <th rowspan="2">Kelas</th>
                            <th rowspan="2">Ke Kamar</th>

                            {{-- KELUAR RS --}}
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

                        @php
                            $maxKeluar = max(
                                $pindahanKeluar->count(),
                                $pasienKeluar->count()
                            );
                        @endphp

                        @if($maxKeluar == 0)

                            <tr>
                                <td colspan="16" class="text-center text-muted py-4">
                                    Belum ada data pasien keluar
                                </td>
                            </tr>

                        @else

                            @for($i = 0; $i < $maxKeluar; $i++)

                            @php
                                $pindah = $pindahanKeluar[$i] ?? null;
                                $keluar = $pasienKeluar[$i] ?? null;
                            @endphp

                            <tr>

                                <td>{{ $i + 1 }}</td>

                                {{-- ================= DIPINDAHKAN ================= --}}
                                <td>{{ $pindah->nama_pasien ?? '' }}</td>

                                <td>{{ $pindah->no_rm ?? '' }}</td>

                                <td>{{ $pindah->dari_kamar ?? '' }}</td>

                                <td>{{ $pindah->ke_kamar ?? '' }}</td>

                                {{-- ================= KELUAR RS ================= --}}
                                <td>
                                    {{ ($keluar && $keluar->cara_keluar != 'Dipindahkan') ? $keluar->pasien->nama_pasien : '' }}
                                </td>

                                <td>
                                    {{ ($keluar && $keluar->cara_keluar != 'Dipindahkan') ? $keluar->pasien->no_rm : '' }}
                                </td>

                                <td>
                                    {{ ($keluar && $keluar->cara_keluar != 'Dipindahkan') ? $keluar->kamar->nama_kamar : '' }}
                                </td>

                                <td>
                                    {{ ($keluar && $keluar->cara_keluar != 'Dipindahkan') ? $keluar->tanggal_masuk : '' }}
                                </td>

                                <td>
                                    {{ ($keluar && $keluar->cara_keluar == 'Dirujuk') ? $keluar->dirujuk_ke : '' }}
                                </td>

                                <td>
                                    {{ ($keluar && $keluar->cara_keluar == 'Sembuh') ? '✓' : '' }}
                                </td>

                                <td>
                                    {{ ($keluar && $keluar->cara_keluar == 'Pulang Paksa') ? '✓' : '' }}
                                </td>

                                <td>
                                    {{ ($keluar && $keluar->cara_keluar == 'Meninggal < 48 Jam') ? '✓' : '' }}
                                </td>

                                <td>
                                    {{ ($keluar && $keluar->cara_keluar == 'Meninggal >= 48 Jam') ? '✓' : '' }}
                                </td>

                                <td>{{ $keluar->lama_dirawat ?? '' }}</td>

                                <td>{{ $keluar->hari_perawatan ?? '' }}</td>

                            </tr>

                            @endfor

                        @endif

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- PRINT --}}
    <div class="col-12 mt-3 d-flex justify-content-end">

        <a 
            href="{{ route('sensus.print', $tanggal) }}"
            target="_blank"
            class="btn btn-success fw-bold px-4"
        >
            <i class="bi bi-printer-fill me-2"></i>
            Print
        </a>

    </div>

</div>
@endsection