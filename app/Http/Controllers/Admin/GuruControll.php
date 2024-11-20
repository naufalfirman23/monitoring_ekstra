<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruControll extends Controller
{
    // Tampilkan daftar guru
    public function index()
    {
        $gurus = Guru::all(); // Mengambil semua data guru
        return view('pages.admin.gurus.index', compact('gurus'));
    }

    // Form untuk menambah guru baru
    public function create()
    {
        return view('pages.admin.gurus.create');
    }

    // Simpan data guru baru
    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Email unik untuk User
            'no_telepon' => 'required|string|max:15',
        ]);

        // Buat data guru
        $guru = Guru::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
        ]);

        // Buat akun user terkait guru
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make('guru123'), 
            'role' => 'guru',
        ]);

        // Hubungkan id_user di Guru dengan user yang baru dibuat
        $guru->update(['id_user' => $user->id]);

        return redirect()->route('admin.gurus.index')->with('success', 'Guru dan akun pengguna berhasil ditambahkan.');
    }

    // Tampilkan detail guru
    public function show($id)
    {
        $guru = Guru::findOrFail($id);
        return view('pages.admin.gurus.show', compact('guru'));
    }

    // Form untuk edit guru
    public function edit($id)
    {
        $guru = Guru::findOrFail($id);
        return view('pages.admin.gurus.edit', compact('guru'));
    }

    // Update data guru
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, // Memastikan email unik
            'no_telepon' => 'required|string|max:15',
        ]);

        $guru = Guru::findOrFail($id);
        $guru->update($request->all());

        return redirect()->route('admin.gurus.index')->with('success', 'Data guru berhasil diupdate.');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id); // Mencari guru berdasarkan ID
    
        // Ambil id_user yang terkait
        $userId = $guru->id_user;
    
        // Hapus guru
        $guru->delete(); // Menghapus data guru
    
        // Hapus pengguna terkait jika ada
        if ($userId) {
            $user = User::find($userId);
            if ($user) {
                $user->delete(); // Menghapus akun pengguna
            }
        }
    
        return redirect()->route('admin.gurus.index')->with('success', 'Guru dan akun pengguna berhasil dihapus.');
    }
}
