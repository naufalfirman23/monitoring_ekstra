<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, Admin!');
                case 'guru':
                    return redirect()->route('guru.dashboard')->with('success', 'Selamat datang, Guru!');
                case 'siswa':
                    return redirect()->route('login')->with('error', 'Siswa Di Larang Login Disini!');
                default:
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['email' => 'Peran pengguna tidak dikenali.']);
            }

        }

        // Jika gagal, kembali ke halaman login dengan pesan error
        return redirect()->route('login')->withErrors(['email' => 'Email atau password salah.']);
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }
}
