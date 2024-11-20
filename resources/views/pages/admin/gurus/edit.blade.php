@extends('main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-10">
        <h1>Edit Guru</h1>
    
        <form action="{{ route('admin.gurus.update', $guru->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ $guru->nama }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $guru->email }}" required>
            </div>
            <div class="form-group">
                <label for="no_telepon">No Telepon</label>
                <input type="text" name="no_telepon" id="no_telepon" class="form-control" value="{{ $guru->no_telepon }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.gurus.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
