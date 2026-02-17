<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WaOtpController extends Controller
{
    public function showVerifyForm(Request $request)
    {
        $pendingId = session('pending_wa_user');
        if (! $pendingId) {
            return redirect()->route('register')->with('error', 'No pending verification found.');
        }

        $user = User::find($pendingId);
        if (! $user) {
            return redirect()->route('register')->with('error', 'User not found.');
        }

        return view('auth.verify-wa', ['user' => $user]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $pendingId = session('pending_wa_user');
        if (! $pendingId) {
            return redirect()->route('register')->with('error', 'No pending verification found.');
        }

        $user = User::find($pendingId);
        if (! $user) {
            return redirect()->route('register')->with('error', 'User not found.');
        }

        $cacheKeyWa = 'wa_otp_' . $user->id;
        $cacheKeyEmail = 'email_otp_' . $user->id;
        $cachedWa = Cache::get($cacheKeyWa);
        $cachedEmail = Cache::get($cacheKeyEmail);

        if ((! $cachedWa || (string) $cachedWa !== (string) $request->code) && (! $cachedEmail || (string) $cachedEmail !== (string) $request->code)) {
            // Keep pending session and redirect back to register so user can re-enter OTP there
            return redirect()->route('register')->withErrors(['otp' => 'Kode OTP salah atau sudah kedaluwarsa. Silakan masukkan ulang.'])->withInput();
        }

        // Mark verified, clear caches, login user, and proceed
        $user->wa_verified = true;
        $user->save();

        Cache::forget($cacheKeyWa);
        Cache::forget($cacheKeyEmail);
        session()->forget('pending_wa_user');

        Auth::login($user);

        return redirect()->route('booking.create')->with('success', 'Nomor WhatsApp terverifikasi. Selamat datang, ' . $user->name . '!');
    }

    public function resend(Request $request)
    {
        $pendingId = session('pending_wa_user');
        if (! $pendingId) {
            return redirect()->route('register')->with('error', 'No pending verification found.');
        }

        $user = User::find($pendingId);
        if (! $user) {
            return redirect()->route('register')->with('error', 'User not found.');
        }

        // Generate new code and cache for both channels so verification accepts either
        $code = rand(100000, 999999);
        Cache::put('wa_otp_' . $user->id, $code, now()->addMinutes(5));
        Cache::put('email_otp_' . $user->id, $code, now()->addMinutes(5));

        $to = $this->normalizeWaNumber($user->wa_number);
        $message = "Your verification code: {$code}";

        $sent = $this->sendWhatsAppMessage($to, $message);
        // Try email as well (best-effort)
        try {
            // Use RegisteredUserController's helper to send email if available
            $reg = new \App\Http\Controllers\Auth\RegisteredUserController();
            $reg->sendEmailMessage($user->email, $user->name, $code);
        } catch (\Throwable $e) {
            Log::warning('Failed to call sendEmailMessage for resend: '.$e->getMessage());
        }

        Log::info("(resend) WA OTP for user {$user->id} ({$user->wa_number}): {$code}");

        $message = $sent ? 'Kode OTP baru telah dikirim ke WhatsApp.' : 'Gagal mengirim OTP. Silakan ulangi atau periksa konfigurasi.';
        return back()->with('success', $message);
    }

    /** Normalize WA number same as RegisteredUserController */
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
     * Try sending via Fonte device API only.
     */
    protected function sendWhatsAppMessage(string $to, string $message): bool
    {
        $apiUrl = env('FONTE_DEVICE_API_URL') ?: env('FONTE_API_URL', 'https://api.fonnte.com/send');
        $token = env('FONTE_DEVICE_TOKEN') ?: env('FONTE_TOKEN');

        if (! $apiUrl || ! $token) {
            Log::error('Fonte device API URL or token not configured.');
            return false;
        }

        try {
            $response = Http::withHeaders(['Authorization' => $token])
                ->asForm()
                ->post($apiUrl, [
                    'target' => $to,
                    'message' => $message,
                ]);

            Log::info('Fonte device response', ['status' => $response->status(), 'body' => $response->body()]);
            return $response->successful();
        } catch (\Throwable $e) {
            Log::error('Failed to send WA message via device API: ' . $e->getMessage());
            return false;
        }
    }
}
