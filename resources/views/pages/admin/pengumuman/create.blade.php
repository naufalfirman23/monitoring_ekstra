@extends('main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-10">
        <h1>Tambah Pengumuman</h1>
    
        <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="judul">Judul Pengumuman</label>
                <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul') }}" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi Pengumuman</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi') }}</textarea>
            </div>
            <div class="form-group">
                <label for="tanggal">Tanggal Pengumuman</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" style="height: 50px;" class="form-control" required>
                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="non-aktif" {{ old('status') == 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
            </div>
            <div class="form-group">
                <label for="gambar">Gambar Pengumuman (opsional)</label>
                <input style="height: 50px;" type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
