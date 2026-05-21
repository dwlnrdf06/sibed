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
                    placeholder="Masukkan Nama Pasien" required
                    oninput="cariPasien(this.value)">
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

            {{-- RUJUKAN DARI (untuk Rujukan) --}}
            <div class="col-md-4 mb-2" id="rujukan_group" style="display:none;">
                <label>Rujukan Dari</label>
                <input type="text" name="rujukan_dari" id="rujukan_dari"
                       class="form-control" placeholder="Isi jika rujukan">
            </div>

            {{-- PINDAHAN DARI (dropdown) --}}
            <div class="col-md-4 mb-2" id="pindahan_group" style="display:none;">
                <label>Pindahan Dari</label>
                <select name="pindahan_dari" id="pindahan_dari" class="form-select">
                    <option value="">-- Pilih Kamar Asal --</option>
                    <optgroup label="Kelas 1">
                        <option value="Tulip 1a">Tulip 1a - Reguler (Kelas 1)</option>
                        <option value="Tulip 1b">Tulip 1b - Reguler (Kelas 1)</option>
                        <option value="Tulip 1c">Tulip 1c - Reguler (Kelas 1)</option>
                        <option value="Tulip 1d">Tulip 1d - Reguler (Kelas 1)</option>
                        <option value="Tulip 1e">Tulip 1e - Reguler (Kelas 1)</option>
                    </optgroup>
                    <optgroup label="Kelas 2">
                        <option value="Flamboyan 2a">Flamboyan 2a - Reguler (Kelas 2)</option>
                        <option value="Flamboyan 2b">Flamboyan 2b - Reguler (Kelas 2)</option>
                        <option value="Flamboyan 2c">Flamboyan 2c - Reguler (Kelas 2)</option>
                        <option value="Flamboyan 2d">Flamboyan 2d - Reguler (Kelas 2)</option>
                        <option value="Flamboyan 2e">Flamboyan 2e - Reguler (Kelas 2)</option>
                    </optgroup>
                    <optgroup label="Kelas 3">
                        <option value="Melati 3a">Melati 3a - Reguler (Kelas 3)</option>
                        <option value="Melati 3b">Melati 3b - Reguler (Kelas 3)</option>
                        <option value="Melati 3c">Melati 3c - Reguler (Kelas 3)</option>
                        <option value="Melati 3d">Melati 3d - Reguler (Kelas 3)</option>
                    </optgroup>
                    <optgroup label="VIP">
                        <option value="Mawar a">Mawar a - VIP</option>
                        <option value="Mawar b">Mawar b - VIP</option>
                        <option value="Mawar c">Mawar c - VIP</option>
                    </optgroup>
                    <optgroup label="VVIP">
                        <option value="Anggrek a">Anggrek a - VVIP</option>
                        <option value="Anggrek b">Anggrek b - VVIP</option>
                        <option value="Anggrek c">Anggrek c - VVIP</option>
                    </optgroup>
                </select>
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
document.getElementById('cara_masuk').addEventListener('change', function () {
    const value = this.value;
    const rujukanGroup  = document.getElementById('rujukan_group');
    const pindahanGroup = document.getElementById('pindahan_group');

    rujukanGroup.style.display  = 'none';
    pindahanGroup.style.display = 'none';

    if (value === 'Rujukan') {
        rujukanGroup.style.display = 'block';
    } else if (value === 'Pindahan Ruangan') {
        pindahanGroup.style.display = 'block';
    }
});

// trigger awal
document.getElementById('cara_masuk').dispatchEvent(new Event('change'));
</script>

@endsection