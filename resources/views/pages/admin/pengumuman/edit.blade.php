@extends('main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-10">
        <h1>Edit Pengumuman</h1>
    
        <form action="{{ route('admin.pengumuman.update', $pengumuman->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="judul">Judul Pengumuman</label>
                <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul', $pengumuman->judul) }}" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi Pengumuman</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi', $pengumuman->deskripsi) }}</textarea>
            </div>
            <div class="form-group">
                <label for="tanggal">Tanggal Pengumuman</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', $pengumuman->tanggal) }}" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="aktif" {{ old('status', $pengumuman->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="non-aktif" {{ old('status', $pengumuman->status) == 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
            </div>
            <div class="form-group">
                <label for="gambar">Gambar Pengumuman (opsional)</label>
                <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                @if($pengumuman->gambar)
                    <img src="{{ asset($pengumuman->gambar) }}" alt="Gambar Pengumuman" class="img-fluid mt-3" style="max-width: 200px;">
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
