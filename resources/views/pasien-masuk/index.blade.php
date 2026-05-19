@extends('layouts.app')

@section('content')

{{-- JUDUL --}}
<h4 style="font-weight: bold; color: #333; margin-bottom: 5px;">Form Pasien Masuk</h4>
<div style="width: 60px; height: 4px; background: linear-gradient(135deg, #741a75, #741a75); border-radius: 5px; margin-bottom: 25px;"></div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- CARD --}}
<div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 15px rgba(0,0,0,0.08);">

    <form action="{{ route('pasien-masuk.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-2">
                <label>Nama Pasien</label>
                <input type="text" name="nama_pasien" class="form-control" required>
            </div>
            <div class="col-md-6 mb-2">
                <label>No RM</label>
                <input type="text" name="no_rm" class="form-control" required>
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

@endsection