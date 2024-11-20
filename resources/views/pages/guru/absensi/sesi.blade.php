@extends('main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-4">
        <h2>Sesi Pertemuan</h2>
        <div class="row">
            @foreach ($sessions as $sesi)
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <strong>Pertemuan {{ $sesi->pertemuan }}</strong><br>
                        <form action="{{ route('guru.kelas.ini.rekap', $sesi->id) }}" method="GET" class="mb-3">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary btn-lg w-100" for="sesi_{{ $sesi->id }}">
                                {{ $sesi->name }} <br> ({{ $sesi->start_time }} - {{ $sesi->end_time }})
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
