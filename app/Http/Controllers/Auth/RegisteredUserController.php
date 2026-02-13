<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan halaman registrasi.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Tangani permintaan pendaftaran baru.
     */
    public function store(Request $request): RedirectResponse
    {
            // Determine if there's already a pending user in session
            $pendingId = session('pending_wa_user');

            // Build validation rules; if pending, allow same email for that pending user
            $emailRules = ['required', 'string', 'lowercase', 'email', 'max:255'];
            if ($pendingId) {
                $emailRules[] = Rule::unique((new User)->getTable())->ignore($pendingId);
            } else {
                $emailRules[] = 'unique:'.User::class;
            }

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => $emailRules,
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'wa_number' => ['required', 'string', 'min:7', 'max:20'],
                'otp' => ['nullable', 'digits:6'],
            ]);

            // If there's a pending user in session, handle OTP verification flow first
            if ($pendingId) {
                $user = User::find($pendingId);
                if (! $user) {
                    session()->forget('pending_wa_user');
                    return back()->with('error', 'Terjadi kesalahan. Silakan coba daftar ulang.');
                }

                if ($request->filled('otp')) {
                    $sessionKey = 'wa_otp_session_' . session()->getId();
                    $userKey = 'wa_otp_' . $user->id;
                    $cachedSession = \Illuminate\Support\Facades\Cache::get($sessionKey);
                    $cachedUser = \Illuminate\Support\Facades\Cache::get($userKey);
                    $inputCode = $request->input('otp');

                    if (($cachedSession && (string)$cachedSession === (string)$inputCode) || ($cachedUser && (string)$cachedUser === (string)$inputCode)) {
                        $user->wa_verified = true;
                        $user->save();
                        \Illuminate\Support\Facades\Cache::forget($sessionKey);
                        \Illuminate\Support\Facades\Cache::forget($userKey);
                        session()->forget('pending_wa_user');
                        Auth::login($user);
                        return redirect()->route('booking.create')->with('success', 'Nomor WhatsApp terverifikasi. Selamat datang, ' . $user->name . '!');
                    }

                    return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kedaluwarsa. Silakan coba lagi.'])->withInput();
                }

                // No OTP provided yet; ask user to enter OTP on the same registration page
                return back()->withInput()->with('success', 'Kode OTP telah dikirim. Silakan masukkan kode untuk menyelesaikan pendaftaran.');
            }

            // If no pending user but OTP was provided (pre-send flow via "Send"),
            // validate session-scoped OTP and create+verify user immediately.
            if (! $pendingId && $request->filled('otp')) {
                $sessionKey = 'wa_otp_session_' . session()->getId();
                $cacheNumberKey = 'wa_pending_number_' . session()->getId();
                $cachedCode = \Illuminate\Support\Facades\Cache::get($sessionKey);
                $cachedNumber = \Illuminate\Support\Facades\Cache::get($cacheNumberKey);

                if (! $cachedCode || (string)$cachedCode !== (string)$request->otp || $cachedNumber !== $request->wa_number) {
                    return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kedaluwarsa. Silakan coba lagi.'])->withInput();
                }

                // OTP valid from session: check if user exists and create or update accordingly
                $normalizedWa = $this->normalizeWaNumber($request->wa_number);
                $existing = User::where('email', $request->email)
                    ->orWhere('wa_number', $request->wa_number)
                    ->orWhere('wa_number', $normalizedWa)
                    ->first();

                if ($existing) {
                    // Update existing user with verification and password if needed
                    $existing->wa_verified = true;
                    $existing->wa_number = $request->wa_number;
                    if (! Hash::check($request->password, $existing->password)) {
                        $existing->password = Hash::make($request->password);
                    }
                    $existing->save();
                    $user = $existing;
                } else {
                    $user = User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'role' => 'customer',
                        'wa_number' => $request->wa_number,
                        'wa_verified' => true,
                    ]);
                    event(new Registered($user));
                }
                // consume caches
                \Illuminate\Support\Facades\Cache::forget($sessionKey);
                \Illuminate\Support\Facades\Cache::forget($cacheNumberKey);
                Auth::login($user);
                return redirect()->route('booking.create')->with('success', 'Nomor WhatsApp terverifikasi. Selamat datang, ' . $user->name . '!');
            }

            // No pending user: create new user and send OTP, keep user on register page
            // Check if user already exists (email or wa_number)
            $normalizedWa = $this->normalizeWaNumber($request->wa_number);
            $existing = User::where('email', $request->email)
                ->orWhere('wa_number', $request->wa_number)
                ->orWhere('wa_number', $normalizedWa)
                ->first();

            if ($existing) {
                // If existing user is the pending one allow continuation; otherwise inform user
                if (! $pendingId || $existing->id !== $pendingId) {
                    return back()->with('error', 'Akun dengan email atau nomor WhatsApp ini sudah terdaftar. Silakan masuk atau gunakan lupa kata sandi.');
                }
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'customer',
                'wa_number' => $request->wa_number,
                'wa_verified' => false,
            ]);

            event(new Registered($user));

            $sent = $this->sendWaOtp($user);
            session(['pending_wa_user' => $user->id]);

            $flash = $sent ? 'Kode OTP telah dikirim ke nomor WhatsApp Anda. Masukkan kode untuk menyelesaikan pendaftaran.' : 'Gagal mengirim OTP. Silakan cek nomor Anda atau coba lagi.';
            return back()->withInput()->with('success', $flash);
    }

    /**
     * Send OTP to user's WhatsApp (currently logs and caches the OTP).
     */
    protected function sendWaOtp(User $user): bool
    {
        $code = rand(100000, 999999);
        // Cache code for 5 minutes
        \Illuminate\Support\Facades\Cache::put('wa_otp_' . $user->id, $code, now()->addMinutes(5));

        // Send via configured Fonte API if available
        $to = $this->normalizeWaNumber($user->wa_number);
        $message = "Your verification code: {$code}";
        $sent = $this->sendWhatsAppMessage($to, $message);

        if (! $sent) {
            \Log::error("WA OTP NOT SENT for user {$user->id} ({$user->wa_number}): {$code}");
            return false;
        }

        \Log::info("WA OTP sent for user {$user->id} ({$user->wa_number})");
        return true;
    }

    /**
     * Send OTP to a WA number using the current session as a temporary holder.
     * This is intended for pre-registration 'Send' button.
     */
    public function sendOtpToNumber(Request $request)
    {
        $request->validate([
            'wa_number' => ['required', 'string', 'min:7', 'max:20'],
        ]);

        $wa = $request->wa_number;
        $sessionId = session()->getId();
        $cacheKey = 'wa_otp_session_' . $sessionId;
        $cacheNumberKey = 'wa_pending_number_' . $sessionId;

        $code = rand(100000, 999999);
        \Illuminate\Support\Facades\Cache::put($cacheKey, $code, now()->addMinutes(5));
        \Illuminate\Support\Facades\Cache::put($cacheNumberKey, $wa, now()->addMinutes(5));

        // Send via device API only
        $to = $this->normalizeWaNumber($wa);
        $message = "Your verification code: {$code}";
        $sent = $this->sendWhatsAppMessage($to, $message);

        if ($sent) {
            return response()->json(['status' => 'ok', 'message' => 'OTP telah dikirim ke WhatsApp.']);
        }

        \Log::error("(pre-register) WA OTP NOT SENT for session {$sessionId} ({$wa}): {$code}");
        return response()->json(['status' => 'error', 'message' => 'Gagal mengirim OTP. Periksa nomor atau konfigurasi.']);
    }

    /**
     * Send a WhatsApp message using configured Fonte API.
     * Expect environment variables: FONTE_API_URL and FONTE_TOKEN
     */
    protected function sendWhatsAppMessage(string $to, string $message): bool
    {
        $apiUrl = env('FONTE_DEVICE_API_URL') ?: env('FONTE_API_URL', 'https://api.fonnte.com/send');
        $token = env('FONTE_DEVICE_TOKEN') ?: env('FONTE_TOKEN');

        if (! $apiUrl || ! $token) {
            \Log::error('Fonte device API URL or token not configured.');
            return false;
        }

        try {
            // Provider expects form-encoded fields and Authorization header with the token value (no Bearer)
            $response = Http::withHeaders(['Authorization' => $token])
                ->asForm()
                ->post($apiUrl, [
                    'target' => $to,
                    'message' => $message,
                ]);

            \Log::info('Fonte device response', ['status' => $response->status(), 'body' => $response->body()]);
            return $response->successful();
        } catch (\Throwable $e) {
            \Log::error('Failed to send WA message via device API: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Normalize various WA number formats to international without +, e.g. 6281234...
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
}