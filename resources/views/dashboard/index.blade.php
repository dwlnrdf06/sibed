@extends('layouts.app')

@section('content')
<h4 class="mb-4">Ketersediaan Tempat Tidur</h4>

{{-- CARD SUMMARY --}}
<div class="row g-4 mb-4">

    <!-- Total Kapasitas -->
    <div class="col-md-4">
        <div class="modern-card border-blue">
            <div class="card-body text-center">
                <h5 class="card-title">TOTAL KAPASITAS</h5>
                <h1 class="fw-bold text-blue">{{ $totalKapasitas }}</h1>
                <p class="text-muted mb-0">Tempat Tidur</p>
            </div>
        </div>
    </div>

    <!-- Terisi -->
    <div class="col-md-4">
        <div class="modern-card border-red">
            <div class="card-body text-center">
                <h5 class="card-title">TERISI</h5>
                <h1 class="fw-bold text-red">{{ $terisi }}</h1>
                <p class="text-muted mb-0">Tempat Tidur</p>
            </div>
        </div>
    </div>

    <!-- Tersedia -->
    <div class="col-md-4">
        <div class="modern-card border-green">
            <div class="card-body text-center">
                <h5 class="card-title">TERSEDIA</h5>
                <h1 class="fw-bold text-green">{{ $tersedia }}</h1>
                <p class="text-muted mb-0">Tempat Tidur</p>
            </div>
        </div>
    </div>

</div>

{{-- TABEL KAMAR --}}
<div class="card shadow-sm border-0 rounded-4">

    <div class="card-header bg-white border-0 pt-4">
        <h4 class="text-center fw-bold">
            DATA KETERSEDIAAN KAMAR RAWAT INAP
        </h4>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table modern-table align-middle text-center">
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

        </div>
    </div>
<style>
.modern-card{
    background: white;
    border-radius: 12px;
    min-height: 180px;

    border-left: 12px solid;

    display: flex;
    align-items: center;
    justify-content: center;

    box-shadow: 0 4px 12px rgba(0,0,0,0.1);

    transition: all 0.3s ease;
}

.modern-card:hover{
    transform: translateY(-5px);
}

.border-blue{
    border-color: #2563eb;
}

.border-red{
    border-color: #e63946;
}

.border-green{
    border-color: #2a9d8f;
}

.text-blue{
    color: #2563eb;
}

.text-red{
    color: #e63946;
}

.text-green{
    color: #2a9d8f;
}

.card-title{
    letter-spacing: 1px;
    font-weight: 500;
}
.modern-table{
    border-radius: 15px;
    overflow: hidden;
    background: white;
}

.modern-table thead{
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: white;
}

.modern-table thead th{
    border: none;
    padding: 16px;
    font-size: 15px;
    font-weight: 600;
}

.modern-table tbody td{
    padding: 14px;
    vertical-align: middle;
    border-color: #e5e7eb;
}

.modern-table tbody tr:hover{
    background-color: #f8fafc;
    transition: 0.2s;
}

.modern-table{
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}
</style>

@endsection