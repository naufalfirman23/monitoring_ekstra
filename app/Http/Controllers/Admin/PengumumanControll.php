<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengumumanControll extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::all(); 
        return view('pages.admin.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('pages.admin.pengumuman.create');
    }
    
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'status' => 'required|in:aktif,non-aktif',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Menyimpan gambar jika ada
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            // Mendapatkan file gambar yang diupload
            $file = $request->file('gambar');
            
            // Menyimpan gambar ke folder public/pengumuman dan mendapatkan nama file
            $fileName = $file->getClientOriginalName(); // Mendapatkan nama asli file
            
            // Menyimpan file dengan nama aslinya
            $file->storeAs('public/pengumuman', $fileName);
            
            // Membuat path yang sesuai dengan URL yang akan diakses
            $gambarPath = 'storage/pengumuman/' . $fileName;
        }
    
        // Membuat pengumuman baru
        Pengumuman::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'gambar' => $gambarPath,
        ]);
    
        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan!');
    }
    
    // Menampilkan form edit pengumuman
    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('pages.admin.pengumuman.edit', compact('pengumuman'));
    }

    // Memperbarui data pengumuman
    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'status' => 'required|in:aktif,non-aktif',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);

        // Menghapus gambar lama jika ada dan gambar baru di-upload
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($pengumuman->gambar && Storage::exists($pengumuman->gambar)) {
                Storage::delete($pengumuman->gambar);
            }

            // Simpan gambar baru
            $gambarPath = $request->file('gambar')->store('public/pengumuman');
            $pengumuman->gambar = $gambarPath;
        }

        // Update data pengumuman
        $pengumuman->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui!');
    }

    // Menghapus pengumuman
    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        // Hapus gambar jika ada
        if ($pengumuman->gambar && Storage::exists($pengumuman->gambar)) {
            Storage::delete($pengumuman->gambar);
        }

        $pengumuman->delete();
        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dihapus!');
    }
}
