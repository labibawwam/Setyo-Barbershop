<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Category; // Tambahkan ini
use Illuminate\Support\Facades\Storage; // Gunakan Facade Storage lebih aman

class ServiceController extends Controller
{
    /**
     * Tampilkan semua service beserta kategorinya.
     */
    public function index()
    {
        // Gunakan Eager Loading (with) agar lebih cepat
        $services = Service::with('category')->get();

        return view('admin.services.index', compact('services'));
    }

    /**
     * Form tambah service.
     */
    public function create()
    {
        $categories = Category::all(); // Ambil semua kategori untuk pilihan di form
        return view('admin.services.create', compact('categories'));
    }

    /**
     * Simpan data service baru.
     */
    public function store(Request $request)
    {
        // Validasi input (Tambahkan category_id)
        $request->validate([
            'category_id' => 'required|exists:categories,id', // Pastikan kategori ada
            'nama_service' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'durasi' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('services', 'public');
        }

        // Simpan ke database
        Service::create([
            'category_id' => $request->category_id, // Simpan ID Kategori
            'nama_service' => $request->nama_service,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'durasi' => $request->durasi,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Service berhasil ditambahkan!');
    }

    /**
     * Form edit.
     */
    public function edit(Service $service)
    {
        $categories = Category::all(); // Ambil kategori untuk pilihan edit
        return view('admin.services.edit', compact('service', 'categories'));
    }

    /**
     * Update service.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nama_service' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'durasi' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $gambarPath = $service->gambar;

        if ($request->hasFile('gambar')) {
            // Gunakan Storage::disk('public')->delete untuk cara Laravel yang benar
            if ($service->gambar) {
                Storage::disk('public')->delete($service->gambar);
            }
            $gambarPath = $request->file('gambar')->store('services', 'public');
        }

        $service->update([
            'category_id' => $request->category_id, // Update kategori
            'nama_service' => $request->nama_service,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'durasi' => $request->durasi,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Service berhasil diperbarui!');
    }

    /**
     * Delete service.
     */
    public function destroy(Service $service)
    {
        if ($service->gambar) {
            Storage::disk('public')->delete($service->gambar);
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service berhasil dihapus!');
    }
}