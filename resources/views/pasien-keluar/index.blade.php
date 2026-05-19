@extends('layouts.app')

@section('content')

<h4 style="font-weight: bold; color: #333; margin-bottom: 5px;">Form Pasien Keluar</h4>
<div style="width: 60px; height: 4px; background: linear-gradient(135deg, #741a75, #741a75); border-radius: 5px; margin-bottom: 25px;"></div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 15px rgba(0,0,0,0.08);">

    <form action="{{ route('pasien-keluar.store') }}" method="POST">
        @csrf
        <div class="row">

            {{-- INPUT UTAMA: ketik nama atau no RM di sini --}}
            <div class="col-md-6 mb-2">
                <label>Nama Pasien</label>
                <input type="text" id="input_nama" class="form-control" autocomplete="off">
                {{-- hidden: nilai asli yang dikirim ke server --}}
                <input type="hidden" name="nama_pasien" id="nama_pasien">
            </div>

            <div class="col-md-3 mb-2">
                <label>No RM</label>
                <input type="text" id="input_norm" class="form-control" autocomplete="off">
                <input type="hidden" name="no_rm" id="no_rm">
            </div>

            <div class="col-md-3 mb-2">
                <label>Nama Kamar</label>
                <select name="kamar_id" id="kamar_id" class="form-select" disabled>
                    <option value="">-- otomatis --</option>
                    @foreach($kamar as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kamar }}</option>
                    @endforeach
                </select>
                {{-- fallback hidden agar kamar_id tetap terkirim walau select disabled --}}
                <input type="hidden" name="kamar_id" id="kamar_id_hidden">
            </div>

            {{-- Info status pencarian --}}
            <div class="col-12 mb-2">
                <span id="info_pasien" style="font-size: 0.85em;"></span>
            </div>

            <div class="col-md-6 mb-2">
                <label>Keterangan Keluar</label>
                <select name="cara_keluar" class="form-select">
                    <option>Sembuh</option>
                    <option>Pulang Paksa</option>
                    <option>Dirujuk</option>
                    <option>Dipindahkan</option>
                    <option>Meninggal < 48 Jam</option>
                    <option>Meninggal >= 48 Jam</option>
                </select>
            </div>

            <div class="col-md-3 mb-2">
                <label>Tgl Masuk</label>
                <input type="date" name="tanggal_masuk" id="tanggal_masuk" 
                       class="form-control" readonly>
            </div>

            <div class="col-md-3 mb-2">
                <label>Tgl Keluar</label>
                <input type="date" name="tanggal_keluar" class="form-control" required>
            </div>

            <div class="col-md-6 mb-2">
                <label>Dirujuk Ke</label>
                <input type="text" name="dirujuk_ke" class="form-control" 
                       placeholder="Contoh: RSUD Dr. Soetomo">
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Kirim</button>
    </form>

</div>

{{-- ===== JAVASCRIPT AUTO-FILL ===== --}}
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
                    // Isi field tampilan
                    document.getElementById('input_nama').value = data.nama_pasien;
                    document.getElementById('input_norm').value  = data.no_rm;

                    // Isi hidden field (yang dikirim ke server)
                    document.getElementById('nama_pasien').value = data.nama_pasien;
                    document.getElementById('no_rm').value       = data.no_rm;
                    document.getElementById('kamar_id_hidden').value = data.kamar_id;
                    document.getElementById('tanggal_masuk').value   = data.tanggal_masuk;

                    // Pilih kamar di select
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

// Trigger dari kolom Nama Pasien
document.getElementById('input_nama').addEventListener('input', function() {
    cariPasien(this.value);
});

// Trigger dari kolom No RM
document.getElementById('input_norm').addEventListener('input', function() {
    cariPasien(this.value);
});
</script>

@endsection