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

            {{-- NAMA PASIEN --}}
            <div class="col-md-6 mb-2" style="position: relative;">
                <label>Nama Pasien</label>
                <input type="text" id="nama_pasien_input" name="nama_pasien"
                    class="form-control" autocomplete="off"
                    placeholder="Ketik nama untuk mencari..." required
                    oninput="cariPasien(this.value, 'nama')">
                <div id="dropdown_pasien"
                    style="display:none; position:absolute; top:100%; left:0; right:0;
                           background:white; border:1px solid #ddd; border-radius:8px;
                           box-shadow:0 4px 15px rgba(0,0,0,0.1); z-index:999;
                           max-height:250px; overflow-y:auto;">
                </div>
            </div>

            {{-- NO RM --}}
            <div class="col-md-6 mb-2" style="position: relative;">
                <label>No RM</label>
                <input type="text" id="no_rm_input" name="no_rm"
                    class="form-control" autocomplete="off"
                    placeholder="Ketik No RM untuk mencari..." required
                    oninput="cariPasien(this.value, 'norm')">
                <div id="dropdown_norm"
                    style="display:none; position:absolute; top:100%; left:0; right:0;
                           background:white; border:1px solid #ddd; border-radius:8px;
                           box-shadow:0 4px 15px rgba(0,0,0,0.1); z-index:999;
                           max-height:250px; overflow-y:auto;">
                </div>
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
            <div class="col-md-4 mb-2">
                <label>Rujukan Dari</label>
                <input type="text" name="rujukan_dari" id="rujukan_dari"
                       class="form-control" placeholder="Isi jika rujukan">
            </div>

            {{-- PINDAHAN DARI --}}
            <div class="col-md-4 mb-2">
                <label>Pindahan Dari</label>
                <select name="pindahan_dari" id="pindahan_dari" class="form-select">
                    <option value="">-- Pilih Kamar Asal --</option>
                    <optgroup label="Kelas 1">
                        <option value="Tulip 1a (Kelas 1)">Tulip 1a (Kelas 1)</option>
                        <option value="Tulip 1b (Kelas 1)">Tulip 1b (Kelas 1)</option>
                        <option value="Tulip 1c (Kelas 1)">Tulip 1c (Kelas 1)</option>
                        <option value="Tulip 1d (Kelas 1)">Tulip 1d (Kelas 1)</option>
                        <option value="Tulip 1e (Kelas 1)">Tulip 1e (Kelas 1)</option>
                    </optgroup>
                    <optgroup label="Kelas 2">
                        <option value="Flamboyan 2a (Kelas 2)">Flamboyan 2a (Kelas 2)</option>
                        <option value="Flamboyan 2b (Kelas 2)">Flamboyan 2b (Kelas 2)</option>
                        <option value="Flamboyan 2c (Kelas 2)">Flamboyan 2c (Kelas 2)</option>
                        <option value="Flamboyan 2d (Kelas 2)">Flamboyan 2d (Kelas 2)</option>
                        <option value="Flamboyan 2e (Kelas 2)">Flamboyan 2e (Kelas 2)</option>
                    </optgroup>
                    <optgroup label="Kelas 3">
                        <option value="Melati 3a (Kelas 3)">Melati 3a (Kelas 3)</option>
                        <option value="Melati 3b (Kelas 3)">Melati 3b (Kelas 3)</option>
                        <option value="Melati 3c (Kelas 3)">Melati 3c (Kelas 3)</option>
                        <option value="Melati 3d (Kelas 3)">Melati 3d (Kelas 3)</option>
                    </optgroup>
                    <optgroup label="VIP">
                        <option value="Mawar a (VIP)">Mawar a (VIP)</option>
                        <option value="Mawar b (VIP)">Mawar b (VIP)</option>
                        <option value="Mawar c (VIP)">Mawar c (VIP)</option>
                    </optgroup>
                    <optgroup label="VVIP">
                        <option value="Anggrek a (VVIP)">Anggrek a (VVIP)</option>
                        <option value="Anggrek b (VVIP)">Anggrek b (VVIP)</option>
                        <option value="Anggrek c (VVIP)">Anggrek c (VVIP)</option>
                    </optgroup>
                </select>
            </div>

            {{-- TANGGAL MASUK --}}
            <div class="col-md-6 mb-2">
                <label>Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" class="form-control" required>
            </div>

        </div>

        <button type="submit" class="btn btn-primary mt-3">Kirim</button>
    </form>
</div>

<script>
function cariPasien(keyword, tipe) {
    const dropdownNama = document.getElementById('dropdown_pasien');
    const dropdownNorm = document.getElementById('dropdown_norm');
    const aktif = tipe === 'norm' ? dropdownNorm : dropdownNama;

    dropdownNama.style.display = 'none';
    dropdownNorm.style.display = 'none';

    if (keyword.length < 1) return;

    fetch(`/api/cari-pasien?q=${encodeURIComponent(keyword)}`)
        .then(res => res.json())
        .then(data => {
            aktif.innerHTML = '';

            if (data.length === 0) {
                aktif.innerHTML = `<div style="padding:12px 15px; color:#999; font-size:13px;">Pasien tidak ditemukan</div>`;
                aktif.style.display = 'block';
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
                    document.getElementById('no_rm_input').value = pasien.no_rm;
                    dropdownNama.style.display = 'none';
                    dropdownNorm.style.display = 'none';
                };
                aktif.appendChild(item);
            });

            aktif.style.display = 'block';
        })
        .catch(err => console.error('Error:', err));
}

document.addEventListener('click', function(e) {
    const dropdownNama = document.getElementById('dropdown_pasien');
    const dropdownNorm = document.getElementById('dropdown_norm');
    const inputNama    = document.getElementById('nama_pasien_input');
    const inputNorm    = document.getElementById('no_rm_input');

    if (!dropdownNama.contains(e.target) && e.target !== inputNama) {
        dropdownNama.style.display = 'none';
    }
    if (!dropdownNorm.contains(e.target) && e.target !== inputNorm) {
        dropdownNorm.style.display = 'none';
    }
});
</script>

@endsection