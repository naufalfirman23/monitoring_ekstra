<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Ekstrakurikuler;
use App\Models\KelasEkstra;
use App\Models\Pengumuman;
use App\Models\PrestasiSiswa;
use App\Models\SessionsClass;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function show(Request $request)
    {
        Log::info('User is authenticated: ', ['user' => $request->user()]);
        $id_user = $request->user()->id;
        
        $siswa = Siswa::where('id_user', $id_user)->first();
        
        return response()->json($siswa);
    }
    
    public function listEktrakurikuler()
    {
        $dataEkskul = Ekstrakurikuler::all();
        return response()->json([
            "ekstrakurikuler" => $dataEkskul
        ]);

    }

    public function registEKtra(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'id_siswa' => 'required',
            'id_guru' => 'required',
            'id_ekstrakurikuler' => 'required',
        ]);
    
        // Cek apakah kombinasi id_siswa, id_guru, id_ekstrakurikuler sudah ada
        $existingRegist = KelasEkstra::where('id_siswa', $request->id_siswa)
                                      ->where('id_guru', $request->id_guru)
                                      ->where('id_ekstrakurikuler', $request->id_ekstrakurikuler)
                                      ->first();
    
        // Jika sudah ada, beri response error
        if ($existingRegist) {
            return response()->json([
                'error' => 'Anda Sudah Mendaftar pada Kelas ini!',
            ], 400); 
        }
    
        $addRegist = KelasEkstra::create([
            'id_siswa' => $request->id_siswa,
            'id_guru' => $request->id_guru,
            'id_ekstrakurikuler' => $request->id_ekstrakurikuler,
        ]);
    
        // Cek jika pendaftaran berhasil atau gagal
        if ($addRegist) {
            return response()->json("Pendaftaran Berhasil");
        } else {
            return response()->json("Gagal Mendaftar Kelas!!");
        }
    }

    public function myListEkstrakurikuler(Request $request)
    {
        $id_user = $request->user()->id;
        $id_siswa = Siswa::where('id_user', $id_user)->first();
    
        if (!$id_siswa) {
            return response()->json([
                "status" => 404,
                "message" => "Siswa tidak ditemukan"
            ]);
        }
    
        // Ambil data dari tabel KelasEkstra termasuk nama guru
        $getKelas = KelasEkstra::where('id_siswa', $id_siswa->id)
            ->with(['guru', 'ekstrakurikuler'])
            ->get();
    
        // Map data untuk membentuk hasil respons
        $result = $getKelas->map(function ($item) {
            return [
                'id_ekstrakurikuler' => $item->ekstrakurikuler->id,
                'nama_ekstrakurikuler' => $item->ekstrakurikuler->name,
                'jadwal_ekstrakurikuler' => $item->ekstrakurikuler->jadwal,
                'status' => $item->konfirmasi,
                'deskripsi' => $item->ekstrakurikuler->description,
                'id_guru' => $item->guru->id ?? null,
                'nama_guru' => $item->guru->nama ?? null,
            ];
        });
    
        return response()->json([
            "status" => 200,
            "data" => $result
        ]);
    }

    public function inputKodeAbsen(Request $request)
    {
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
        $attendanceCode = $request->query('attendance_code');
    
        if (preg_match('/^EKS(\d+)-SES(\d+)-(\d+)-(\d+)$/', $attendanceCode, $matches)) {
            $ekstraId = $matches[1]; // Ambil ekstra_id
            $sessionId = $matches[2]; // Ambil session_id
            $waktuMulai = substr_replace($matches[3], ':', -2, 0); // Format ulang waktu_mulai
            $waktuAkhir = substr_replace($matches[4], ':', -2, 0); // Format ulang waktu_akhir
    
            $currentTime = now()->format('H:i');
            $currentDay = Carbon::now()->translatedFormat('l');
            $userId = $request->user()->id;
    
            // Cek id siswa
            $id_Siswa = Siswa::where('id_user', $userId)->first();
    
            if (!$id_Siswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maaf Anda Bukan Siswa!'
                ], 401);
            } else {
                $isEnrolled = KelasEkstra::where('id_siswa', $id_Siswa->id)
                    ->where('id_ekstrakurikuler', $ekstraId)
                    ->exists();
    
                if (!$isEnrolled) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda Tidak Mengambil Kelas Ini!'
                    ], 401);
                } else {
                    if ($currentTime > $waktuAkhir) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Maaf Bukan Waktu Presensi'
                        ], 401);
                    } else {
                        // Cek apakah kombinasi id_session dan user_id sudah ada
                        $alreadyExists = Attendance::where('id_session', $sessionId)
                            ->where('user_id', $userId)
                            ->exists();
    
                        if ($alreadyExists) {
                            return response()->json([
                                'success' => false,
                                'message' => 'Anda sudah melakukan presensi untuk sesi ini!'
                            ], 401);
                        }
    
                        // Data untuk disimpan
                        $upData = [
                            'id_session' => $sessionId,
                            'user_id' => $userId,
                        ];
    
                        $cek = Attendance::create($upData);
                        if (!$cek) {
                            return response()->json([
                                'success' => false,
                                'message' => 'Gagal Melakukan Presensi!'
                            ], 401);
                        } else {
                            return response()->json([
                                'success' => true,
                                'message' => 'Anda Berhasil Melakukan Presensi!'
                            ], 200);
                        }
                    }
                }
            }
        }
    }
    
    public function mySession(Request $request)
    {
        $userId = request()->user()->id;
        $id_ekstrakurikuler = $request->query('id_ekstrakurikuler');
        // Mengambil sesi yang dihadiri oleh user_id tertentu
        $sessions = SessionsClass::where('extracurricular_id', $id_ekstrakurikuler)
                                 ->orderBy('created_at')
                                 ->get();
        $attendedSessionIds = Attendance::where('user_id', $userId)
        ->pluck('id_session')
        ->toArray();
        
        $sessions->each(function ($session, $index) use ($attendedSessionIds) {
            $session->pertemuan = $index + 1; 
            $session->is_attended = in_array($session->id, $attendedSessionIds); 
        });



        return response()->json($sessions, 200);
    }

    public function showAllAnnouncement(Request $request)
    {
        $pengumumans = Pengumuman::where('status', 'aktif')->get();

        if ($pengumumans->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada pengumuman aktif',
            ], 404);
        }

        foreach ($pengumumans as $pengumuman) {
            // Membuat path gambar yang bisa diakses
            $pengumuman->gambar = url('storage/pengumuman/' . basename($pengumuman->gambar));
        }

        return response()->json([
            'success' => true,
            'message' => 'Daftar pengumuman aktif',
            'data' => $pengumumans,
        ]);
    }


    public function showDetailAnnounc(Request $request)
    {
        // Mengambil id dari query parameter
        $id = $request->query('id');

        // Cek apakah id diberikan
        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'ID pengumuman harus diberikan'
            ], 400);
        }

        // Mencari pengumuman berdasarkan ID dan status aktif
        $pengumuman = Pengumuman::where('id', $id)->where('status', 'aktif')->first();

        if ($pengumuman) {
            // Menambahkan URL gambar pada pengumuman
            $pengumuman->gambar = url('storage/pengumuman/' . basename($pengumuman->gambar));

            return response()->json([
                'success' => true,
                'message' => 'Detail pengumuman',
                'data' => $pengumuman,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Pengumuman tidak ditemukan atau tidak aktif',
        ], 404);
    }


    public function showMySertif()
    {
        $idUser = request()->user()->id;
    
        // Validasi jika id_user tidak dikirimkan
        if (!$idUser) {
            return response()->json([
                'success' => false,
                'message' => 'ID user tidak ditemukan dalam permintaan',
            ], 400);
        }
    
        // Ambil semua prestasi berdasarkan id_user
        $prestasi = PrestasiSiswa::where('id_user', $idUser)->get();
    
        // Cek jika data tidak ditemukan
        if ($prestasi->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan untuk user tersebut',
            ], 404);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Daftar sertifikat prestasi siswa',
            'data' => $prestasi,
        ],200);
    }

    public function detailSertif(Request $request)
    {
        $id = $request->query('id');

        // Validasi jika id tidak dikirimkan
        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'ID sertifikat tidak ditemukan dalam permintaan',
            ], 400);
        }

        // Cari detail sertifikat berdasarkan ID
        $prestasi = PrestasiSiswa::find($id);

        // Cek jika data tidak ditemukan
        if (!$prestasi) {
            return response()->json([
                'success' => false,
                'message' => 'Sertifikat tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail sertifikat prestasi siswa',
            'data' => [
                'id' => $prestasi->id,
                'id_user' => $prestasi->id_user,
                'nama_perlombaan' => $prestasi->nama_perlombaan,
                'tanggal_perlombaan' => $prestasi->tanggal_perlombaan,
                'juara' => $prestasi->juara,
                'bidang_ekstrakurikuler' => $prestasi->bidang_ekstrakurikuler,
                'sertifikat' => url('storage/' . $prestasi->file_sertifikat),
            ],
        ]);
    }

    public function pengumuman()
    {
        return response()->json([
            'data' => 'Assalammya'
        ]);
    }
    
    
    
}
