<?php

namespace App\Http\Controllers;

use App\Models\Kapster;
use App\Models\Service;
use App\Models\Booking;
use App\Models\KapsterShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CustomerBookingController extends Controller
{
    public function create()
    {
        $kapsters = Kapster::all();
        $services = Service::all();
        
        $myBookings = Booking::where('user_id', Auth::id())
            ->with(['kapster', 'services'])
            ->latest()
            ->get();

        return view('customer.bookings.create', compact('kapsters', 'services', 'myBookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kapster_id' => 'required|exists:kapsters,id',
            'service_ids' => 'required|array|min:1',
            'service_ids.*' => 'exists:services,id',
            'tgl_booking' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required',
        ]);

        return DB::transaction(function () use ($request) {
            // Ambil data layanan dari DB (Mencegah manipulasi harga/durasi dari frontend)
            $services = Service::whereIn('id', $request->service_ids)->get();
            $totalDurasi = $services->sum('durasi');
            $totalHarga = $services->sum('harga');
            
            // Inisialisasi waktu
            $jamMulaiReq = Carbon::parse($request->tgl_booking . ' ' . $request->jam_mulai);
            $jamSelesaiReq = (padding_copy($jamMulaiReq))->addMinutes($totalDurasi);

            // 1. CEK SHIFT KAPSTER (Sinkronisasi Hari dan Jam Operasional)
            $hariInput = $jamMulaiReq->translatedFormat('l'); // Mendapatkan nama hari (Senin, Selasa, dst)
            $shift = KapsterShift::where('kapster_id', $request->kapster_id)
                ->where('hari', $hariInput)
                ->first();

            // Cek apakah kapster masuk pada hari tersebut
            if (!$shift || $shift->is_libur) {
                return back()->withInput()->with('error', "MAAF, kapster sedang LIBUR pada hari $hariInput. Silakan pilih hari lain.");
            }

            // Validasi Jam Operasional (Mulai & Selesai)
            $shiftMulai = Carbon::parse($request->tgl_booking . ' ' . $shift->jam_mulai);
            $shiftSelesai = Carbon::parse($request->tgl_booking . ' ' . $shift->jam_selesai);

            if ($jamMulaiReq->lt($shiftMulai) || $jamSelesaiReq->gt($shiftSelesai)) {
                return back()->withInput()->with('error', "DI LUAR JAM KERJA. Jam operasional $hariInput: " . 
                    $shiftMulai->format('H:i') . " - " . $shiftSelesai->format('H:i'));
            }

            // 2. CEK BENTROK JADWAL (Overlap Logic)
            // lockForUpdate() mengunci baris yang sedang dicek agar tidak dibooking user lain di waktu bersamaan
            $isBentrok = Booking::where('kapster_id', $request->kapster_id)
                ->where('tgl_booking', $request->tgl_booking)
                ->where('status', 'confirmed') // Hanya cek yang statusnya confirmed/active
                ->where(function ($q) use ($request, $jamMulaiReq, $jamSelesaiReq) {
                    $q->whereBetween('jam_mulai', [$jamMulaiReq->toTimeString(), $jamSelesaiReq->subSecond()->toTimeString()])
                      ->orWhereBetween('jam_selesai', [$jamMulaiReq->addSecond()->toTimeString(), $jamSelesaiReq->toTimeString()])
                      ->orWhere(function ($sub) use ($jamMulaiReq, $jamSelesaiReq) {
                          $sub->where('jam_mulai', '<=', $jamMulaiReq->toTimeString())
                              ->where('jam_selesai', '>=', $jamSelesaiReq->toTimeString());
                      });
                })
                ->lockForUpdate()
                ->exists();

            if ($isBentrok) {
                $lastBooking = Booking::where('kapster_id', $request->kapster_id)
                    ->where('tgl_booking', $request->tgl_booking)
                    ->where('status', 'confirmed')
                    ->orderBy('jam_selesai', 'desc')
                    ->first();

                $rekomendasi = $lastBooking ? Carbon::parse($lastBooking->jam_selesai)->format('H:i') : "jam lain";
                return back()->withInput()->with('error', "Slot waktu tersebut sudah terisi. Rekomendasi waktu terdekat: jam $rekomendasi.");
            }

            // 3. SIMPAN KE TABEL bookings
            $booking = Booking::create([
                'user_id'     => Auth::id(),
                'kapster_id'  => $request->kapster_id,
                'tgl_booking' => $request->tgl_booking,
                'jam_mulai'   => $jamMulaiReq->toTimeString(),
                'jam_selesai' => $jamSelesaiReq->toTimeString(),
                'total_harga' => $totalHarga,
                'status'      => 'confirmed' 
            ]);

            $booking->services()->attach($request->service_ids);

            return redirect()->route('booking.create')->with('success', 'Booking berhasil dikonfirmasi! Sampai jumpa di barbershop.');
        });
    }

    public function destroy($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($booking->status === 'completed') {
            return back()->with('error', 'Pesanan sudah selesai dan tidak bisa dibatalkan.');
        }

        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Pesanan ini memang sudah dibatalkan sebelumnya.');
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('booking.create')->with('success', 'Jadwal booking Anda telah berhasil dibatalkan.');
    }
}

/**
 * Helper function for Carbon immutability in logic
 */
function padding_copy($carbon) {
    return clone $carbon;
}