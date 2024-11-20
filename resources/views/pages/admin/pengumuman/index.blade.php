@extends('main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-4">
        <h1>Daftar Pengumuman</h1>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    
        <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-primary">Tambah Pengumuman</a>
    
        <table class="table mt-3 table-bordered">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Gambar</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengumuman as $item)
                    <tr>
                        <td>{{ $item->judul }}</td>
                        <td>{{ Str::limit($item->deskripsi, 50) }}</td> <!-- Menampilkan deskripsi terbatas -->
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td>
                            <span class="badge 
                                {{ $item->status == 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>
                            @if($item->gambar)
                                <img src="{{ asset($item->gambar) }}" alt="Gambar Pengumuman" class="img-fluid mt-3" style="max-width: 300px;">
                            @else
                                <span>No Image</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.pengumuman.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.pengumuman.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
