<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PrestasiSiswa;
use Illuminate\Http\Request;

class PrestasiController extends Controller
{
    public function prestasiStore(Request $request)
    {
        
        $request->validate([
            'nama_perlombaan' => 'required',
            'tanggal_perlombaan' => 'required|date',
            'juara_dicapai' => 'required',
            'bidang_ekstrakurikuler' => 'required',
            'file_sertifikat' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file_sertifikat')) {
            $filePath = $request->file('file_sertifikat')->store('prestasi_siswa', 'public');
        }
        $prestasi = PrestasiSiswa::create([
            'id_user' => request()->user()->id,
            'nama_perlombaan' => $request->nama_perlombaan,
            'tanggal_perlombaan' => $request->tanggal_perlombaan,
            'juara_dicapai' => $request->juara_dicapai,
            'bidang_ekstrakurikuler' => $request->bidang_ekstrakurikuler,
            'file_sertifikat' => $filePath,
        ]);
        if(!$prestasi)
        {
            return response()->json([
                'success' => false,
                'message' => 'Data prestasi siswa gagal ditambahkan',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data prestasi siswa berhasil ditambahkan',
        ], 200);
    }
}
