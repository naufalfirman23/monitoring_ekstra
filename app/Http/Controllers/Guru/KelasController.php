<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Models\KelasEkstra;
use App\Models\SessionsClass;
use DateTime;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $guruId = auth()->user()->guru->id ?? null;
    
        if ($guruId) {
            $ekstrakurikulers = Ekstrakurikuler::where('teacher_id', $guruId)->get();
            
            // Ambil sesi yang sedang aktif dan buat array dengan kunci `extracurricular_id` dan nilai `session_id`
            $activeSessions = SessionsClass::whereNull('end_time')
                ->whereIn('extracurricular_id', $ekstrakurikulers->pluck('id'))
                ->get()
                ->keyBy('extracurricular_id'); // Menggunakan `extracurricular_id` sebagai kunci untuk pencarian mudah di Blade
    
            return view('pages.guru.kelas.index', compact('ekstrakurikulers', 'activeSessions'));
        } else {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan untuk pengguna ini.');
        }
    }

    public function show($ekstrakurikulerId)
    {
        $kelasEkstra = KelasEkstra::with(['siswa', 'guru', 'ekstrakurikuler'])
        ->where('id_ekstrakurikuler', $ekstrakurikulerId)
        ->get();


        $ekstrakurikuler = Ekstrakurikuler::findOrFail($ekstrakurikulerId);
        return view('pages.guru.kelas.show', compact('kelasEkstra', 'ekstrakurikuler'));
    }
    public function konfirmasi($id)
    {
        $kelasEkstra = KelasEkstra::findOrFail($id);
        $kelasEkstra->konfirmasi = '1';
        $kelasEkstra->save();

        return redirect()->route('guru.kelas.show', ['id' => $kelasEkstra->id_ekstrakurikuler])->with('success', 'Anggota berhasil dikonfirmasi');
    }
    public function mulaiKelas($id, Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $datetime = new DateTime();
        $hariInggris = $datetime->format('l');
        $hariIndonesia = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];
        $hari = $hariIndonesia[$hariInggris];
        $waktu = $datetime->format('H:i:s'); 
        $userId = $request->user()->id;

        $data = [
            'user_id' => $userId,
            'extracurricular_id' => $id,
            'session_date' => $hari,
            'start_time' => $waktu,
        ];

        $cek = SessionsClass::create($data);
        if ($cek) {
            return redirect()->route('guru.kelas.index')->with('success', 'Kelas berhasil dimulai.');
        }else{
            return redirect()->route('guru.kelas.show', ['id' => $id])->with('error', 'Kelas Gagal dimulai.');
        }
    }
    public function akhirKelas($id)
    {
        $cekData = SessionsClass::findOrFail($id);

        if ($cekData){
            date_default_timezone_set('Asia/Jakarta');
            $datetime = new DateTime();
            $waktu = $datetime->format('H:i:s');
    
            $cekData->update([
                'end_time' => $waktu
            ]);
            return redirect()->route('guru.kelas.index')->with('success', 'Kelas Diakhiri.');
        }else{
            return redirect()->route('guru.kelas.index')->with('error', 'Kelas tidak ditemukan.');
        }
    }

}


