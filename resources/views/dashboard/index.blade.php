@extends('layouts.app')

@section('content')
<h4 class="mb-4">Ketersediaan Tempat Tidur</h4>

{{-- CARD SUMMARY --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-center shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #f8f0ff, #e8d5f5);">
            <div class="card-body py-4">
                <p class="text-muted mb-1">Total Kapasitas</p>
                <h2 class="fw-bold" style="color: #741a75;">{{ $totalKapasitas }}</h2>
                <small class="text-muted">Tempat Tidur</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #fff0f0, #ffd5d5);">
            <div class="card-body py-4">
                <p class="text-muted mb-1">Terisi</p>
                <h2 class="fw-bold" style="color: #c0392b;">{{ $terisi }}</h2>
                <small class="text-muted">Tempat Tidur</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #f0fff4, #d5f5e3);">
            <div class="card-body py-4">
                <p class="text-muted mb-1">Tersedia</p>
                <h2 class="fw-bold" style="color: #1e8449;">{{ $tersedia }}</h2>
                <small class="text-muted">Tempat Tidur</small>
            </div>
        </div>
    </div>
</div>

{{-- TABEL KAMAR --}}
<h5 class="text-center fw-bold mb-3">DATA KETERSEDIAAN KAMAR RAWAT INAP</h5>
<div class="table-responsive">
    <table class="table table-bordered text-center align-middle">
        <thead class="table-primary">
            <tr>
                <th>Jenis Kamar</th>
                <th>Kelas Kamar</th>
                <th>Nama Kamar</th>
                <th>Kapasitas TT</th>
                <th>TT Terisi</th>
                <th>TT Tersedia</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            {{-- REGULER KELAS 1 --}}
            @php $regulerKelas1 = $kamar->where('jenis_kamar','Reguler')->where('kelas_kamar','Kelas 1'); @endphp
            @foreach($regulerKelas1 as $index => $k)
            <tr>
                @if($index === $regulerKelas1->keys()->first())
                    <td rowspan="{{ $kamar->where('jenis_kamar','Reguler')->count() }}">Reguler</td>
                    <td rowspan="{{ $regulerKelas1->count() }}">Kelas 1</td>
                @endif
                <td>{{ $k->nama_kamar }}</td>
                <td>{{ $k->kapasitas }}</td>
                <td>{{ $k->terisi }}</td>
                <td>{{ $k->tersedia }}</td>
                <td>
                    @if($k->terisi == 0)
                        <span class="badge bg-success">Kosong</span>
                    @elseif($k->terisi >= $k->kapasitas)
                        <span class="badge bg-danger">Penuh</span>
                    @else
                        <span class="badge bg-warning text-dark">Sebagian</span>
                    @endif
                </td>
            </tr>
            @endforeach

            {{-- REGULER KELAS 2 --}}
            @php $regulerKelas2 = $kamar->where('jenis_kamar','Reguler')->where('kelas_kamar','Kelas 2'); @endphp
            @foreach($regulerKelas2 as $index => $k)
            <tr>
                @if($index === $regulerKelas2->keys()->first())
                    <td rowspan="{{ $regulerKelas2->count() }}">Kelas 2</td>
                @endif
                <td>{{ $k->nama_kamar }}</td>
                <td>{{ $k->kapasitas }}</td>
                <td>{{ $k->terisi }}</td>
                <td>{{ $k->tersedia }}</td>
                <td>
                    @if($k->terisi == 0)
                        <span class="badge bg-success">Kosong</span>
                    @elseif($k->terisi >= $k->kapasitas)
                        <span class="badge bg-danger">Penuh</span>
                    @else
                        <span class="badge bg-warning text-dark">Sebagian</span>
                    @endif
                </td>
            </tr>
            @endforeach

            {{-- REGULER KELAS 3 --}}
            @php $regulerKelas3 = $kamar->where('jenis_kamar','Reguler')->where('kelas_kamar','Kelas 3'); @endphp
            @foreach($regulerKelas3 as $index => $k)
            <tr>
                @if($index === $regulerKelas3->keys()->first())
                    <td rowspan="{{ $regulerKelas3->count() }}">Kelas 3</td>
                @endif
                <td>{{ $k->nama_kamar }}</td>
                <td>{{ $k->kapasitas }}</td>
                <td>{{ $k->terisi }}</td>
                <td>{{ $k->tersedia }}</td>
                <td>
                    @if($k->terisi == 0)
                        <span class="badge bg-success">Kosong</span>
                    @elseif($k->terisi >= $k->kapasitas)
                        <span class="badge bg-danger">Penuh</span>
                    @else
                        <span class="badge bg-warning text-dark">Sebagian</span>
                    @endif
                </td>
            </tr>
            @endforeach

            {{-- VIP --}}
            @php $vip = $kamar->where('jenis_kamar','VIP'); @endphp
            @foreach($vip as $index => $k)
            <tr>
                @if($index === $vip->keys()->first())
                    <td rowspan="{{ $vip->count() }}">VIP</td>
                    <td rowspan="{{ $vip->count() }}">VIP</td>
                @endif
                <td>{{ $k->nama_kamar }}</td>
                <td>{{ $k->kapasitas }}</td>
                <td>{{ $k->terisi }}</td>
                <td>{{ $k->tersedia }}</td>
                <td>
                    @if($k->terisi == 0)
                        <span class="badge bg-success">Kosong</span>
                    @elseif($k->terisi >= $k->kapasitas)
                        <span class="badge bg-danger">Penuh</span>
                    @else
                        <span class="badge bg-warning text-dark">Sebagian</span>
                    @endif
                </td>
            </tr>
            @endforeach

            {{-- VVIP --}}
            @php $vvip = $kamar->where('jenis_kamar','VVIP'); @endphp
            @foreach($vvip as $index => $k)
            <tr>
                @if($index === $vvip->keys()->first())
                    <td rowspan="{{ $vvip->count() }}">VVIP</td>
                    <td rowspan="{{ $vvip->count() }}">VVIP</td>
                @endif
                <td>{{ $k->nama_kamar }}</td>
                <td>{{ $k->kapasitas }}</td>
                <td>{{ $k->terisi }}</td>
                <td>{{ $k->tersedia }}</td>
                <td>
                    @if($k->terisi == 0)
                        <span class="badge bg-success">Kosong</span>
                    @elseif($k->terisi >= $k->kapasitas)
                        <span class="badge bg-danger">Penuh</span>
                    @else
                        <span class="badge bg-warning text-dark">Sebagian</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection