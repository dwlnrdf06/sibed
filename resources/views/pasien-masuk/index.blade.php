@extends('layouts.app')

@section('content')

<h4 style="font-weight: bold; color: #333; margin-bottom: 5px;">Form Pasien Masuk</h4>
<div style="width: 60px; height: 4px; background: linear-gradient(135deg, #741a75, #f4c0ef); border-radius: 5px; margin-bottom: 25px;"></div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 15px rgba(0,0,0,0.08);">

    <form action="{{ route('pasien-masuk.store') }}" method="POST">
        @csrf
        <div class="row">

            {{-- NAMA PASIEN dengan autocomplete --}}
            <div class="col-md-6 mb-2" style="position: relative;">
                <label>Nama Pasien</label>
                <input type="text" id="nama_pasien_input" name="nama_pasien"
                    class="form-control" autocomplete="off"
                    placeholder="Ketik nama atau No RM untuk mencari..." required
                    oninput="cariPasien(this.value)">

                {{-- Dropdown hasil pencarian --}}
                <div id="dropdown_pasien"
                    style="display:none; position:absolute; top:100%; left:0; right:0;
                           background:white; border:1px solid #ddd; border-radius:8px;
                           box-shadow:0 4px 15px rgba(0,0,0,0.1); z-index:999;
                           max-height:250px; overflow-y:auto;">
                </div>
            </div>

            {{-- NO RM --}}
            <div class="col-md-6 mb-2">
                <label>No RM</label>
                <input type="text" id="no_rm_input" name="no_rm"
                    class="form-control" placeholder="Isi Nomor RM" required>
            </div>

            {{-- CARA MASUK --}}
            <div class="col-md-4 mb-2">
                <label>Cara Masuk</label>
                <select name="cara_masuk" id="cara_masuk" class="form-select" required>
                    <option value="">-- Pilih Cara Masuk --</option>
                    <option value="Pasien Baru">Pasien Baru</option>
                    <option value="Rujukan">Rujukan</option>
                    <option value="Pindahan Ruangan">Pindahan Ruangan</option>
                </select>
            </div>

            {{-- NAMA KAMAR --}}
            <div class="col-md-4 mb-2">
                <label>Nama Kamar</label>
                <select name="kamar_id" class="form-select" required>
                    @foreach($kamar as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kamar }} ({{ $k->kelas_kamar ?? '-' }})</option>
                    @endforeach
                </select>
            </div>

            {{-- RUJUKAN DARI --}}
            <div class="col-md-4 mb-2" id="rujukan_group">
                <label>Rujukan Dari</label>
                <input type="text" name="rujukan_dari" id="rujukan_dari"
                       class="form-control" placeholder="Isi jika rujukan">
            </div>

            {{-- PINDAHAN DARI --}}
            <div class="col-md-4 mb-2" id="pindahan_group" style="display:none;">
                <label>Pindahan Dari</label>
                <input type="text" name="pindahan_dari" id="pindahan_dari"
                       class="form-control" placeholder="Isi jika pindahan ruangan">
            </div>

            <div class="col-md-6 mb-2">
                <label>Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" class="form-control" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Kirim</button>
    </form>
</div>

<script>
// ===== AUTOCOMPLETE PASIEN =====
function cariPasien(keyword) {
    const dropdown = document.getElementById('dropdown_pasien');

    if (keyword.length < 1) {
        dropdown.style.display = 'none';
        return;
    }

    fetch(`/api/cari-pasien?q=${encodeURIComponent(keyword)}`)
        .then(res => res.json())
        .then(data => {
            console.log('Data:', data); // ← cek di console browser
            dropdown.innerHTML = '';

            if (data.length === 0) {
                dropdown.innerHTML = `<div style="padding:12px 15px; color:#999; font-size:13px;">Pasien tidak ditemukan</div>`;
                dropdown.style.display = 'block';
                return;
            }

            data.forEach(pasien => {
                const item = document.createElement('div');
                item.style.cssText = 'padding:10px 15px; cursor:pointer; border-bottom:1px solid #f0f0f0; font-size:13px;';
                item.innerHTML = `
                    <div style="font-weight:600;">${pasien.nama_pasien}</div>
                    <div style="color:#888; font-size:12px;">No RM: ${pasien.no_rm}</div>
                `;
                item.onmouseover = () => item.style.background = '#f8f0ff';
                item.onmouseout  = () => item.style.background = 'white';
                item.onclick = () => {
                    document.getElementById('nama_pasien_input').value = pasien.nama_pasien;
                    document.getElementById('no_rm_input').value        = pasien.no_rm;
                    dropdown.style.display = 'none';
                };
                dropdown.appendChild(item);
            });

            dropdown.style.display = 'block';
        })
        .catch(err => console.error('Error:', err));
}

// Tutup dropdown kalau klik di luar
document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('dropdown_pasien');
    const input    = document.getElementById('nama_pasien_input');
    if (dropdown && !dropdown.contains(e.target) && e.target !== input) {
        dropdown.style.display = 'none';
    }
});

// ===== SHOW/HIDE PINDAHAN GROUP =====
document.getElementById('cara_masuk').addEventListener('change', function () {
    const value         = this.value;
    const pindahanGroup = document.getElementById('pindahan_group');
    pindahanGroup.style.display = value === 'Pindahan Ruangan' ? 'block' : 'none';
});

document.getElementById('cara_masuk').dispatchEvent(new Event('change'));
</script>

@endsection