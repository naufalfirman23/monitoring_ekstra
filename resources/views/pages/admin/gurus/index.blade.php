@extends('main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-4">
        <h1>Daftar Guru</h1>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    
        <a href="{{ route('admin.gurus.create') }}" class="btn btn-primary">Tambah Guru</a>
    
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No Telepon</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gurus as $guru)
                    <tr>
                        <td>{{ $guru->nama }}</td>
                        <td>{{ $guru->email }}</td>
                        <td>{{ $guru->no_telepon }}</td>
                        <td>
                            <a href="{{ route('admin.gurus.edit', $guru->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.gurus.destroy', $guru->id) }}" method="POST" style="display:inline;">
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
