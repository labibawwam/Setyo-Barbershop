<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EmailOtpController extends Controller
{
    public function send(Request $request)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        $code = rand(100000, 999999);
        Cache::put('email_otp_' . $user->id, $code, now()->addMinutes(5));

        try {
            $reg = new RegisteredUserController();
            $ok = $reg->sendEmailMessage($user->email, $user->name, $code);
            if ($ok) {
                return back()->with('success', 'Kode OTP telah dikirim ke email Anda.');
            }
        } catch (\Throwable $e) {
            Log::error('Failed sending email OTP for user '.$user->id.': '.$e->getMessage());
        }

        return back()->with('error', 'Gagal mengirim OTP lewat email. Periksa konfigurasi.');
    }

    public function showVerifyForm()
    {
        return view('auth.verify-email-otp');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        $cacheKey = 'email_otp_' . $user->id;
        $cached = Cache::get($cacheKey);
        if (! $cached || (string)$cached !== (string)$request->code) {
            return back()->withErrors(['code' => 'Kode OTP salah atau sudah kedaluwarsa.'])->withInput();
        }

        $user->email_verified_at = $user->email_verified_at ?: now();
        $user->save();

        Cache::forget($cacheKey);

        return redirect()->route('booking.create')->with('success', 'Email berhasil diverifikasi.');
    }
}
