@extends('main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-4">
        <h3>Detail Pengumuman</h3>

        <div class="card mb-3">
            <!-- Gambar Pengumuman -->
            <img src="{{ asset($pengumuman->gambar) }}" class="card-img-top" alt="Gambar Pengumuman" 
                 style="object-fit: cover; width: 100%; max-height: 400px;">
            <div class="card-body">
                <h5 class="card-title">{{ $pengumuman->judul }}</h5>
                <p class="card-text">{{ $pengumuman->deskripsi }}</p>
                <p class="card-text"><small class="text-muted">Diposting {{ $pengumuman->waktu_berlalu }}</small></p>
                <!-- Tombol Kembali -->
                <a href="{{ route('guru.dashboard') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
