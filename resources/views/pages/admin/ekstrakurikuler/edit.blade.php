<!-- resources/views/extracurriculars/edit.blade.php -->
@extends('main')

@section('content')

<div id="layoutSidenav_content">
    <div class="container p-10">
        <h1>Edit Ekstrakurikuler</h1>
    
        <form action="{{ route('admin.ekstrakurikuler.update', $ekstrakurikuler->id) }}" method="POST">
            @csrf
            @method('PUT')
    
            <div class="mb-3">
                <label for="name" class="form-label">Nama Ekstrakurikuler</label>
                <input type="text" name="nama" class="form-control" placeholder="{{ $ekstrakurikuler->name }}" required>
            </div>
    
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
    

            <div class="mb-3">
                <label for="guru_id" class="form-label">Pembimbing</label>
                <select name="guru_id" id="guru_id" class="form-control custom-select" style="height: 50px;">
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}" 
                            {{ $ekstrakurikuler->teacher_id == $guru->id ? 'selected' : '' }}>
                            {{ $guru->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="jadwal" class="form-label">Jadwal</label>
                <select name="jadwal" id="jadwal" class="form-control custom-select" style="height: 50px;">
                    <option value="{{ $ekstrakurikuler->jadwal }}">{{ $ekstrakurikuler->jadwal }}</option>
                    <option value="senin">Senin</option>
                    <option value="selasa">Selasa</option>
                    <option value="rabu">Rabu</option>
                    <option value="kamis">Kamis</option>
                    <option value="jumat">Jumat</option>
                    <option value="sabtu">Sabtu</option>
                    <option value="minggu">Minggu</option>
                </select>
            </div>
    
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('admin.ekstrakurikuler.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

</div>
@endsection
