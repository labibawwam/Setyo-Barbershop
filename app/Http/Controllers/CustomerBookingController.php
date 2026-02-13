<?php

namespace App\Http\Controllers;

use App\Models\Kapster;
use App\Models\Service;
use App\Models\Booking;
use App\Models\KapsterShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CustomerBookingController extends Controller
{
    /**
     * Menampilkan form booking
     */
    public function create()
    {
        // Menggunakan eager loading untuk performa lebih baik
        $kapsters = Kapster::with('shifts')->get();
        $services = Service::all();
        
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
     * Normalize WA number to international format (no plus), e.g. 6281234...
     */
    protected function normalizeWaNumber(string $raw): string
    {
        $n = preg_replace('/[^0-9]/', '', $raw);
        if (str_starts_with($n, '0')) {
            $n = '62' . ltrim($n, '0');
        }
        if (str_starts_with($n, '8')) {
            $n = '62' . $n;
        }
        return $n;
    }

    /**
     * Menyimpan data booking
     */
    public function store(Request $request)
    {
        // Modifikasi validasi: kapster_id boleh 'random' atau ID yang ada di tabel
        $request->validate([
            'kapster_id' => 'required', // Validasi manual di bawah karena bisa berupa string 'random'
            'service_ids' => 'required|array|min:1',
            'service_ids.*' => 'exists:services,id',
            'tgl_booking' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                // 1. Inisialisasi Waktu & Lead Time
                $jamMulaiReq = Carbon::parse($request->tgl_booking . ' ' . $request->jam_mulai);
                
                if ($jamMulaiReq->lt(Carbon::now()->addHour())) {
                    return back()->withInput()->with('error', "Booking minimal dilakukan 1 jam sebelum jadwal kedatangan.");
                }

                // 2. Hitung Durasi & Total Harga
                $services = Service::whereIn('id', $request->service_ids)->get();
                $totalDurasi = $services->sum('durasi');
                $totalHarga = $services->sum('harga');
                $bufferTime = 10; 
                $jamSelesaiReq = $jamMulaiReq->copy()->addMinutes($totalDurasi + $bufferTime);
                $hariInput = $jamMulaiReq->translatedFormat('l');

                // 3. Cek apakah USER sudah memiliki booking lain di jam yang sama
                $isUserSibuk = Booking::where('user_id', Auth::id())
                    ->where('tgl_booking', $request->tgl_booking)
                    ->whereIn('status', ['confirmed', 'pending'])
                    ->where(function ($q) use ($jamMulaiReq, $jamSelesaiReq) {
                        $q->where('jam_mulai', '<', $jamSelesaiReq->toTimeString())
                          ->where('jam_selesai', '>', $jamMulaiReq->toTimeString());
                    })->exists();

                if ($isUserSibuk) {
                    return back()->withInput()->with('error', "Gagal! Anda sudah memiliki jadwal booking lain di waktu yang sama.");
                }

                // --- LOGIKA PEMILIHAN KAPSTER ---
                $finalKapsterId = null;

                if ($request->kapster_id === 'random') {
                    // Cari semua kapster yang masuk (shift) pada hari tersebut dan jam tersebut
                    $availableKapsters = Kapster::whereHas('shifts', function($q) use ($hariInput, $jamMulaiReq, $jamSelesaiReq) {
                        $q->where('hari', $hariInput)
                          ->where('is_libur', false)
                          ->where('jam_mulai', '<=', $jamMulaiReq->toTimeString())
                          ->where('jam_selesai', '>=', $jamSelesaiReq->toTimeString());
                    })->get();

                    foreach ($availableKapsters as $k) {
                        // Cek apakah kapster ini punya booking bentrok
                        $bentrok = Booking::where('kapster_id', $k->id)
                            ->where('tgl_booking', $request->tgl_booking)
                            ->whereIn('status', ['confirmed', 'pending'])
                            ->where(function ($q) use ($jamMulaiReq, $jamSelesaiReq) {
                                $q->where('jam_mulai', '<', $jamSelesaiReq->toTimeString())
                                  ->where('jam_selesai', '>', $jamMulaiReq->toTimeString());
                            })->exists();

                        if (!$bentrok) {
                            $finalKapsterId = $k->id;
                            break; // Pilih kapster pertama yang tersedia
                        }
                    }

                    if (!$finalKapsterId) {
                        return back()->withInput()->with('error', "Maaf, tidak ada Artist yang tersedia di jam tersebut.");
                    }

                } else {
                    // JIKA PILIH KAPSTER SPESIFIK
                    $finalKapsterId = $request->kapster_id;

                    // Cek Shift Kapster Terpilih
                    $shift = KapsterShift::where('kapster_id', $finalKapsterId)
                        ->where('hari', $hariInput)
                        ->first();

                    if (!$shift || $shift->is_libur) {
                        return back()->withInput()->with('error', "Maaf, Artist sedang LIBUR pada hari $hariInput.");
                    }

                    $shiftMulai = Carbon::parse($request->tgl_booking . ' ' . $shift->jam_mulai);
                    $shiftSelesai = Carbon::parse($request->tgl_booking . ' ' . $shift->jam_selesai);

                    if ($jamMulaiReq->lt($shiftMulai) || $jamSelesaiReq->gt($shiftSelesai)) {
                        return back()->withInput()->with('error', "Di luar jam kerja artist.");
                    }

                    // Cek Bentrok Kapster Terpilih
                    $isBentrok = Booking::where('kapster_id', $finalKapsterId)
                        ->where('tgl_booking', $request->tgl_booking)
                        ->whereIn('status', ['confirmed', 'pending'])
                        ->where(function ($q) use ($jamMulaiReq, $jamSelesaiReq) {
                            $q->where('jam_mulai', '<', $jamSelesaiReq->toTimeString())
                              ->where('jam_selesai', '>', $jamMulaiReq->toTimeString());
                        })->lockForUpdate()->exists();

                    if ($isBentrok) {
                        return back()->withInput()->with('error', "Slot waktu tersebut baru saja terisi. Silakan pilih jam lain.");
                    }
                }

                // 6. Simpan Booking dengan $finalKapsterId
                $booking = Booking::create([
                    'user_id'     => Auth::id(),
                    'kapster_id'  => $finalKapsterId,
                    'tgl_booking' => $request->tgl_booking,
                    'jam_mulai'   => $jamMulaiReq->toTimeString(),
                    'jam_selesai' => $jamSelesaiReq->toTimeString(),
                    'total_harga' => $totalHarga,
                    'status'      => 'confirmed' 
                ]);

                $booking->services()->attach($request->service_ids);

                // Attempt to send invoice/confirmation via WhatsApp (best-effort)
                try {
                    $user = Auth::user();
                    $wa = $user->wa_number ?? null;
                    if ($wa) {
                        $to = $this->normalizeWaNumber($wa);
                        // Ensure relations are loaded
                        $booking->loadMissing(['services', 'kapster']);

                        $serviceLines = $booking->services->map(function($s) {
                            $name = $s->nama_service ?? ($s->nama ?? 'Layanan');
                            $dur = $s->durasi ? $s->durasi . 'm' : '';
                            $price = isset($s->harga) ? 'Rp ' . number_format($s->harga, 0, ',', '.') : '';
                            return trim("- {$name} {$dur} {$price}");
                        })->join("\n");

                        $message = "[Setyo Barbershop] Invoice Booking #{$booking->id}\n" .
                                   "Nama: {$user->name}\n" .
                                   "Tanggal: {$booking->tgl_booking}\n" .
                                   "Waktu: {$booking->jam_mulai} - {$booking->jam_selesai}\n" .
                                   "Kapster: {$booking->kapster->nama}\n" .
                                   "Layanan:\n{$serviceLines}\n" .
                                   "Total: Rp " . number_format($booking->total_harga, 0, ',', '.') . "\n\n" .
                                   "Terima kasih, sampai jumpa di salon kami.";

                        $apiUrl = env('FONTE_DEVICE_API_URL') ?: env('FONTE_API_URL', '');
                        $token = env('FONTE_DEVICE_TOKEN') ?: env('FONTE_TOKEN');
                        if ($apiUrl && $token) {
                            $resp = Http::withHeaders(['Authorization' => $token])
                                ->asForm()
                                ->post($apiUrl, [
                                    'target' => $to,
                                    'message' => $message,
                                ]);

                            Log::info('WA invoice send', ['booking_id' => $booking->id, 'status' => $resp->status(), 'body' => $resp->body()]);
                        } else {
                            Log::warning('WA invoice not sent - missing FONTE config', ['booking_id' => $booking->id]);
                        }
                    } else {
                        Log::info('WA invoice not sent - user has no wa_number', ['booking_id' => $booking->id, 'user_id' => $user->id ?? null]);
                    }
                } catch (\Throwable $e) {
                    Log::error('Failed sending WA invoice: ' . $e->getMessage(), ['booking_id' => $booking->id]);
                }

                return redirect()->route('booking.create')->with('success', 'Booking berhasil! Anda akan dilayani oleh ' . $booking->kapster->nama);
            });
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Batalkan booking
     */
    public function cancel($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (in_array($booking->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'Agenda ini sudah selesai atau telah dibatalkan.');
        }

        $jadwalMulai = Carbon::parse($booking->tgl_booking . ' ' . $booking->jam_mulai);
        if (Carbon::now()->gt($jadwalMulai->subHours(2))) {
            return back()->with('error', 'Pembatalan maksimal dilakukan 2 jam sebelum jadwal.');
        }

        $booking->update(['status' => 'cancelled']);

        // Attempt to notify user via WhatsApp about the cancellation (best-effort)
        try {
            $user = Auth::user();
            $wa = $user->wa_number ?? null;
            if ($wa) {
                $to = $this->normalizeWaNumber($wa);
                $message = "[Setyo Barbershop] Pembatalan Booking #{$booking->id}\n" .
                           "Nama: {$user->name}\n" .
                           "Tanggal: {$booking->tgl_booking}\n" .
                           "Waktu: {$booking->jam_mulai} - {$booking->jam_selesai}\n" .
                           "Status: Dibatalkan\n" .
                           "Jika ini bukan Anda, hubungi kami segera.";

                $apiUrl = env('FONTE_DEVICE_API_URL') ?: env('FONTE_API_URL', '');
                $token = env('FONTE_DEVICE_TOKEN') ?: env('FONTE_TOKEN');
                if ($apiUrl && $token) {
                    $resp = Http::withHeaders(['Authorization' => $token])
                        ->asForm()
                        ->post($apiUrl, [
                            'target' => $to,
                            'message' => $message,
                        ]);

                    Log::info('WA cancellation send', ['booking_id' => $booking->id, 'status' => $resp->status(), 'body' => $resp->body()]);
                } else {
                    Log::warning('WA cancellation not sent - missing FONTE config', ['booking_id' => $booking->id]);
                }
            } else {
                Log::info('WA cancellation not sent - user has no wa_number', ['booking_id' => $booking->id, 'user_id' => $user->id ?? null]);
            }
        } catch (\Throwable $e) {
            Log::error('Failed sending WA cancellation: ' . $e->getMessage(), ['booking_id' => $booking->id]);
        }

        return back()->with('success', 'Agenda Anda telah berhasil dibatalkan.');
    }
}