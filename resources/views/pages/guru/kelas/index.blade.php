@extends('main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-4">
        <h2 class="mb-4">Ekstrakurikuler yang Tersedia</h2>
        <p class="text-muted">Pilih dan lihat informasi kegiatan ekstrakurikuler yang tersedia di bawah ini:</p>
        
        <div class="row">
            @foreach ($ekstrakurikulers as $ekstrakurikuler)
            <div class="col-md-4 mb-4">
                <div class="card card-waves h-100 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0 text-white">{{ $ekstrakurikuler->name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong><i class="fas fa-calendar-day"></i> Jadwal:</strong> 
                            <span>{{ $ekstrakurikuler->jadwal }}</span>
                        </div>
                        <div class="mb-3">
                            <strong><i class="fas fa-info-circle"></i> Deskripsi:</strong> 
                            <p class="text-muted">{{ $ekstrakurikuler->description }}</p>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        @if ($activeSessions->has($ekstrakurikuler->id))
                            <form action="{{ route('guru.kelas.kelasEkstra.akhir', $activeSessions[$ekstrakurikuler->id]->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">Akhiri Kelas</button>
                            </form>
                        @else
                            <a href="{{ route('guru.kelas.show', $ekstrakurikuler->id) }}" class="btn btn-outline-primary btn-sm">Selengkapnya</a>
                        @endif
                    </div>
                    
                </div>
            </div>
        @endforeach
        </div>
    </div>
</div>
@endsection
