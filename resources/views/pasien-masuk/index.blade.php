@extends('layouts.app')

@section('content')

{{-- JUDUL --}}
<h4 style="font-weight: bold; color: #333; margin-bottom: 5px;">Form Pasien Masuk</h4>
<div style="width: 60px; height: 4px; background: linear-gradient(135deg, #741a75, #f4c0ef); border-radius: 5px; margin-bottom: 25px;"></div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- CARD --}}
<div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 15px rgba(0,0,0,0.08);">

    <form action="{{ route('pasien-masuk.store') }}" method="POST">
        @csrf
        <div class="row">

            {{-- NAMA PASIEN dengan autocomplete --}}
            <div class="col-md-6 mb-2" style="position: relative;">
                <label>Nama Pasien</label>
                <input type="text" id="nama_pasien_input" name="nama_pasien"
                    class="form-control" autocomplete="off"
                    placeholder="Masukkan Nama Pasien" required
                    oninput="cariPasien(this.value)">

                {{-- Dropdown hasil pencarian --}}
                <div id="dropdown_pasien"
                    style="display:none; position:absolute; top:100%; left:0; right:0;
                           background:white; border:1px solid #ddd; border-radius:8px;
                           box-shadow:0 4px 15px rgba(0,0,0,0.1); z-index:999;
                           max-height:250px; overflow-y:auto;">
                </div>

                {{-- Hidden input untuk pasien_id kalau pasien lama --}}
                <input type="hidden" id="pasien_id_input" name="pasien_id">
            </div>

            {{-- NO RM --}}
            <div class="col-md-6 mb-2">
                <label>No RM</label>
                <input type="text" id="no_rm_input" name="no_rm"
                    class="form-control" placeholder="Isi Nomor RM" required>
            </div>

            <div class="col-md-4 mb-2">
                <label>Cara Masuk</label>
                <select name="cara_masuk" class="form-select">
                    <option>Pasien Baru</option>
                    <option>Rujukan</option>
                    <option>Pindahan Ruangan</option>
                </select>
            </div>
            <div class="col-md-4 mb-2">
                <label>Nama Kamar</label>
                <select name="kamar_id" class="form-select">
                    @foreach($kamar as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kamar }} ({{ $k->kelas_kamar }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-2">
                <label>Rujukan Dari</label>
                <input type="text" name="rujukan_dari" class="form-control" placeholder="Isi jika rujukan">
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
function cariPasien(keyword) {
    const dropdown = document.getElementById('dropdown_pasien');

    if (keyword.length < 1) {
        dropdown.style.display = 'none';
        return;
    }

    fetch(`/api/cari-pasien?q=${encodeURIComponent(keyword)}`)
        .then(res => res.json())
        .then(data => {
            dropdown.innerHTML = '';

            if (data.length === 0) {
                dropdown.innerHTML = `
                    <div style="padding:12px 15px; color:#999; font-size:13px;">
                        Pasien baru — data akan disimpan otomatis
                    </div>`;
                dropdown.style.display = 'block';
                document.getElementById('no_rm_input').value = '';
                document.getElementById('pasien_id_input').value = '';
                return;
            }

            data.forEach(pasien => {
                const item = document.createElement('div');
                item.style.cssText = 'padding:10px 15px; cursor:pointer; border-bottom:1px solid #f0f0f0; font-size:13px;';
                item.innerHTML = `
                    <div style="font-weight:600; color:#333;">${pasien.nama_pasien}</div>
                    <div style="color:#888; font-size:12px;">No RM: ${pasien.no_rm}</div>`;

                item.onmouseover = () => item.style.background = '#f8f0ff';
                item.onmouseout  = () => item.style.background = 'white';

                item.onclick = () => {
                    document.getElementById('nama_pasien_input').value = pasien.nama_pasien;
                    document.getElementById('no_rm_input').value        = pasien.no_rm;
                    document.getElementById('pasien_id_input').value    = pasien.id;
                    dropdown.style.display = 'none';
                };

                dropdown.appendChild(item);
            });

            dropdown.style.display = 'block';
        });
}

// Tutup dropdown kalau klik di luar
document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('dropdown_pasien');
    const input    = document.getElementById('nama_pasien_input');
    if (!dropdown.contains(e.target) && e.target !== input) {
        dropdown.style.display = 'none';
    }
});
</script>

@endsection