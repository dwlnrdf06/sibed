@extends('layouts.app')

@section('content')

{{-- ===== JUDUL ===== --}}
<h4 style="font-weight: bold; color: #333; margin-bottom: 5px;">
    <i class="bi bi-person-fill-add me-2" style="color:black;"></i>
    Form Pasien Masuk
</h4>

<div style="
    width: 60px;
    height: 4px;
    background: blue;
    border-radius: 5px;
    margin-bottom: 25px;">
</div>

{{-- ===== ALERT ===== --}}
@if(session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
    </div>
@endif

{{-- ===== CARD FORM ===== --}}
<div style="
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
">

    <form action="{{ route('pasien-masuk.store') }}" method="POST">
        @csrf

        <div class="row">

            {{-- ================= NAMA PASIEN ================= --}}
            <div class="col-md-6 mb-3" style="position: relative;">

                <label class="form-label fw-semibold"
                    style="font-size:15px; color:#6B7280;">

                    <i class="bi bi-person-fill me-1"></i>
                    Nama Pasien

                </label>

                <div class="input-group">

                    <span class="input-group-text"
                        style="background:#f3f4f6; border-color:#6B7280;">

                        <i class="bi bi-person-fill"
                            style="color:#6B7280;"></i>

                    </span>

                    <input type="text"
                        id="nama_pasien_input"
                        name="nama_pasien"
                        class="form-control"
                        autocomplete="off"
                        placeholder="Isi Nama Pasien Menggunakan Huruf KAPITAL"
                        required
                        oninput="cariPasien(this.value, 'nama')"
                        style="border-color:#6B7280;">

                </div>

                {{-- DROPDOWN --}}
                <div id="dropdown_pasien"
                    style="
                        display:none;
                        position:absolute;
                        top:100%;
                        left:0;
                        right:0;
                        background:white;
                        border:1px solid #ddd;
                        border-radius:8px;
                        box-shadow:0 4px 15px rgba(0,0,0,0.1);
                        z-index:999;
                        max-height:250px;
                        overflow-y:auto;
                    ">
                </div>

            </div>

            {{-- ================= NO RM ================= --}}
            <div class="col-md-6 mb-3" style="position: relative;">

                <label class="form-label fw-semibold"
                    style="font-size:15px; color:#6B7280;">

                    <i class="bi bi-upc-scan me-1"></i>
                    No RM

                </label>

                <div class="input-group">

                    <span class="input-group-text"
                        style="background:#f3f4f6; border-color:#6B7280;">

                        <i class="bi bi-upc-scan"
                            style="color:#6B7280;"></i>

                    </span>

                    <input type="text"
                        id="no_rm_input"
                        name="no_rm"
                        class="form-control"
                        autocomplete="off"
                        placeholder="Isi No RM"
                        required
                        oninput="cariPasien(this.value, 'norm')"
                        style="border-color:#6B7280;">

                </div>

                {{-- DROPDOWN --}}
                <div id="dropdown_norm"
                    style="
                        display:none;
                        position:absolute;
                        top:100%;
                        left:0;
                        right:0;
                        background:white;
                        border:1px solid #ddd;
                        border-radius:8px;
                        box-shadow:0 4px 15px rgba(0,0,0,0.1);
                        z-index:999;
                        max-height:250px;
                        overflow-y:auto;
                    ">
                </div>

            </div>

            {{-- ================= CARA MASUK ================= --}}
            <div class="col-md-4 mb-3">

                <label class="form-label fw-semibold"
                    style="font-size:15px; color:#6B7280;">

                    <i class="bi bi-door-open-fill me-1"></i>
                    Cara Masuk

                </label>

                <div class="input-group">

                    <span class="input-group-text"
                        style="background:#f3f4f6; border-color:#6B7280;">

                        <i class="bi bi-door-open-fill me-1"
                            style="color:#6B7280;"></i>

                    </span>

                    <select name="cara_masuk"
                        id="cara_masuk"
                        class="form-select"
                        required
                        style="border-color:#6B7280;">

                        <option value="">-- Pilih Cara Masuk --</option>
                        <option value="Pasien Baru">Pasien Baru</option>
                        <option value="Rujukan">Rujukan</option>
                        <option value="Pindahan Ruangan">Pindahan Ruangan</option>

                    </select>

                </div>

            </div>

            {{-- ================= NAMA KAMAR ================= --}}
            <div class="col-md-4 mb-3">

                <label class="form-label fw-semibold"
                    style="font-size:15px; color:#6B7280;">

                    <i class="bi bi-house-door-fill me-1"></i>
                    Nama Kamar

                </label>

                <div class="input-group">

                    <span class="input-group-text"
                        style="background:#f3f4f6; border-color:#6B7280;">

                        <i class="bi bi-house-door-fill me-1"
                            style="color:#6B7280;"></i>

                    </span>

                    <select name="kamar_id"
                        class="form-select"
                        required
                        style="border-color:#6B7280;">

                        @foreach($kamar as $k)
                            <option value="{{ $k->id }}">
                                {{ $k->nama_kamar }}
                                ({{ $k->kelas_kamar ?? '-' }})
                            </option>
                        @endforeach

                    </select>

                </div>

            </div>

            {{-- ================= RUJUKAN DARI ================= --}}
            <div class="col-md-4 mb-3">

                <label class="form-label fw-semibold"
                    style="font-size:15px; color:#6B7280;">

                    <i class="bi bi-building-fill-check me-1"></i>
                    Rujukan Dari

                </label>

                <div class="input-group">

                    <span class="input-group-text"
                        style="background:#f3f4f6; border-color:#6B7280;">

                        <i class="bi bi-building-fill-check me-1"
                            style="color:#6B7280;"></i>

                    </span>

                    <input type="text"
                        name="rujukan_dari"
                        id="rujukan_dari"
                        class="form-control"
                        placeholder="Isi jika rujukan"
                        style="border-color:#6B7280;">

                </div>

            </div>

            {{-- ================= PINDAHAN DARI ================= --}}
                <div class="col-md-4 mb-3">

                    <label class="form-label fw-semibold"
                        style="font-size: 15px; color:#6B7280;">

                        <i class="bi bi-arrow-left-right me-1"></i>
                        Pindahan Dari

                    </label>

                    <div class="input-group">

                        <span class="input-group-text"
                            style="background:#f3f4f6; border-color:#6B7280;">

                            <i class="bi bi-box-arrow-in-right"
                                style="color:#6B7280;"></i>

                        </span>

                        <select name="pindahan_dari"
                            id="pindahan_dari"
                            class="form-select"
                            style="border-color:#6B7280;">

                            <option value="">-- Pilih Kamar Asal --</option>

                            {{-- Mengelompokkan kamar otomatis berdasarkan kolom kelas_kamar --}}
                            @if(isset($list_kamar) && $list_kamar->count() > 0)
                                @foreach($list_kamar->groupBy('kelas_kamar') as $kelasKamar => $grupKamar)
                                    <optgroup label="{{ $kelasKamar }}">
                                        @foreach($grupKamar as $kamar)
                                            {{-- Value disesuaikan dengan format teks sebelumnya: Nama Kamar (Kelas) --}}
                                            <option value="{{ $kamar->nama_kamar }} ({{ $kamar->kelas_kamar }})">
                                                {{ $kamar->nama_kamar }} ({{ $kamar->kelas_kamar }})
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            @else
                                <option value="" disabled>Data kamar kosong. Silakan jalankan seeder terlebih dahulu.</option>
                            @endif

                        </select>

                    </div>

                </div>

                {{-- ================= TANGGAL MASUK ================= --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label fw-semibold"
                        style="font-size:15px; color:#6B7280;">

                        <i class="bi bi-calendar-event-fill me-1"></i>
                        Tanggal Masuk

                    </label>

                    <div class="input-group">

                        <span class="input-group-text"
                            style="background:#f3f4f6; border-color:#6B7280;">

                            <i class="bi bi-calendar-event-fill"
                                style="color:#6B7280;"></i>

                        </span>

                        <input type="date"
                            name="tanggal_masuk"
                            class="form-control"
                            required
                            style="border-color:#6B7280;">

                    </div>

                </div>

            </div>

        {{-- ================= BUTTON ================= --}}
        <button type="submit"
            class="btn mt-3 px-4"
            style="
                background:#1d4ed8;
                color:white;
                border:none;
                border-radius:8px;
                font-weight:500;
            ">

            <i class="bi bi-send-fill me-2"></i>
            Kirim

        </button>

    </form>

</div>

@endsection

@push('scripts')
<script>
function cariPasien(keyword, tipe) {
    let dropdownId = (tipe === 'nama') ? 'dropdown_pasien' : 'dropdown_norm';
    let dropdown = document.getElementById(dropdownId);
    
    if (keyword.trim().length === 0) {
        dropdown.style.display = 'none';
        dropdown.innerHTML = '';
        return;
    }

    // Gaya container dropdown agar modern dan melayang mulus
    dropdown.style.border = '1px solid #E5E7EB';
    dropdown.style.borderRadius = '10px';
    dropdown.style.boxShadow = '0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1)';
    dropdown.style.marginTop = '6px';
    dropdown.style.transition = 'all 0.2s ease';

    fetch(`/api/cari-pasien?q=${encodeURIComponent(keyword)}`)
        .then(response => response.json())
        .then(data => {
            dropdown.innerHTML = '';
            
            if (data.length === 0) {
                dropdown.innerHTML = `
                    <div style="padding: 20px; color: #9CA3AF; font-size: 14px; text-align: center;">
                        <i class="bi bi-emoji-frown d-block mb-2" style="font-size: 24px; color: #D1D5DB;"></i>
                        Pasien lama tidak ditemukan
                    </div>`;
                dropdown.style.display = 'block';
                return;
            }

            dropdown.style.display = 'block';
            
            data.forEach(pasien => {
                let item = document.createElement('div');
                
                // Mengatur padding item list & layout flex vertikal
                item.style.padding = '12px 18px';
                item.style.cursor = 'pointer';
                item.style.borderBottom = '1px solid #F3F4F6';
                item.style.display = 'flex';
                item.style.flexDirection = 'column'; // Membuat teks menumpuk ke bawah
                item.style.gap = '2px'; // Jarak tipis antara Nama dan No RM
                item.style.transition = 'all 0.15s ease';
                
                item.innerHTML = `
                    <div style="color: #000000; font-weight: 700; font-size: 14.5px; letter-spacing: 0.3px;">
                        ${pasien.nama_pasien.toUpperCase()}
                    </div>
                    <div style="color: #6B7280; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 5px; margin-top: 2px;">
                        <span>No. RM:</span>
                        <span style="font-family: monospace; font-weight: 700; color: #374151;">${pasien.no_rm}</span>
                    </div>
                `;
                
                // Efek hover: latar belakang biru muda pastel cerah & teks sedikit bergeser ke kanan
                item.onmouseenter = () => {
                    item.style.backgroundColor = '#EFF6FF';
                    item.style.paddingLeft = '24px';
                };
                item.onmouseleave = () => {
                    item.style.backgroundColor = 'white';
                    item.style.paddingLeft = '18px';
                };
                
                item.onclick = function() {
                    document.getElementById('nama_pasien_input').value = pasien.nama_pasien.toUpperCase();
                    document.getElementById('no_rm_input').value = pasien.no_rm;
                    
                    document.getElementById('dropdown_pasien').style.display = 'none';
                    document.getElementById('dropdown_norm').style.display = 'none';
                };
                
                dropdown.appendChild(item);
            });
        })
        .catch(error => console.error('Error autocomplete:', error));
}

document.addEventListener('click', function(e) {
    if (e.target.id !== 'nama_pasien_input' && e.target.id !== 'no_rm_input') {
        document.getElementById('dropdown_pasien').style.display = 'none';
        document.getElementById('dropdown_norm').style.display = 'none';
    }
});
</script>
@endpush