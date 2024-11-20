<!-- resources/views/ekstrakurikulers/index.blade.php -->
@extends('main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-4">
        <h1>Daftar Ekstrakurikuler</h1>
        <a href="{{ route('admin.ekstrakurikuler.create') }}" class="btn btn-primary mb-3">Tambah Ekstrakurikuler</a>
    
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Guru</th>
                    <th>Deskripsi</th>
                    <th>Jadwal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ekstrakurikulers as $extracurricular)
                    <tr>
                        <td>{{ $extracurricular->id }}</td>
                        <td>{{ $extracurricular->name }}</td>
                        <td>{{ $extracurricular->pembimbing ? $extracurricular->pembimbing->nama : 'Belum ditentukan' }}</td>
                        <td>{{ $extracurricular->description }}</td>
                        <td>{{ $extracurricular->jadwal }}</td>
                        <td>
                            <a href="{{ route('admin.ekstrakurikuler.edit', $extracurricular->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.ekstrakurikuler.destroy', $extracurricular->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
