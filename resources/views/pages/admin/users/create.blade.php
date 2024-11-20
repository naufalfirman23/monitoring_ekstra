@extends('main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-10">
        <h1>Tambah User</h1>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="role">Pilih Role</label>
                <select id="role" name="role" class="form-control">
                    <option value="">-- Pilih Role --</option>
                    <option value="siswa">Siswa</option>
                    <option value="guru">Guru</option>
                </select>
            </div>
        
            <div class="form-group" id="data-select" style="display: none;">
                <label for="data_id">Pilih Siswa/Guru</label>
                <select id="data_id" name="data_id" class="form-control">
                    <option value="">-- Pilih --</option>
                    <!-- Opsi akan ditambahkan dengan jQuery -->
                </select>
            </div>
    
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-success">Tambah User</button>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#role').change(function() {
            var role = $(this).val();
            var dataId = $('#data_id');
            var dataSelect = $('#data-select');

            // Kosongkan opsi sebelumnya
            dataId.empty();
            dataId.append('<option value="">-- Pilih --</option>');

            if (role) {
                dataSelect.show(); // Tampilkan dropdown siswa/guru
                $.ajax({
                    url: '/admin/users/data',
                    type: 'GET',
                    data: { role: role },
                    success: function(data) {
                        // Tambahkan data ke dropdown
                        $.each(data, function(key, item) {
                            dataId.append('<option value="' + item.id + '">' + item.nama + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            } else {
                dataSelect.hide(); // Sembunyikan dropdown jika tidak ada role yang dipilih
            }
        });
    });
</script>
@endsection


