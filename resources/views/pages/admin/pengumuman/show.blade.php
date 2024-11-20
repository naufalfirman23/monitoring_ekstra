@extends('main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-10">
        <h1>Detail Pengumuman</h1>
    
        <div class="form-group">
            <label for="judul">Judul Pengumuman</label>
            <input type="text" class="form-control" value="{{ $pengumuman->judul }}" disabled>
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi Pengumuman</label>
            <textarea class="form-control" rows="4" disabled>{{ $pengumuman->deskripsi }}</textarea>
        </div>
        <div class="form-group">
            <label for="tanggal">Tanggal Pengumuman</label>
            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($pengumuman->tanggal)->format('d M Y') }}" disabled>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <input type="text" class="form-control" value="{{ $pengumuman->status == 'aktif' ? 'Aktif' : 'Non-Aktif' }}" disabled>
        </div>
        @if($pengumuman->gambar)
            <div class="form-group">
                <label for="gambar">Gambar Pengumuman</label>
                <img src="{{ asset('storage/' . $pengumuman->gambar) }}" alt="Gambar Pengumuman" class="img-fluid mt-3" style="max-width: 300px;">
            </div>
        @endif
        <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
