@extends('layouts.app')

@section('content')
<h4 style="font-weight: bold; color: #333; margin-bottom: 5px;">
    <i class="bi bi-bar-chart-line menu-icon" style="color:black;"></i>
    Rekapitulasi Rawat Inap
</h4>

{{-- FILTER BULAN & TAHUN --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('rekap') }}" method="GET" class="row align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-bold">Bulan:</label>
                <select name="bulan" class="form-select">
                    @foreach($listBulan as $num => $nama)
                        <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>
                            {{ $nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold">Tahun:</label>
                <select name="tahun" class="form-select">
                    @foreach($listTahun as $thn)
                        <option value="{{ $thn }}" {{ $tahun == $thn ? 'selected' : '' }}>
                            {{ $thn }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 mt-2">
                <button type="submit" class="btn btn-primary mt-3">Tampilkan</button>
            </div>
        </form>
    </div>
</div>

{{-- GRAFIK LINE CHART --}}
<div class="card shadow-sm mb-4">
    <div class="card-header fw-bold">GRAFIK BOR, AVLOS, BTO, TOI</div>
    <div class="card-body">
        <canvas id="lineChartRekap" height="80"></canvas>
    </div>
</div>

{{-- TABEL REKAPITULASI --}}
<div class="table-responsive mt-3">
    <table class="table table-bordered table-striped" style="font-size: 12px; text-align: center; vertical-align: middle;">
        <thead class="table-primary" style="text-align: center; vertical-align: middle;">
            <tr>
                <th rowspan="2">Tgl</th>
                <th rowspan="2">Pasien Awal</th>
                <th rowspan="2">Pasien Baru</th>
                <th rowspan="2">Pasien Pindahan</th>
                <th rowspan="2">Pasien Rujukan</th>
                <th rowspan="2">Jml Masuk</th>
                <th rowspan="2">Dipindahkan</th>
                <th colspan="3">Jumlah Pulang</th>
                <th colspan="2">Meninggal</th>
                <th rowspan="2">Dirujuk</th>
                <th rowspan="2">Jml Keluar</th>
                <th rowspan="2">Masih Dirawat</th>
                <th rowspan="2">Jml LD</th>
                <th rowspan="2">Jml HP</th>
                <th rowspan="2">BOR</th>
                <th rowspan="2">AVLOS</th>
                <th rowspan="2">BTO</th>
                <th rowspan="2">TOI</th>
            </tr>
            <tr>
                <th>Sembuh</th>
                <th>Paksa</th>
                <th>Kabur</th>
                <th>&lt;48 Jam</th>
                <th>≥48 Jam</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekap as $r)
            <tr class="{{ ($r['pasien_baru'] + $r['pasien_pindahan'] + $r['pasien_rujukan']) > 0 ? 'table-light' : '' }}">
                <td class="fw-bold">{{ $r['tanggal'] }}</td>
                <td>{{ $r['pasien_awal'] ?: 0 }}</td>
                <td>{{ $r['pasien_baru'] ?: 0 }}</td>
                <td>{{ $r['pasien_pindahan'] ?: 0 }}</td>
                <td>{{ $r['pasien_rujukan'] ?: 0 }}</td>
                <td>{{ $r['jumlah_masuk'] ?: 0 }}</td>
                <td>{{ $r['pasien_dipindahkan'] ?: 0 }}</td>
                <td>{{ $r['pulang_sembuh'] ?: 0 }}</td>
                <td>{{ $r['pulang_paksa'] ?: 0 }}</td>
                <td>{{ $r['pasien_kabur'] ?? 0 }}</td>
                <td>{{ $r['meninggal_lt48'] ?: 0 }}</td>
                <td>{{ $r['meninggal_gte48'] ?: 0 }}</td>
                <td>{{ $r['dirujuk'] ?: 0 }}</td>
                <td>{{ $r['jumlah_keluar'] ?: 0 }}</td>
                <td>{{ $r['masih_dirawat'] ?: 0 }}</td>
                <td>{{ $r['jumlah_lama_dirawat'] ?? 0 }}</td>
                <td>{{ $r['jumlah_hari_perawatan'] ?? 0 }}</td>
                <td>{{ $r['bor'] ? $r['bor'].'%' : 0 }}</td>
                <td>{{ $r['avlos'] ?: 0 }}</td>
                <td>{{ $r['bto'] ?: 0 }}</td>
                <td>{{ $r['toi'] ?: 0 }}</td>
            </tr>
            @endforeach

            {{-- BARIS TOTAL --}}
            <tr class="table-warning fw-bold">
                <td>Total</td>
                <td>{{ collect($rekap)->sum('pasien_awal') }}</td>
                <td>{{ collect($rekap)->sum('pasien_baru') }}</td>
                <td>{{ collect($rekap)->sum('pasien_pindahan') }}</td>
                <td>{{ collect($rekap)->sum('pasien_rujukan') }}</td>
                <td>{{ collect($rekap)->sum('jumlah_masuk') }}</td>
                <td>{{ collect($rekap)->sum('pasien_dipindahkan') }}</td>
                <td>{{ collect($rekap)->sum('pulang_sembuh') }}</td>
                <td>{{ collect($rekap)->sum('pulang_paksa') }}</td>
                <td>{{ collect($rekap)->sum('pasien_kabur') }}</td>
                <td>{{ collect($rekap)->sum('meninggal_lt48') }}</td>
                <td>{{ collect($rekap)->sum('meninggal_gte48') }}</td>
                <td>{{ collect($rekap)->sum('dirujuk') }}</td>
                <td>{{ collect($rekap)->sum('jumlah_keluar') }}</td>
                <td>{{ collect($rekap)->last()['masih_dirawat'] }}</td>
                <td>{{ collect($rekap)->sum('jumlah_lama_dirawat') }}</td>
                <td>{{ collect($rekap)->sum('jumlah_hari_perawatan') }}</td>
                <td>{{ round(collect($rekap)->avg('bor'), 2) }}%</td>
                <td>{{ round(collect($rekap)->avg('avlos'), 2) }}</td>
                <td>{{ round(collect($rekap)->avg('bto'), 2) }}</td>
                <td>{{ round(collect($rekap)->avg('toi'), 2) }}</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="col-12 mt-2 d-flex justify-content-end">
    <a href="{{ route('rekap.print', [$bulan, $tahun]) }}"
       target="_blank"
       class="btn btn-success fw-bold px-4">
        <i class="bi bi-printer-fill me-2"></i> Print
    </a>
</div>

{{-- SCRIPT CHART.JS --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = {!! json_encode(collect($rekap)->pluck('tanggal')) !!};
    const dataBor  = {!! json_encode(collect($rekap)->pluck('bor')->map(fn($v) => $v ?: 0)) !!};
    const dataAvlos = {!! json_encode(collect($rekap)->pluck('avlos')->map(fn($v) => $v ?: 0)) !!};
    const dataBto  = {!! json_encode(collect($rekap)->pluck('bto')->map(fn($v) => $v ?: 0)) !!};
    const dataToi  = {!! json_encode(collect($rekap)->pluck('toi')->map(fn($v) => $v ?: 0)) !!};

    new Chart(document.getElementById('lineChartRekap'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'BOR (%)',
                    data: dataBor,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13,110,253,0.08)',
                    tension: 0.3,
                    fill: true,
                    pointRadius: 3
                },
                {
                    label: 'AVLOS',
                    data: dataAvlos,
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25,135,84,0.08)',
                    tension: 0.3,
                    fill: true,
                    pointRadius: 3
                },
                {
                    label: 'BTO',
                    data: dataBto,
                    borderColor: '#ffc107',
                    backgroundColor: 'rgba(255,193,7,0.08)',
                    tension: 0.3,
                    fill: true,
                    pointRadius: 3
                },
                {
                    label: 'TOI',
                    data: dataToi,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220,53,69,0.08)',
                    tension: 0.3,
                    fill: true,
                    pointRadius: 3
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: { mode: 'index', intersect: false }
            },
            scales: {
                x: {
                    title: { display: true, text: 'Tanggal' }
                },
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Nilai' }
                }
            }
        }
    });
</script>
@endpush

@endsection