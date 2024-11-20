@extends('main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-10">
        <h1>Edit User</h1>
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak diubah">
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role"  class="form-control custom-select" style="height: 50px;" required>
                    <option value="siswa" {{ $user->role == 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="guru" {{ $user->role == 'guru' ? 'selected' : '' }}>Guru</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Perbarui User</button>
        </form>
    </div>
</div>
@endsection
