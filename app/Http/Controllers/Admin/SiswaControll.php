<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaControll extends Controller
{
       // Tampilkan daftar siswa
       public function index()
       {
           $siswas = Siswa::all();
           return view('pages.admin.siswa.index', compact('siswas'));
       }
   
       // Form untuk menambah siswa baru
       public function create()
       {
           return view('pages.admin.siswa.create');
       }
   
       // Simpan data siswa baru
       public function store(Request $request)
       {
           $request->validate([
               'nama' => 'required|string|max:255',
               'email' => 'required|email|unique:users,email',
               'no_telepon' => 'required|string|max:15',
               'jenis_kelamin' => 'required',
               'tanggal_lahir' => 'required|date',
           ]);
       
           // Hitung NIS terakhir
           $lastNis = Siswa::latest('id')->value('nis'); // Ambil NIS terakhir berdasarkan ID tertinggi
           if ($lastNis) {
               $lastNumber = (int) substr($lastNis, 1); // Ambil bagian angka dari NIS terakhir
               $newNis = 'S' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT); // Tambahkan 1 dan format ulang
           } else {
               $newNis = 'S0001'; // Jika belum ada data, mulai dari S0001
           }

       
           // Buat data siswa
           $siswa = Siswa::create([
               'nis' => $newNis,
               'nama' => $request->nama,
               'email' => $request->email,
               'jenis_kelamin' => $request->jenis_kelamin,
               'no_telepon' => $request->no_telepon,
               'tanggal_lahir' => $request->tanggal_lahir,
           ]);
       
           // Buat akun user terkait siswa
           $tanggalTanpaMinus = str_replace('-', '', $request->tanggal_lahir);
           $user = User::create([
               'name' => $request->nama,
               'email' => $request->email,
               'password' => Hash::make($tanggalTanpaMinus),
               'role' => 'siswa',
           ]);
           $siswa->update(['id_user' => $user->id]);
       
           return redirect()->route('admin.siswa.index')->with('success', 'Siswa dan akun pengguna berhasil ditambahkan.');
       }
       
   
       // Tampilkan detail siswa
       public function show($id)
       {
           $siswa = Siswa::findOrFail($id);
           return view('pages.admin.siswa.show', compact('siswa'));
       }
   
       // Form untuk edit siswa
       public function edit($id)
       {
           $siswa = Siswa::findOrFail($id);
           return view('pages.admin.siswa.edit', compact('siswa'));
       }
   
       // Update data siswa
       public function update(Request $request, $id)
       {
           $request->validate([
               'nama' => 'required|string|max:255',
               'email' => 'required|email|unique:siswas,email,' . $id,
               'no_telepon' => 'required|string|max:15',
               'id_user' => 'required|integer|exists:users,id',
               'tanggal_lahir' => 'required|date',
           ]);
   
           $siswa = Siswa::findOrFail($id);
           $siswa->update($request->all());
   
           return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diupdate');
       }
   
        // Menghapus data siswa dan akun pengguna terkait
        public function destroy($id)
        {
            $siswa = Siswa::findOrFail($id); // Mencari siswa berdasarkan ID

            // Ambil id_user yang terkait
            $userId = $siswa->id_user;

            // Hapus siswa
            $siswa->delete(); // Menghapus data siswa

            // Hapus pengguna terkait jika ada
            if ($userId) {
                $user = User::find($userId);
                if ($user) {
                    $user->delete(); // Menghapus akun pengguna
                }
            }

            return redirect()->route('admin.siswa.index')->with('success', 'Siswa dan akun pengguna berhasil dihapus.');
        }

}
