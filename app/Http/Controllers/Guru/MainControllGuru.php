<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MainControllGuru extends Controller
{

    public function index(Request $request)
    {
        // Mengambil pengumuman dengan status aktif
        $pengumumans = Pengumuman::where('status', 'aktif')->get();
    
        // Menambahkan informasi waktu yang sudah berlalu dari 'created_at'
        $pengumumans->map(function ($pengumuman) {
            // Menghitung waktu yang sudah berlalu dari created_at hingga sekarang
            $pengumuman->waktu_berlalu = Carbon::parse($pengumuman->created_at)->diffForHumans();
            return $pengumuman;
        });
    
        // Mengirim data pengumuman dengan informasi waktu berlalu ke view
        return view('pages.guru.home', compact('pengumumans'));
    }

    public function show($id)
    {
        // Ambil pengumuman berdasarkan ID
        $pengumuman = Pengumuman::findOrFail($id);
    
        // Menghitung waktu yang sudah berlalu dari created_at hingga sekarang
        $pengumuman->waktu_berlalu = Carbon::parse($pengumuman->created_at)->diffForHumans();
    
        // Kirim data pengumuman ke view
        return view('pages.guru.pengumuman', compact('pengumuman'));
    }
    

}
