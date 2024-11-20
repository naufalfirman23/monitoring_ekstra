@extends('main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-4">
        <h2>Halaman Absen</h2>

        <!-- Form untuk meng-generate kode absen -->
        <form id="generateCodeForm" class="mb-4">
            @csrf
            <div class="mb-3">
                <label for="ekstra_id" class="form-label">Pilih Ekstrakurikuler</label>
                <select name="ekstra_id" required id="ekstra_id" class="form-select">
                    <option value="">Pilih Ekstrakurikuler</option>
                    @foreach ($dataKelas as $ekstra)
                        <option value="{{ $ekstra->id }}">{{ $ekstra->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="session_id" class="form-label">Pilih Sesi Saat Ini</label>
                <select name="session_id" id="session_id" required class="form-select">
                    <option value="">Pilih Sesi</option>
                    @foreach ($dataSesi as $session)
                        @if(is_null($session->end_time))  <!-- Filter sesi yang belum berakhir -->
                            <option value="{{ $session->id }}">{{ $session->ekstra->name }} - Berlangsung</option>
                        @endif
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3 row">
                <label for="waktu_absen" class="form-label">Waktu Absen</label>
                <div class="col-6">
                    <label for="waktu_mulai" class="form-label">Mulai</label>
                    <input type="time" required name="waktu_mulai" id="waktu_mulai" class="form-control">
                </div>
                <div class="col-6">
                    <label for="waktu_akhir" class="form-label">Akhir</label>
                    <input type="time" required name="waktu_akhir" id="waktu_akhir" class="form-control">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Generate Kode Absen</button>
        </form>

        <div id="attendanceCodeResult" style="display: none;" class="alert alert-success mt-4 text-center">
            <h4>Kode Absen Anda:</h4>
            <div id="qrcode" class="d-flex justify-content-center my-3"></div>
            <p><strong id="attendanceCode" class="attendance-code"></strong></p>
        </div>
        
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    document.getElementById('generateCodeForm').addEventListener('submit', function(event) {
        event.preventDefault();

        let formData = new FormData(this);

        fetch("{{ route('guru.kelas.absen.generate') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('attendanceCode').innerText = data.attendanceCode;
                document.getElementById('attendanceCodeResult').style.display = 'block';
                
                // Clear existing QR Code before creating a new one
                document.getElementById('qrcode').innerHTML = '';  // Remove the previous QR Code
                
                if (data.attendanceCode) {
                    // Create a new QR Code
                    new QRCode(document.getElementById('qrcode'), {
                        text: data.attendanceCode,
                        width: 200,
                        height: 200
                    });
                } else {
                    alert("Please enter a valid code!");
                }
            } else {
                alert(data.message || 'Terjadi kesalahan saat membuat kode absen.');
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>
@endsection

