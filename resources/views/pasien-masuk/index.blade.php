@extends('layouts.app')

@section('content')


{{-- ===== JUDUL ===== --}}
<h4 style="font-weight: bold; color: #333; margin-bottom: 5px;">
    <i class="bi bi-person-fill-add me-2" style="color:black;"></i>
    Form Pasien Masuk
</h4>

<div style="width: 60px; height: 4px; background: blue; border-radius: 5px; margin-bottom: 25px;"></div>

@if(session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
    </div>
@endif

<div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 15px rgba(0,0,0,0.08);">

    <form action="{{ route('pasien-masuk.store') }}" method="POST">
        @csrf

        <div class="row">

            {{-- NAMA PASIEN --}}
            <div class="col-md-6 mb-3" style="position: relative;">
                <label class="form-label fw-semibold" style="font-size:15px; color:#6B7280;">
                    <i class="bi bi-person-fill me-1"></i> Nama Pasien
                </label>
                <div class="input-group">
                    <span class="input-group-text" style="background:#f3f4f6; border-color:#6B7280;">
                        <i class="bi bi-person-fill" style="color:#6B7280;"></i>
                    </span>
                    <input type="text" id="nama_pasien_input" name="nama_pasien"
                        class="form-control" autocomplete="off"
                        placeholder="Isi Nama Pasien Menggunakan Huruf KAPITAL" required
                        oninput="cariPasien(this.value, 'nama')"
                        style="border-color:#6B7280;">
                </div>
                <div id="dropdown_pasien" style="display:none; position:absolute; top:100%; left:0; right:0; background:white; border:1px solid #ddd; border-radius:8px; box-shadow:0 4px 15px rgba(0,0,0,0.1); z-index:999; max-height:250px; overflow-y:auto;"></div>
            </div>

            {{-- NO RM --}}
            <div class="col-md-6 mb-3" style="position: relative;">
                <label class="form-label fw-semibold" style="font-size:15px; color:#6B7280;">
                    <i class="bi bi-upc-scan me-1"></i> No RM
                </label>
                <div class="input-group">
                    <span class="input-group-text" style="background:#f3f4f6; border-color:#6B7280;">
                        <i class="bi bi-upc-scan" style="color:#6B7280;"></i>
                    </span>
                    <input type="text" id="no_rm_input" name="no_rm"
                        class="form-control" autocomplete="off"
                        placeholder="Isi No RM" required
                        oninput="cariPasien(this.value, 'norm')"
                        style="border-color:#6B7280;">
                </div>
                <div id="dropdown_norm" style="display:none; position:absolute; top:100%; left:0; right:0; background:white; border:1px solid #ddd; border-radius:8px; box-shadow:0 4px 15px rgba(0,0,0,0.1); z-index:999; max-height:250px; overflow-y:auto;"></div>
            </div>

            {{-- CARA MASUK --}}
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold" style="font-size:15px; color:#6B7280;">
                    <i class="bi bi-door-open-fill me-1"></i> Cara Masuk
                </label>
                <div class="input-group">
                    <span class="input-group-text" style="background:#f3f4f6; border-color:#6B7280;">
                        <i class="bi bi-door-open-fill" style="color:#6B7280;"></i>
                    </span>
                    <select name="cara_masuk" id="cara_masuk" class="form-select" required style="border-color:#6B7280;">
                        <option value="">-- Pilih Cara Masuk --</option>
                        <option value="Pasien Baru">Pasien Baru</option>
                        <option value="Rujukan">Rujukan</option>
                        <option value="Pindahan Ruangan">Pindahan Ruangan</option>
                    </select>
                </div>
            </div>

            {{-- NAMA KAMAR --}}
<div class="col-md-4 mb-3">
    <label class="form-label fw-semibold" style="font-size:15px; color:#6B7280;">
        <i class="bi bi-house-door-fill me-1"></i> Nama Kamar
    </label>

    <div class="input-group">
        <span class="input-group-text" style="background:#f3f4f6; border-color:#6B7280;">
            <i class="bi bi-house-door-fill" style="color:#6B7280;"></i>
        </span>

        <select name="kamar_id" class="form-select" required style="border-color:#6B7280;">
            <option value="">-- Pilih Kamar --</option>

            @foreach($kamar->groupBy('kelas_kamar') as $kelas => $kamarList)

                <optgroup label="{{ $kelas }}">

                    @foreach($kamarList as $k)

                        <option value="{{ $k->id }}">
                            {{ $k->nama_kamar }}
                        </option>

                    @endforeach

                </optgroup>

            @endforeach

        </select>
    </div>
</div>
            {{-- RUJUKAN DARI --}}
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold" style="font-size:15px; color:#6B7280;">
                    <i class="bi bi-building-fill-check me-1"></i> Rujukan Dari
                </label>
                <div class="input-group">
                    <span class="input-group-text" style="background:#f3f4f6; border-color:#6B7280;">
                        <i class="bi bi-building-fill-check" style="color:#6B7280;"></i>
                    </span>
                    <input type="text" name="rujukan_dari" id="rujukan_dari"
                        class="form-control" placeholder="Isi jika rujukan"
                        style="border-color:#6B7280;">
                </div>
            </div>

            {{-- PINDAHAN DARI --}}
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold" style="font-size:15px; color:#6B7280;">
                    <i class="bi bi-arrow-left-right me-1"></i> Pindahan Dari
                </label>
                <div class="input-group">
                    <span class="input-group-text" style="background:#f3f4f6; border-color:#6B7280;">
                        <i class="bi bi-box-arrow-in-right" style="color:#6B7280;"></i>
                    </span>
                    <select name="pindahan_dari" id="pindahan_dari" class="form-select" style="border-color:#6B7280;">
                        <option value="">-- Pilih Kamar Asal --</option>
                        <optgroup label="Kelas 1">
                            <option value="Tulip 1a (Kelas 1)">Tulip 1a </option>
                            <option value="Tulip 1b (Kelas 1)">Tulip 1b </option>
                            <option value="Tulip 1c (Kelas 1)">Tulip 1c </option>
                            <option value="Tulip 1d (Kelas 1)">Tulip 1d </option>
                            <option value="Tulip 1e (Kelas 1)">Tulip 1e </option>
                        </optgroup>
                        <optgroup label="Kelas 2">
                            <option value="Flamboyan 2a (Kelas 2)">Flamboyan 2a </option>
                            <option value="Flamboyan 2b (Kelas 2)">Flamboyan 2b </option>
                            <option value="Flamboyan 2c (Kelas 2)">Flamboyan 2c </option>
                            <option value="Flamboyan 2d (Kelas 2)">Flamboyan 2d </option>
                            <option value="Flamboyan 2e (Kelas 2)">Flamboyan 2e </option>
                        </optgroup>
                        <optgroup label="Kelas 3">
                            <option value="Melati 3a (Kelas 3)">Melati 3a </option>
                            <option value="Melati 3b (Kelas 3)">Melati 3b </option>
                            <option value="Melati 3c (Kelas 3)">Melati 3c </option>
                            <option value="Melati 3d (Kelas 3)">Melati 3d </option>
                        </optgroup>
                        <optgroup label="VIP">
                            <option value="Mawar a (VIP)">Mawar a </option>
                            <option value="Mawar b (VIP)">Mawar b </option>
                            <option value="Mawar c (VIP)">Mawar c </option>
                        </optgroup>
                        <optgroup label="VVIP">
                            <option value="Anggrek a (VVIP)">Anggrek a </option>
                            <option value="Anggrek b (VVIP)">Anggrek b </option>
                            <option value="Anggrek c (VVIP)">Anggrek c </option>
                        </optgroup>
                    </select>
                </div>
            </div>

            {{-- TANGGAL MASUK --}}
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold" style="font-size:15px; color:#6B7280;">
                    <i class="bi bi-calendar-event-fill me-1"></i> Tanggal Masuk
                </label>
                <div class="input-group">
                    <span class="input-group-text" style="background:#f3f4f6; border-color:#6B7280;">
                        <i class="bi bi-calendar-event-fill" style="color:#6B7280;"></i>
                    </span>
                    <input type="date" name="tanggal_masuk" class="form-control" required style="border-color:#6B7280;">
                </div>
            </div>

        </div>

        <button type="submit" class="btn mt-3 px-4"
            style="background:#1d4ed8; color:white; border:none; border-radius:8px; font-weight:500;">
            <i class="bi bi-send-fill me-2"></i> Kirim
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

    fetch(`/api/cari-pasien?q=${encodeURIComponent(keyword)}`)
        .then(response => response.json())
        .then(data => {
            dropdown.innerHTML = '';

            if (data.length === 0) {
                dropdown.innerHTML = `
                    <div style="padding: 20px; color: #9CA3AF; font-size: 14px; text-align: center;">
                        <i class="bi bi-emoji-frown d-block mb-2" style="font-size: 24px;"></i>
                        Pasien tidak ditemukan
                    </div>`;
                dropdown.style.display = 'block';
                return;
            }

            dropdown.style.display = 'block';

            data.forEach(pasien => {
                let item = document.createElement('div');
                item.style.padding = '12px 18px';
                item.style.cursor = 'pointer';
                item.style.borderBottom = '1px solid #F3F4F6';
                item.style.display = 'flex';
                item.style.flexDirection = 'column';
                item.style.gap = '2px';
                item.style.transition = 'all 0.15s ease';

                item.innerHTML = `
                    <div style="color:#000; font-weight:700; font-size:14.5px;">${pasien.nama_pasien.toUpperCase()}</div>
                    <div style="color:#6B7280; font-size:14px; display:flex; align-items:center; gap:5px;">
                        <span>No. RM:</span>
                        <span style="font-family:monospace; font-weight:700; color:#374151;">${pasien.no_rm}</span>
                    </div>
                `;

                item.onmouseenter = () => { item.style.backgroundColor = '#EFF6FF'; item.style.paddingLeft = '24px'; };
                item.onmouseleave = () => { item.style.backgroundColor = 'white'; item.style.paddingLeft = '18px'; };

                item.onclick = function() {
                    document.getElementById('nama_pasien_input').value = pasien.nama_pasien;
                    document.getElementById('no_rm_input').value = pasien.no_rm;
                    document.getElementById('dropdown_pasien').style.display = 'none';
                    document.getElementById('dropdown_norm').style.display = 'none';
                };

                dropdown.appendChild(item);
            });
        })
        .catch(error => console.error('Error:', error));
}

document.addEventListener('click', function(e) {
    if (e.target.id !== 'nama_pasien_input' && e.target.id !== 'no_rm_input') {
        document.getElementById('dropdown_pasien').style.display = 'none';
        document.getElementById('dropdown_norm').style.display = 'none';
    }
});
</script>
@endpush