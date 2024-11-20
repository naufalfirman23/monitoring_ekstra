<!-- resources/views/kelas_ekstra/index.blade.php -->
@extends('main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-4">
        <h2>Daftar Anggota Kelas Ekstra</h2>

        <!-- Dropdown dan Tombol Mulai Kelas -->
        <div class="row">
            <div class="col-auto">
                @foreach($kelasEkstra as $item)
                <form action="{{ route('guru.kelas.kelasEkstra.mulai', $item->ekstrakurikuler->id) }}" method="POST" class="mb-3">
                    @csrf
                    @endforeach
                    <button type="submit" class="btn btn-success mt-2">Mulai Kelas</button>
                </form>
            </div>
            <div class="col-auto">
                @foreach($kelasEkstra as $item)
                <form action="{{ route('guru.kelas.rekap.absen', $item->ekstrakurikuler->id) }}" method="POST" class="mb-3">
                    @csrf
                    @endforeach
                    <button type="submit" class="btn btn-warning mt-2">Rekap Absen</button>
                </form>
            </div>
        </div>
        

        <!-- Tabel Anggota Kelas Ekstra -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Ekstrakurikuler</th>
                    <th>Siswa</th>
                    <th>Jenis Kelamin</th>
                    <th>Guru</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kelasEkstra as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->ekstrakurikuler->name }}</td>
                        <td>{{ $item->siswa->nama }}</td>
                        <td>{{ $item->siswa->jenis_kelamin }}</td>
                        <td>{{ $item->guru->nama }}</td>
                        <td>
                            @if($item->konfirmasi === '1')
                                <span class="badge bg-success">Terkonfirmasi</span>
                            @else
                                <span class="badge bg-warning">Belum Dikonfirmasi</span>
                            @endif
                        </td>
                        <td>
                            <!-- Tombol Konfirmasi -->
                            @if($item->konfirmasi === '0')
                                <form action="{{ route('guru.kelas.kelasEkstra.konfirmasi', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-primary btn-sm">Konfirmasi</button>
                                </form>
                            @else
                                <button class="btn btn-danger btn-sm" disabled>Terkonfirmasi</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
