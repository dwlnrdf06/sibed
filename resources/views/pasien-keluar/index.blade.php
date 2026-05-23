@extends('layouts.app')

@section('content')

<h4 style="font-weight: bold; color: #333; margin-bottom: 5px;">
    <i class="bi bi-person-fill-dash me-2" style="color:black;"></i>
    Form Pasien Keluar
</h4>

<div style="width: 60px; height: 4px; background: blue; border-radius: 5px; margin-bottom: 25px;"></div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 15px rgba(0,0,0,0.08);">

    <form action="{{ route('pasien-keluar.store') }}" method="POST">
        @csrf

        <div class="row">

            {{-- Nama Pasien --}}
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold" style="font-size:15px; color:#6B7280;">
                    <i class="bi bi-person-fill me-1"></i>Nama Pasien <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text" style="background:#f3f4f6; border-color:#6B7280;">
                        <i class="bi bi-person-fill" style="color:#6B7280;"></i>
                    </span>
                    <input type="text" id="input_nama" class="form-control" autocomplete="off"
                        placeholder="Isi Nama Pasien Menggunakan Huruf KAPITAL" style="border-color:#6B7280;">
                </div>
                <input type="hidden" name="nama_pasien" id="nama_pasien">
            </div>

            {{-- No RM --}}
            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold" style="font-size:15px; color:#6B7280;">
                    <i class="bi bi-upc-scan me-1"></i>No RM <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text" style="background:#f3f4f6; border-color:#6B7280;">
                        <i class="bi bi-upc-scan" style="color:#6B7280;"></i>
                    </span>
                    <input type="text" id="input_norm" class="form-control" autocomplete="off"
                        placeholder="Isi No RM" style="border-color:#6B7280;">
                </div>
                <input type="hidden" name="no_rm" id="no_rm">
            </div>

            {{-- Nama Kamar --}}
            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold" style="font-size:15px; color:#6B7280;">
                    <i class="bi bi-house-door-fill me-1"></i>Nama Kamar <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text" style="background:#f3f4f6; border-color:#6B7280;">
                        <i class="bi bi-house-door-fill" style="color:#6B7280;"></i>
                    </span>
                    <select id="kamar_id" class="form-select" disabled style="border-color:#6B7280; background-color:#f9fafb; color:black;">
                        <option value="">-</option>
                        @foreach($kamar as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kamar }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="kamar_id" id="kamar_id_hidden">
            </div>

            {{-- Info Pasien --}}
            <div class="col-12 mb-2">
                <span id="info_pasien" style="font-size: 0.85em;"></span>
            </div>

            {{-- Keterangan Keluar --}}
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold" style="font-size:15px; color:#6B7280;">
                    <i class="bi bi-clipboard2-pulse-fill me-1"></i>Keterangan Keluar <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text" style="background:#f3f4f6; border-color:#6B7280;">
                        <i class="bi bi-clipboard2-pulse-fill" style="color:#6B7280;"></i>
                    </span>
                    <select name="cara_keluar" class="form-select" style="border-color:#6B7280;">
                        <option>Sembuh</option>
                        <option>Pulang Paksa</option>
                        <option>Dirujuk</option>
                        <option>Dipindahkan</option>
                        <option>Meninggal < 48 Jam</option>
                        <option>Meninggal >= 48 Jam</option>
                    </select>
                </div>
            </div>

            {{-- Dipindahkan --}}
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold" style="font-size:15px; color:#6B7280;">
                    <i class="bi bi-arrow-left-right me-1"></i> Dipindahkan
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

            {{-- Dirujuk Ke --}}
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold" style="font-size:15px; color:#6B7280;">
                    <i class="bi bi-hospital-fill me-1"></i>Dirujuk Ke
                </label>
                <div class="input-group">
                    <span class="input-group-text" style="background:#f3f4f6; border-color:#6B7280;">
                        <i class="bi bi-hospital-fill" style="color:#6B7280;"></i>
                    </span>
                    <input type="text" name="dirujuk_ke" class="form-control"
                        placeholder="Contoh: RSUD Dr. Soetomo" style="border-color:#6B7280;">
                </div>
            </div>

            {{-- Tanggal Masuk --}}
            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold" style="font-size:15px; color:#6B7280;">
                    <i class="bi bi-calendar-event-fill me-1"></i>Tgl Masuk <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text" style="background:#f3f4f6; border-color:#6B7280;">
                        <i class="bi bi-calendar-event-fill" style="color:#6B7280;"></i>
                    </span>
                    <input type="date" name="tanggal_masuk" id="tanggal_masuk"
                        class="form-control" readonly style="border-color:#6B7280;">
                </div>
            </div>

            {{-- Tanggal Keluar --}}
            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold" style="font-size:15px; color:#6B7280;">
                    <i class="bi bi-calendar2-check-fill me-1"></i>Tgl Keluar <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text" style="background:#f3f4f6; border-color:#6B7280;">
                        <i class="bi bi-calendar2-check-fill" style="color:#6B7280;"></i>
                    </span>
                    <input type="date" name="tanggal_keluar" class="form-control"
                        required style="border-color:#6B7280;">
                </div>
            </div>

        </div>

        <button type="submit" class="btn text-white mt-3"
            style="background:#1d4ed8; border:none; border-radius:10px; padding:10px 25px;">
            <i class="bi bi-send-fill me-1"></i> Kirim
        </button>

    </form>
</div>

<script>
let debounce;

function cariPasien(keyword) {
    clearTimeout(debounce);
    const info = document.getElementById('info_pasien');

    if (keyword.length < 2) {
        info.textContent = '';
        return;
    }

    info.style.color = 'gray';
    info.textContent = 'Mencari...';

    debounce = setTimeout(() => {
        fetch(`/api/cari-pasien-aktif?keyword=${encodeURIComponent(keyword)}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.found) {
                document.getElementById('input_nama').value = data.nama_pasien;
                document.getElementById('input_norm').value = data.no_rm;
                document.getElementById('nama_pasien').value = data.nama_pasien;
                document.getElementById('no_rm').value = data.no_rm;
                document.getElementById('kamar_id_hidden').value = data.kamar_id;
                document.getElementById('tanggal_masuk').value = data.tanggal_masuk;

                const select = document.getElementById('kamar_id');
                for (let opt of select.options) {
                    if (opt.value == data.kamar_id) {
                        opt.selected = true;
                        break;
                    }
                }

                info.style.color = 'green';
                info.textContent = `✅ Ditemukan: ${data.nama_pasien} — Kamar ${data.nama_kamar}`;
            } else {
                info.style.color = 'red';
                info.textContent = '❌ Pasien tidak ditemukan atau sudah keluar.';
            }
        })
        .catch(() => {
            info.style.color = 'red';
            info.textContent = '⚠️ Gagal menghubungi server.';
        });
    }, 400);
}

document.getElementById('input_nama').addEventListener('input', function() {
    cariPasien(this.value);
});

document.getElementById('input_norm').addEventListener('input', function() {
    cariPasien(this.value);
});
</script>

@endsection