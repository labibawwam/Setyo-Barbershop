<?php

namespace App\Observers;

use App\Models\Booking;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BookingObserver
{
    /**
     * Handle the Booking "updated" event.
     */
    public function updated(Booking $booking): void
    {
        $original = $booking->getOriginal('status');
        $current = $booking->status;

        // If status changed to completed, send WA confirmation
        if ($original !== 'completed' && $current === 'completed') {
            try {
                $user = $booking->user;
                if (! $user) {
                    Log::warning('Booking completed but no user found', ['booking_id' => $booking->id]);
                    return;
                }

                $wa = $user->wa_number ?? null;
                if (! $wa) {
                    Log::info('No WA number for booking completed', ['booking_id' => $booking->id, 'user_id' => $user->id]);
                    return;
                }

                $to = $this->normalizeWaNumber($wa);

                $booking->loadMissing(['services', 'kapster']);
                $serviceLines = $booking->services->map(function($s) {
                    $name = $s->nama_service ?? ($s->nama ?? 'Layanan');
                    $dur = $s->durasi ? $s->durasi . 'm' : '';
                    $price = isset($s->harga) ? 'Rp ' . number_format($s->harga, 0, ',', '.') : '';
                    return trim("- {$name} {$dur} {$price}");
                })->join("\n");

                $message = "[Setyo Barbershop] Booking Selesai #{$booking->id}\n" .
                           "Nama: {$user->name}\n" .
                           "Tanggal: {$booking->tgl_booking}\n" .
                           "Waktu: {$booking->jam_mulai} - {$booking->jam_selesai}\n" .
                           "Kapster: {$booking->kapster->nama}\n" .
                           "Layanan:\n{$serviceLines}\n" .
                           "Total: Rp " . number_format($booking->total_harga, 0, ',', '.') . "\n\n" .
                           "Terima kasih telah menggunakan layanan kami. Semoga hari Anda menyenangkan!";

                $apiUrl = env('FONTE_DEVICE_API_URL') ?: env('FONTE_API_URL', '');
                $token = env('FONTE_DEVICE_TOKEN') ?: env('FONTE_TOKEN');
                if ($apiUrl && $token) {
                    $resp = Http::withHeaders(['Authorization' => $token])
                        ->asForm()
                        ->post($apiUrl, [
                            'target' => $to,
                            'message' => $message,
                        ]);

                    Log::info('WA booking completed send', ['booking_id' => $booking->id, 'status' => $resp->status(), 'body' => $resp->body()]);
                } else {
                    Log::warning('WA booking completed not sent - missing FONTE config', ['booking_id' => $booking->id]);
                }

            } catch (\Throwable $e) {
                Log::error('Failed sending WA booking completed: ' . $e->getMessage(), ['booking_id' => $booking->id]);
            }
        }
    }

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
}
