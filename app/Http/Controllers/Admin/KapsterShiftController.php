<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kapster;
use App\Models\KapsterShift;
use Illuminate\Http\Request;

class KapsterShiftController extends Controller
{
    // Tampilkan semua jadwal
    public function index()
    {
        // Mengambil data kapster beserta shiftnya agar rapi di view
        $kapsters = Kapster::with('shifts')->get();
        return view('admin.kapster_shifts.index', compact('kapsters'));
    }

    // Form tambah shift
    public function create()
    {
        $kapsters = Kapster::all();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        return view('admin.kapster_shifts.create', compact('kapsters', 'days'));
    }

    // Simpan shift baru
    public function store(Request $request)
    {
        $request->validate([
            'kapster_id' => 'required|exists:kapsters,id',
            'hari'       => 'required|string',
            'jam_mulai'  => 'required_if:is_libur,0',
            'jam_selesai' => 'required_if:is_libur,0',
        ]);

        // Cek apakah kapster sudah punya jadwal di hari tersebut
        $exists = KapsterShift::where('kapster_id', $request->kapster_id)
                              ->where('hari', $request->hari)
                              ->exists();

        if ($exists) {
            return back()->with('error', 'Jadwal untuk hari tersebut sudah ada.');
        }

        KapsterShift::create([
            'kapster_id'  => $request->kapster_id,
            'hari'        => $request->hari,
            'jam_mulai'   => $request->jam_mulai ?? '00:00',
            'jam_selesai' => $request->jam_selesai ?? '00:00',
            'is_libur'    => $request->has('is_libur'),
        ]);

        return redirect()->route('admin.kapster_shifts.index')
                         ->with('success', 'Shift berhasil disimpan.');
    }

    public function edit(KapsterShift $kapsterShift)
    {
        $kapsters = Kapster::all();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        return view('admin.kapster_shifts.edit', compact('kapsterShift', 'kapsters', 'days'));
    }

    public function update(Request $request, KapsterShift $kapsterShift)
    {
        $request->validate([
            'hari'       => 'required',
            'jam_mulai'  => 'required_if:is_libur,0',
            'jam_selesai' => 'required_if:is_libur,0',
        ]);

        $kapsterShift->update([
            'hari'        => $request->hari,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'is_libur'    => $request->has('is_libur'),
        ]);

        return redirect()->route('admin.kapster_shifts.index')
                         ->with('success', 'Jadwal diperbarui.');
    }

    public function destroy(KapsterShift $kapsterShift)
    {
        $kapsterShift->delete();
        return redirect()->route('admin.kapster_shifts.index')
                         ->with('success', 'Jadwal dihapus.');
    }
}