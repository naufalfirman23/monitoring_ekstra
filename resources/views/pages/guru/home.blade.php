@extends('main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-4">
        <h3>Pengumuman</h3>
        @foreach($pengumumans as $pengumuman)
        <div class="card mb-3">
            <!-- Gambar Pengumuman -->
            <img src="{{ asset($pengumuman->gambar) }}" class="card-img-top" alt="Gambar Pengumuman" 
                 style="object-fit: cover; width: 100%; max-height: 300px; border-radius: 0.25rem 0 0 0.25rem;">
            <div class="card-body">
                <h5 class="card-title">{{ $pengumuman->judul }}</h5>
                <p class="card-text">{{ Str::limit($pengumuman->deskripsi, 150) }}</p>
                <p class="card-text"><small class="text-muted">Diposting {{ $pengumuman->waktu_berlalu }}</small></p>
                <!-- Tombol Lihat Selengkapnya -->
                <a href="{{ route('pengumuman.show', $pengumuman->id) }}" class="btn btn-primary">Lihat Selengkapnya</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
