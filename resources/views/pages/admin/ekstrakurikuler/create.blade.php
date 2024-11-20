<!-- resources/views/extracurriculars/create.blade.php -->
@extends('main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container">
        <h1>Tambah Ekstrakurikuler</h1>
    
        <form action="{{ route('admin.ekstrakurikuler.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Ekstrakurikuler</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
    
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3"></textarea>
            </div>
    
            <div class="form-group">
                <label for="guru_id">Pilih Guru Pembimbing:</label>
                <select name="guru_id" id="guru_id" class="form-control custom-select" style="height: 50px;">
                    <option value="">-- Pilih Guru --</option>
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label for="jadwal" class="form-label">Jadwal</label>
                <select name="jadwal" id="jadwal" class="form-control custom-select" style="height: 50px;">
                    <option value="">-- Pilih Hari --</option>
                    <option value="senin">Senin</option>
                    <option value="selasa">Selasa</option>
                    <option value="rabu">Rabu</option>
                    <option value="kamis">Kamis</option>
                    <option value="jumat">Jumat</option>
                    <option value="sabtu">Sabtu</option>
                    <option value="minggu">Minggu</option>
                </select>
            </div>
    
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.ekstrakurikuler.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
