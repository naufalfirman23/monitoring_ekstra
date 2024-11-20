<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Models\Guru;
use Illuminate\Http\Request;

class EkstrakurikulerControll extends Controller
{
    // Menampilkan daftar ekstrakurikuler
    public function index()
    {
        $ekstrakurikulers = Ekstrakurikuler::with('pembimbing')->get();
        return view('pages.admin.ekstrakurikuler.index', compact('ekstrakurikulers'));
    }

    // Menampilkan form untuk membuat ekstrakurikuler baru
    public function create()
    {
        $gurus = Guru::all(); // Ambil semua data guru
        return view('pages.admin.ekstrakurikuler.create', compact('gurus'));
    }

    // Menyimpan data ekstrakurikuler baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'guru_id' => 'nullable',
            'jadwal' => 'nullable|string',
        ]);

        Ekstrakurikuler::create([
            'name' => $request->nama,
            'description' => $request->deskripsi,
            'teacher_id' => $request->guru_id,
            'jadwal' => $request->jadwal,
        ]);

        return redirect()->route('admin.ekstrakurikuler.index')->with('success', 'Ekstrakurikuler berhasil ditambahkan');
    }

    // Menampilkan data ekstrakurikuler secara detail
    public function show($id)
    {
        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);
        return view('pages.admin.ekstrakurikuler.show', compact('ekstrakurikuler'));
    }

    // Menampilkan form untuk mengedit data ekstrakurikuler
    public function edit($id)
    {
        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);
        $gurus = Guru::all();
        return view('pages.admin.ekstrakurikuler.edit', compact('ekstrakurikuler', 'gurus'));
    }

    // Memperbarui data ekstrakurikuler
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'description' => 'nullable|string',
            'guru_id' => 'nullable',
            'jadwal' => 'nullable|string',
        ]);

        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);
        $ekstrakurikuler->update([
            'name' => $request->nama,
            'description' => $request->description,
            'teacher_id' => $request->guru_id,
            'jadwal' => $request->jadwal,
        ]);

        return redirect()->route('admin.ekstrakurikuler.index')->with('success', 'Ekstrakurikuler berhasil diperbarui');
    }

    // Menghapus data ekstrakurikuler
    public function destroy($id)
    {
        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);
        $ekstrakurikuler->delete();

        return redirect()->route('admin.ekstrakurikuler.index')->with('success', 'Ekstrakurikuler berhasil dihapus');
    }
}
