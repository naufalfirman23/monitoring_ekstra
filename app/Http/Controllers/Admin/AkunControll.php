<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunControll extends Controller
{
        // Menampilkan daftar user
        public function index()
        {
            $users = User::all();
            return view('pages.admin.users.index', compact('users'));
        }
    
        // Menampilkan formulir untuk menambah user
        public function create()
        {
            return view('pages.admin.users.create');
        }
    
        // Menyimpan data user baru
        public function store(Request $request)
        {
            $request->validate([
                'data_id' => 'required|exists:siswa,id|exists:guru,id',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'role' => 'required|in:siswa,guru',
            ]);
        
            User::create([
                'name' => $request->data_id, // Ambil nama dari siswa atau guru yang dipilih
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'data_id' => $request->data_id, // Simpan ID siswa atau guru
            ]);
        
            return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
        }
    
        // Menampilkan formulir untuk mengedit user
        public function edit($id)
        {
            $user = User::findOrFail($id);
            return view('pages.admin.users.edit', compact('user'));
        }
    
        // Memperbarui data user
        public function update(Request $request, $id)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'role' => 'required|in:siswa,guru',
            ]);
    
            $user = User::findOrFail($id);
            $user->update($request->only('name', 'email', 'role'));
    
            // Update password jika diisi
            if ($request->filled('password')) {
                $user->update(['password' => Hash::make($request->password)]);
            }
    
            return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
        }
        public function getDataByRole(Request $request)
        {
            $role = $request->get('role');

            if ($role == 'siswa') {
                // Mengambil data siswa
                $data = Siswa::all(); // Gantilah ini sesuai dengan model dan data yang Anda gunakan
            } elseif ($role == 'guru') {
                // Mengambil data guru
                $data = Guru::all(); // Gantilah ini sesuai dengan model dan data yang Anda gunakan
            } else {
                $data = [];
            }

            return response()->json($data);
        }

    
        // Menghapus user
        public function destroy($id)
        {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
        }
}
