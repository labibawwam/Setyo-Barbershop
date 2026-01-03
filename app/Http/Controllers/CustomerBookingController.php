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
     * Menampilkan form booking dengan data pendukung
     */
    public function create()
    {
        $kapsters = Kapster::all();
        $services = Service::all();
        
        // Ambil jadwal yang sudah terisi agar user tidak memilih jam yang sama
        $allBookings = Booking::whereIn('status', ['confirmed', 'pending'])
            ->select('kapster_id', 'tgl_booking', 'jam_mulai', 'jam_selesai')
            ->get();

        $myBookings = Booking::where('user_id', Auth::id())
            ->with(['kapster', 'services'])
            ->latest()
            ->get();

        return view('customer.bookings.create', compact('kapsters', 'services', 'myBookings', 'allBookings'));
    }

    /**
     * Menyimpan data booking dengan validasi keamanan extra
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
                // 1. Inisialisasi Waktu & Lead Time (Min. 1 jam dari sekarang)
                $jamMulaiReq = Carbon::parse($request->tgl_booking . ' ' . $request->jam_mulai);
                
                if ($jamMulaiReq->lt(Carbon::now()->addHour())) {
                    return back()->withInput()->with('error', "Booking minimal dilakukan 1 jam sebelum jadwal kedatangan.");
                }

                // 2. Cek apakah user sudah punya terlalu banyak booking aktif (Mencegah Spam)
                $userActiveBookings = Booking::where('user_id', Auth::id())
                    ->whereIn('status', ['confirmed', 'pending'])
                    ->count();
                if ($userActiveBookings >= 2) {
                    return back()->withInput()->with('error', "Anda memiliki 2 agenda aktif. Selesaikan atau batalkan salah satu sebelum membuat janji baru.");
                }

                // 3. LOGIKA BARU: Cek apakah USER sudah memiliki booking lain di jam yang sama (meskipun kapster beda)
                $services = Service::whereIn('id', $request->service_ids)->get();
                $totalDurasi = $services->sum('durasi');
                $totalHarga = $services->sum('harga');
                $bufferTime = 10; 
                $jamSelesaiReq = $jamMulaiReq->copy()->addMinutes($totalDurasi + $bufferTime);

                $isUserSibuk = Booking::where('user_id', Auth::id())
                    ->where('tgl_booking', $request->tgl_booking)
                    ->whereIn('status', ['confirmed', 'pending'])
                    ->where(function ($q) use ($jamMulaiReq, $jamSelesaiReq) {
                        $q->where('jam_mulai', '<', $jamSelesaiReq->toTimeString())
                          ->where('jam_selesai', '>', $jamMulaiReq->toTimeString());
                    })
                    ->exists();

                if ($isUserSibuk) {
                    return back()->withInput()->with('error', "Gagal! Anda sudah memiliki jadwal booking lain di waktu yang bersamaan.");
                }

                // 4. Cek Shift Kapster (Hari kerja & Jam operasional)
                $hariInput = $jamMulaiReq->translatedFormat('l'); 
                $shift = KapsterShift::where('kapster_id', $request->kapster_id)
                    ->where('hari', $hariInput)
                    ->first();

                if (!$shift || $shift->is_libur) {
                    return back()->withInput()->with('error', "Maaf, Artist sedang LIBUR pada hari $hariInput.");
                }

                $shiftMulai = Carbon::parse($request->tgl_booking . ' ' . $shift->jam_mulai);
                $shiftSelesai = Carbon::parse($request->tgl_booking . ' ' . $shift->jam_selesai);

                if ($jamMulaiReq->lt($shiftMulai) || $jamSelesaiReq->gt($shiftSelesai)) {
                    return back()->withInput()->with('error', "Di luar jam kerja artist ($hariInput: " . 
                        $shiftMulai->format('H:i') . " - " . $shiftSelesai->format('H:i') . ")");
                }

                // 5. Cek Bentrok Jadwal Kapster (Overlap Logic) dengan Row Level Locking
                $isBentrok = Booking::where('kapster_id', $request->kapster_id)
                    ->where('tgl_booking', $request->tgl_booking)
                    ->whereIn('status', ['confirmed', 'pending'])
                    ->where(function ($q) use ($jamMulaiReq, $jamSelesaiReq) {
                        $q->where('jam_mulai', '<', $jamSelesaiReq->toTimeString())
                          ->where('jam_selesai', '>', $jamMulaiReq->toTimeString());
                    })
                    ->lockForUpdate()
                    ->exists();

                if ($isBentrok) {
                    return back()->withInput()->with('error', "Slot waktu tersebut baru saja terisi. Silakan pilih jam lain.");
                }

                // 6. Simpan Booking
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

                return redirect()->route('booking.create')->with('success', 'Booking berhasil dikonfirmasi! Sampai jumpa di Setyo Barbershop.');
            });
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi gangguan sistem. Silakan coba lagi.');
        }
    }

    /**
     * Batalkan booking dengan kebijakan waktu (Min. 2 jam sebelum mulai)
     */
    public function cancel($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (in_array($booking->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'Agenda ini sudah selesai atau telah dibatalkan.');
        }

        // Kebijakan Pembatalan: Maksimal 2 jam sebelum mulai
        $jadwalMulai = Carbon::parse($booking->tgl_booking . ' ' . $booking->jam_mulai);
        if (Carbon::now()->gt($jadwalMulai->subHours(2))) {
            return back()->with('error', 'Pembatalan hanya dapat dilakukan maksimal 2 jam sebelum jadwal dimulai.');
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Agenda Anda telah berhasil dibatalkan.');
    }
}