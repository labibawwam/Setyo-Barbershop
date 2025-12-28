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
    /**
     * Menampilkan form booking
     */
    public function create()
    {
        $kapsters = Kapster::all();
        $services = Service::all();
        
        // Mengambil semua booking confirmed untuk pengecekan jadwal di frontend
        $allBookings = Booking::whereIn('status', ['confirmed', 'pending'])
            ->select('kapster_id', 'tgl_booking', 'jam_mulai', 'jam_selesai')
            ->get();

        $myBookings = Booking::where('user_id', Auth::id())
            ->with(['kapster', 'services'])
            ->latest()
            ->get();

        // Pastikan nama view sesuai dengan folder Anda (tadi tertulis create, pastikan file ada)
        return view('customer.bookings.create', compact('kapsters', 'services', 'myBookings', 'allBookings'));
    }

    /**
     * Menyimpan data booking baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'kapster_id' => 'required|exists:kapsters,id',
            'service_ids' => 'required|array|min:1',
            'service_ids.*' => 'exists:services,id',
            'tgl_booking' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                // 1. Hitung Total Durasi & Harga berdasarkan database (keamanan extra)
                $services = Service::whereIn('id', $request->service_ids)->get();
                $totalDurasi = $services->sum('durasi');
                $totalHarga = $services->sum('harga');
                
                $jamMulaiReq = Carbon::parse($request->tgl_booking . ' ' . $request->jam_mulai);
                $jamSelesaiReq = $jamMulaiReq->copy()->addMinutes($totalDurasi);

                // 2. CEK SHIFT KAPSTER (Hari kerja & Jam operasional)
                $hariInput = $jamMulaiReq->translatedFormat('l'); 
                $shift = KapsterShift::where('kapster_id', $request->kapster_id)
                    ->where('hari', $hariInput)
                    ->first();

                if (!$shift || $shift->is_libur) {
                    return back()->withInput()->with('error', "Maaf, Kapster sedang LIBUR pada hari $hariInput.");
                }

                $shiftMulai = Carbon::parse($request->tgl_booking . ' ' . $shift->jam_mulai);
                $shiftSelesai = Carbon::parse($request->tgl_booking . ' ' . $shift->jam_selesai);

                if ($jamMulaiReq->lt($shiftMulai) || $jamSelesaiReq->gt($shiftSelesai)) {
                    return back()->withInput()->with('error', "Di luar jam kerja artist. Jam operasional: " . 
                        $shiftMulai->format('H:i') . " - " . $shiftSelesai->format('H:i'));
                }

                // 3. CEK BENTROK JADWAL (Overlap Logic)
                /* Logika Overlap yang Benar: 
                   (Mulai_Baru < Selesai_Lama) DAN (Selesai_Baru > Mulai_Lama)
                */
                
                $isBentrok = Booking::where('kapster_id', $request->kapster_id)
                    ->where('tgl_booking', $request->tgl_booking)
                    ->whereIn('status', ['confirmed', 'pending'])
                    ->where(function ($q) use ($jamMulaiReq, $jamSelesaiReq) {
                        $q->where('jam_mulai', '<', $jamSelesaiReq->toTimeString())
                          ->where('jam_selesai', '>', $jamMulaiReq->toTimeString());
                    })
                    ->lockForUpdate() // Mencegah race condition
                    ->exists();

                if ($isBentrok) {
                    $lastBooking = Booking::where('kapster_id', $request->kapster_id)
                        ->where('tgl_booking', $request->tgl_booking)
                        ->whereIn('status', ['confirmed', 'pending'])
                        ->orderBy('jam_selesai', 'desc')
                        ->first();

                    $rekomendasi = $lastBooking ? Carbon::parse($lastBooking->jam_selesai)->format('H:i') : "jam lain";
                    return back()->withInput()->with('error', "Slot waktu sudah terisi. Rekomendasi waktu kosong setelah jam $rekomendasi.");
                }

                // 4. SIMPAN DATA KE DATABASE
                $booking = Booking::create([
                    'user_id'     => Auth::id(),
                    'kapster_id'  => $request->kapster_id,
                    'tgl_booking' => $request->tgl_booking,
                    'jam_mulai'   => $jamMulaiReq->toTimeString(),
                    'jam_selesai' => $jamSelesaiReq->toTimeString(),
                    'total_harga' => $totalHarga,
                    'status'      => 'confirmed' 
                ]);

                // Pasang layanan ke tabel pivot
                $booking->services()->attach($request->service_ids);

                return redirect()->route('booking.create')->with('success', 'Booking berhasil dikonfirmasi!');
            });
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan sistem. Silakan coba beberapa saat lagi.');
        }
    }

    /**
     * Membatalkan booking
     */
    public function cancel($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Validasi status sebelum cancel
        if (in_array($booking->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'Pesanan sudah selesai atau sudah dibatalkan sebelumnya.');
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Jadwal booking Anda telah berhasil dibatalkan.');
    }
}