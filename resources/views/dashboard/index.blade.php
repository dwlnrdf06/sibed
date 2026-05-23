@extends('layouts.app')

@section('content')

{{-- GREETING --}}
<div class="p-3 mb-4 text-white position-relative overflow-hidden" 
     style="background: linear-gradient(135deg, #1e70cd 0%, #2575fc 100%); border-radius: 15px; height: 140px;">
    
    @php
        date_default_timezone_set('Asia/Jakarta');
        $hour = (int) date('H');
        
        if ($hour >= 5 && $hour < 12) {
            $timeGreeting = 'Good Morning';
        } elseif ($hour >= 12 && $hour < 18) {
            $timeGreeting = 'Good Afternoon';
        } else {
            $timeGreeting = 'Good Night';
        }

        $role = auth()->user()->role;
        $roleName = match($role) {
            'admin'   => 'Admin',
            'perawat' => 'Perawat',
            'pmik'    => 'PMIK',
            default   => ''
        };

        $finalGreeting = trim("$timeGreeting $roleName");
    @endphp

    <div class="col-md-9 col-12 d-flex flex-column justify-content-center h-100 ps-4">
        <h4 class="fw-bold mb-1" style="font-size: 22px; letter-spacing: -0.5px;">
            {{ $finalGreeting }}
        </h4>
        <p class="mb-0 text-white" style="font-size: 13px; max-width: 600px; line-height: 1.4; opacity: 1;">
            Selamat datang di Sistem Informasi Tempat Tidur (SiBed). Tetap semangat dalam mengelola kapasitas layanan hari ini!
        </p>
    </div>

    <div class="position-absolute end-0 bottom-0 top-0 d-none d-md-flex align-items-center justify-content-end pe-4" style="width: 25%; height: 100%;">
        <img src="{{ asset('images/ilustrasi.png') }}" 
            alt="Ilustrasi SiBed" 
            style="height: 120px; width: auto; object-fit: contain; filter: drop-shadow(2px 4px 6px rgba(0,0,0,0.15));">
    </div>
</div>

<h4 class="mb-4 fw-bold">Ketersediaan Tempat Tidur</h4>

{{-- CARD SUMMARY --}}
{{-- CARD SUMMARY PROPORSIONAL - IKON POJOK KIRI, TEKS TENGAH BESAR --}}
<div class="row g-4 mb-4">

    <div class="col-md-4">
        <div class="modern-card border-blue p-4 position-relative">
            <div class="rounded-3 bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center position-absolute" 
                 style="width: 44px; height: 44px; top: 15px; left: 15px;">
                <i class="bi bi-hospital fs-5"></i>
            </div>
            
            <div class="card-body p-0 d-flex flex-column align-items-center text-center mt-4">
                <h5 class="card-title mb-2 text-muted" style="font-size: 14px; font-weight: 700; letter-spacing: 0.8px; color: #666;">TOTAL KAPASITAS</h5>
                <h1 class="fw-bold text-blue mb-1" style="font-size: 46px; line-height: 1;">{{ $totalKapasitas }}</h1>
                <p class="text-muted mb-0" style="font-size: 14px; font-weight: 600;">Tempat Tidur</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="modern-card border-red p-4 position-relative">
            <div class="rounded-3 bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center position-absolute" 
                 style="width: 44px; height: 44px; top: 15px; left: 15px;">
                <i class="bi bi-person-workspace fs-5"></i>
            </div>
            
            <div class="card-body p-0 d-flex flex-column align-items-center text-center mt-4">
                <h5 class="card-title mb-2 text-muted" style="font-size: 14px; font-weight: 700; letter-spacing: 0.8px; color: #666;">TERISI</h5>
                <h1 class="fw-bold text-red mb-1" style="font-size: 46px; line-height: 1;">{{ $terisi }}</h1>
                <p class="text-muted mb-0" style="font-size: 14px; font-weight: 600;">Tempat Tidur</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="modern-card border-green p-4 position-relative">
            <div class="rounded-3 bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center position-absolute" 
                 style="width: 44px; height: 44px; top: 15px; left: 15px;">
                <i class="bi bi-check-circle-fill fs-5"></i>
            </div>
            
            <div class="card-body p-0 d-flex flex-column align-items-center text-center mt-4">
                <h5 class="card-title mb-2 text-muted" style="font-size: 14px; font-weight: 700; letter-spacing: 0.8px; color: #666;">TERSEDIA</h5>
                <h1 class="fw-bold text-green mb-1" style="font-size: 46px; line-height: 1;">{{ $tersedia }}</h1>
                <p class="text-muted mb-0" style="font-size: 14px; font-weight: 600;">Tempat Tidur</p>
            </div>
        </div>
    </div>

</div>

{{-- TABEL KAMAR --}}
<div class="card shadow-sm border-0 rounded-4">

    <div class="card-header bg-white border-0 pt-4">
        <h4 class="text-start fw-bold ps-4">
            Data Ketersediaan Kamar Rawat Inap
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
    padding: 5px 0; 

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