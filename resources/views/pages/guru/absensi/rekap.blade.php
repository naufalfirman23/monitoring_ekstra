@extends('main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-4">
        <h2>Daftar Siswa</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $student->nama }}</td>
                    <td>{{ $student->nis }}</td>
                    <td>
                        <form action="{{ route('guru.kelas.izin') }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="id_session" value="{{ $student->id_session }}">
                            <input type="hidden" name="id_user" value="{{ $student->id_user }}">
                            @if ($student->izin == 0)
                                <button type="submit" class="btn btn-warning">Dia Izin</button>
                            @else
                                <button type="submit" class="btn btn-success">Dia Hadir</button>
                            @endif
                        </form>
                        <form action="{{ route('guru.kelas.delete') }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id_session" value="{{ $student->id_session }}">
                            <input type="hidden" name="id_user" value="{{ $student->id_user }}">
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
