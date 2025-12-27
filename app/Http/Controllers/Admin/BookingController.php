<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Booking, User, Kapster, Service};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'kapster', 'services'])
            ->latest()
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $users = User::where('role', 'customer')->orderBy('name')->get();
        $kapsters = Kapster::orderBy('nama')->get();
        $services = Service::orderBy('nama_service')->get();

        return view('admin.bookings.create', compact('users', 'kapsters', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kapster_id' => 'required|exists:kapsters,id',
            'service_ids' => 'required|array|min:1',
            'tgl_booking' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required',
        ]);

        return DB::transaction(function () use ($request) {
            $services = Service::whereIn('id', $request->service_ids)->get();
            $totalDurasi = $services->sum('durasi');
            $totalHarga = $services->sum('harga');

            $jamMulai = Carbon::parse($request->jam_mulai);
            $jamSelesai = $jamMulai->copy()->addMinutes($totalDurasi);

            // 1. Cek Bentrok
            $isBentrok = Booking::where('kapster_id', $request->kapster_id)
                ->where('tgl_booking', $request->tgl_booking)
                ->where('status', '!=', 'cancelled')
                ->where(function ($query) use ($jamMulai, $jamSelesai) {
                    $query->where('jam_mulai', '<', $jamSelesai->format('H:i:s'))
                          ->where('jam_selesai', '>', $jamMulai->format('H:i:s'));
                })
                ->lockForUpdate()
                ->exists();

            if ($isBentrok) {
                // 2. LOGIKA REKOMENDASI: Cari jadwal terakhir kapster di hari tersebut
                $lastBooking = Booking::where('kapster_id', $request->kapster_id)
                    ->where('tgl_booking', $request->tgl_booking)
                    ->where('status', '!=', 'cancelled')
                    ->orderBy('jam_selesai', 'desc')
                    ->first();

                $rekomendasi = $lastBooking 
                    ? Carbon::parse($lastBooking->jam_selesai)->format('H:i') 
                    : $request->jam_mulai;

                return back()->withInput()->with('error', "Jadwal bentrok! Rekomendasi jadwal terdekat untuk kapster ini adalah jam $rekomendasi.");
            }

            $booking = Booking::create([
                'user_id' => $request->user_id,
                'kapster_id' => $request->kapster_id,
                'tgl_booking' => $request->tgl_booking,
                'jam_mulai' => $jamMulai->format('H:i:s'),
                'jam_selesai' => $jamSelesai->format('H:i:s'),
                'total_harga' => $totalHarga,
                'status' => 'confirmed'
            ]);

            $booking->services()->attach($request->service_ids);

            return redirect()->route('admin.bookings.index')->with('success', 'Booking manual berhasil ditambahkan.');
        });
    }

    public function edit(Booking $booking)
    {
        $kapsters = Kapster::all();
        $services = Service::all();
        return view('admin.bookings.edit', compact('booking', 'kapsters', 'services'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'kapster_id' => 'required|exists:kapsters,id',
            'service_ids' => 'required|array',
            'tgl_booking' => 'required|date',
            'jam_mulai' => 'required',
            'status' => 'required|in:pending,confirmed,completed,cancelled'
        ]);

        return DB::transaction(function () use ($request, $booking) {
            $services = Service::whereIn('id', $request->service_ids)->get();
            $totalDurasi = $services->sum('durasi');
            $totalHarga = $services->sum('harga');

            $jamMulai = Carbon::parse($request->jam_mulai);
            $jamSelesai = $jamMulai->copy()->addMinutes($totalDurasi);

            $isBentrok = Booking::where('id', '!=', $booking->id)
                ->where('kapster_id', $request->kapster_id)
                ->where('tgl_booking', $request->tgl_booking)
                ->where('status', '!=', 'cancelled')
                ->where(function ($query) use ($jamMulai, $jamSelesai) {
                    $query->where('jam_mulai', '<', $jamSelesai->format('H:i:s'))
                          ->where('jam_selesai', '>', $jamMulai->format('H:i:s'));
                })
                ->exists();

            if ($isBentrok) {
                $lastBooking = Booking::where('id', '!=', $booking->id)
                    ->where('kapster_id', $request->kapster_id)
                    ->where('tgl_booking', $request->tgl_booking)
                    ->where('status', '!=', 'cancelled')
                    ->orderBy('jam_selesai', 'desc')
                    ->first();

                $rekomendasi = $lastBooking ? Carbon::parse($lastBooking->jam_selesai)->format('H:i') : "waktu lain";

                return back()->with('error', "Jadwal baru bertabrakan. Coba jam $rekomendasi.");
            }

            $booking->update([
                'kapster_id' => $request->kapster_id,
                'tgl_booking' => $request->tgl_booking,
                'jam_mulai' => $jamMulai->format('H:i:s'),
                'jam_selesai' => $jamSelesai->format('H:i:s'),
                'total_harga' => $totalHarga,
                'status' => $request->status,
            ]);

            $booking->services()->sync($request->service_ids);

            return redirect()->route('admin.bookings.index')->with('success', 'Reservasi berhasil diperbarui.');
        });
    }

    public function destroy(Booking $booking)
    {
        return DB::transaction(function () use ($booking) {
            $booking->services()->detach();
            $booking->delete();
            return redirect()->route('admin.bookings.index')->with('success', 'Data booking telah dihapus permanen.');
        });
    }
}