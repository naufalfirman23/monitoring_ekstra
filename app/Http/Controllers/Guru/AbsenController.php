<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Ekstrakurikuler;
use App\Models\KelasEkstra;
use App\Models\SessionsClass;
use App\Models\Siswa;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AbsenController extends Controller
{
    public function index()
    {
        $guruId = auth()->user()->guru->id ?? null;
        if ($guruId) {
            $dataSesi = SessionsClass::with('ekstra')->where('user_id', auth()->user()->id)->get();
            $dataKelas = Ekstrakurikuler::where('teacher_id', $guruId)->get();
        
            return view('pages.guru.absensi.index', compact('dataKelas', 'dataSesi'));
        } else {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan untuk pengguna ini.');
        }

    }
    // AttendanceController.php
    public function generate(Request $request)
    {
        $ekstraId = $request->input('ekstra_id');
        $sessionId = $request->input('session_id');
        $waktuMulai = $request->input('waktu_mulai');
        $waktuAkhir = $request->input('waktu_akhir');
    
        // Contoh kode absen
        $attendanceCode = "EKS{$ekstraId}-SES{$sessionId}-" . str_replace(':', '', $waktuMulai) . "-" . str_replace(':', '', $waktuAkhir);
    
        // Simpan kode absen jika diperlukan, lalu kirim respons JSON
        return response()->json([
            'success' => true,
            'attendanceCode' => $attendanceCode
        ]);
    }

    public function getSesi($id, Request $request)
    {
        $userId = request()->user()->id;
        $sessions = SessionsClass::where('extracurricular_id', $id)
                                 ->orderBy('created_at')
                                 ->get();
        $attendedSessionIds = Attendance::where('user_id', $userId)
        ->pluck('id_session')
        ->toArray();
        
        $sessions->each(function ($session, $index) use ($attendedSessionIds) {
            $session->pertemuan = $index + 1; 
            $session->is_attended = in_array($session->id, $attendedSessionIds); 
        });

        return view('pages.guru.absensi.sesi', compact('sessions'));
    }

    public function getRekap(Request $request)
    {
        $sesiId = $request->input('sesi_id');

        // Ambil data kehadiran berdasarkan sesi
        $attendance = Attendance::where('sesi_id', $sesiId)->get();
    
        return response()->json([
            'attendance' => $attendance->map(function ($item) {
                return [
                    'student_name' => $item->student->name,
                    'status' => $item->status,
                    'attendance_time' => $item->created_at->format('H:i:s')
                ];
            }),
        ]);
    }

    public function absennya($id)
    {
        // Mengambil data absensi berdasarkan id_session
        $rekap = Attendance::where('id_session', $id)->get();
    
        // Mendapatkan user_id dari setiap item absensi
        $userIds = $rekap->pluck('user_id'); // Mendapatkan semua user_id dalam koleksi
    
        // Mengambil data siswa berdasarkan user_id
        $students = Siswa::whereIn('id_user', $userIds)
            ->get()
            ->map(function ($student) use ($rekap, $id) {
                // Tambahkan id_session ke setiap student
                $student->id_session = $id;
    
                // Cari data izin dari rekapan
                $attendance = $rekap->where('user_id', $student->id_user)->first();
                $student->izin = $attendance ? $attendance->izin : null;
    
                return $student;
            });
    
        // Mengirimkan data siswa ke view
        return view('pages.guru.absensi.rekap', compact('students'));
    }
    
    

    public function izin(Request $request)
    {
        $id_session = $request->input('id_session');
        $id_user = $request->input('id_user');
    
        $attendance = Attendance::where('id_session', $id_session)
                                ->where('user_id', $id_user)
                                ->firstOrFail();
        

        if ($attendance->izin == "1") {
            $attendance->izin = "0";
            $attendance->save();
            return redirect()->route('guru.kelas.ini.rekap', ['id' => $id_session])->with('success', 'Status izin berhasil diperbarui.');
        }
        $attendance->izin = "1";
        $attendance->save();

        return redirect()->route('guru.kelas.ini.rekap', ['id' => $id_session])->with('success', 'Status izin berhasil diperbarui.');
    }

    public function delete(Request $request)
    {
        $id_session = $request->input('id_session');
        $id_user = $request->input('id_user');
    
        $attendance = Attendance::where('id_session', $id_session)
                                ->where('user_id', $id_user)
                                ->firstOrFail();
        

        $attendance->delete();

        return redirect()->route('guru.kelas.ini.rekap', ['id' => $id_session])->with('success', 'Berhasil dihapus.');
    }
    
    
    


    


    

}
