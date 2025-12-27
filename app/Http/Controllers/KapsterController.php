<?php

namespace App\Http\Controllers;

use App\Models\Kapster;
use Illuminate\Http\Request;

class KapsterController extends Controller
{
    // INDEX
    public function index()
    {
        $kapsters = Kapster::all();
        return view('kapsters.index', compact('kapsters'));
    }

    // CREATE
    public function create()
    {
        return view('kapsters.create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required',
            'status' => 'required',
            'photo'  => 'image|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('kapsters', 'public');
        }

        Kapster::create([
            'name'   => $request->name,
            'status' => $request->status,
            'photo'  => $photoPath,
        ]);

        return redirect()->route('kapsters.index')->with('success', 'Kapster berhasil ditambahkan');
    }

    // EDIT
    public function edit(Kapster $kapster)
    {
        return view('kapsters.edit', compact('kapster'));
    }

    // UPDATE
    public function update(Request $request, Kapster $kapster)
    {
        $request->validate([
            'name'   => 'required',
            'status' => 'required',
            'photo'  => 'image|max:2048',
        ]);

        $photoPath = $kapster->photo;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('kapsters', 'public');
        }

        $kapster->update([
            'name'   => $request->name,
            'status' => $request->status,
            'photo'  => $photoPath,
        ]);

        return redirect()->route('kapsters.index')->with('success', 'Kapster berhasil diperbarui');
    }

    // DELETE
    public function destroy(Kapster $kapster)
    {
        $kapster->delete();
        return redirect()->route('kapsters.index')->with('success', 'Kapster berhasil dihapus');
    }
}
