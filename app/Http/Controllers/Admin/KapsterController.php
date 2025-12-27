<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kapster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KapsterController extends Controller
{
    // INDEX
    public function index()
    {
        $kapsters = Kapster::all();
        return view('admin.kapsters.index', compact('kapsters'));
    }

    // CREATE
    public function create()
    {
        return view('admin.kapsters.create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:255',
            'bio'   => 'nullable|string', // Menambahkan validasi bio
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $kapster = new Kapster();
        $kapster->nama = $request->nama;
        $kapster->bio = $request->bio; // Menyimpan data bio

        if ($request->hasFile('photo')) {
            $kapster->photo = $request->file('photo')->store('kapsters', 'public');
        }

        $kapster->save();

        return redirect()->route('admin.kapsters.index')
            ->with('success', 'Kapster berhasil ditambahkan');
    }

    // EDIT
    public function edit(Kapster $kapster)
    {
        return view('admin.kapsters.edit', compact('kapster'));
    }

    // UPDATE
    public function update(Request $request, Kapster $kapster)
    {
        $request->validate([
            'nama'  => 'required|string|max:255',
            'bio'   => 'nullable|string', // Menambahkan validasi bio
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $kapster->nama = $request->nama;
        $kapster->bio = $request->bio; // Memperbarui data bio

        // Jika upload foto baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($kapster->photo && Storage::disk('public')->exists($kapster->photo)) {
                Storage::disk('public')->delete($kapster->photo);
            }

            // Simpan foto baru
            $kapster->photo = $request->file('photo')->store('kapsters', 'public');
        }

        $kapster->save();

        return redirect()->route('admin.kapsters.index')
            ->with('success', 'Kapster berhasil diperbarui');
    }

    // DELETE
    public function destroy(Kapster $kapster)
    {
        // Hapus file fisik foto sebelum menghapus record dari database
        if ($kapster->photo && Storage::disk('public')->exists($kapster->photo)) {
            Storage::disk('public')->delete($kapster->photo);
        }

        $kapster->delete();

        return redirect()->route('admin.kapsters.index')
            ->with('success', 'Kapster berhasil dihapus');
    }
}