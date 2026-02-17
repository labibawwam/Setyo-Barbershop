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
                    $sessionKeyWa = 'wa_otp_session_' . session()->getId();
                    $sessionKeyEmail = 'email_otp_session_' . session()->getId();
                    $userKeyWa = 'wa_otp_' . $user->id;
                    $userKeyEmail = 'email_otp_' . $user->id;
                    $cachedSessionWa = \Illuminate\Support\Facades\Cache::get($sessionKeyWa);
                    $cachedSessionEmail = \Illuminate\Support\Facades\Cache::get($sessionKeyEmail);
                    $cachedUserWa = \Illuminate\Support\Facades\Cache::get($userKeyWa);
                    $cachedUserEmail = \Illuminate\Support\Facades\Cache::get($userKeyEmail);
                    $inputCode = $request->input('otp');

                    $matchedWa = ($cachedSessionWa && (string)$cachedSessionWa === (string)$inputCode) || ($cachedUserWa && (string)$cachedUserWa === (string)$inputCode);
                    $matchedEmail = ($cachedSessionEmail && (string)$cachedSessionEmail === (string)$inputCode) || ($cachedUserEmail && (string)$cachedUserEmail === (string)$inputCode);

                    if ($matchedWa || $matchedEmail) {
                        if ($matchedWa) {
                            $user->wa_verified = true;
                        }
                        if ($matchedEmail) {
                            $user->email_verified_at = $user->email_verified_at ?: now();
                        }
                        $user->save();

                        \Illuminate\Support\Facades\Cache::forget($sessionKeyWa);
                        \Illuminate\Support\Facades\Cache::forget($sessionKeyEmail);
                        \Illuminate\Support\Facades\Cache::forget($userKeyWa);
                        \Illuminate\Support\Facades\Cache::forget($userKeyEmail);
                        session()->forget('pending_wa_user');
                        Auth::login($user);
                        return redirect()->route('booking.create')->with('success', 'Nomor terverifikasi. Selamat datang, ' . $user->name . '!');
                    }

                    return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kedaluwarsa. Silakan coba lagi.'])->withInput();
                }

                // No OTP provided yet; ask user to enter OTP on the same registration page
                return back()->withInput()->with('success', 'Kode OTP telah dikirim. Silakan masukkan kode untuk menyelesaikan pendaftaran.');
            }

            // If no pending user but OTP was provided (pre-send flow via "Send"),
            // validate session-scoped OTP and create+verify user immediately.
            if (! $pendingId && $request->filled('otp')) {
                $sessionKeyWa = 'wa_otp_session_' . session()->getId();
                $cacheNumberKey = 'wa_pending_number_' . session()->getId();
                $sessionKeyEmail = 'email_otp_session_' . session()->getId();
                $cacheEmailKey = 'email_pending_email_' . session()->getId();

                $cachedCodeWa = \Illuminate\Support\Facades\Cache::get($sessionKeyWa);
                $cachedNumber = \Illuminate\Support\Facades\Cache::get($cacheNumberKey);
                $cachedCodeEmail = \Illuminate\Support\Facades\Cache::get($sessionKeyEmail);
                $cachedEmail = \Illuminate\Support\Facades\Cache::get($cacheEmailKey);

                $providedOtp = (string)$request->otp;
                $validSessionMatch = ($cachedCodeWa && $cachedCodeWa === $providedOtp && $cachedNumber === $request->wa_number)
                    || ($cachedCodeEmail && $cachedCodeEmail === $providedOtp && $cachedEmail === $request->email);

                $matchedWa = ($cachedCodeWa && $cachedCodeWa === $providedOtp && $cachedNumber === $request->wa_number);
                $matchedEmail = ($cachedCodeEmail && $cachedCodeEmail === $providedOtp && $cachedEmail === $request->email);

                if ($matchedWa || $matchedEmail) {
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
                        if ($matchedWa) {
                            $existing->wa_verified = true;
                        }
                        if ($matchedEmail) {
                            $existing->email_verified_at = $existing->email_verified_at ?: now();
                        }
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
                            'wa_verified' => $matchedWa ? true : false,
                            'email_verified_at' => $matchedEmail ? now() : null,
                        ]);
                    }
                // consume caches
                \Illuminate\Support\Facades\Cache::forget($sessionKeyWa);
                \Illuminate\Support\Facades\Cache::forget($sessionKeyEmail);
                \Illuminate\Support\Facades\Cache::forget($cacheNumberKey);
                \Illuminate\Support\Facades\Cache::forget($cacheEmailKey);
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

            // Do not fire the default Registered event (Breeze would send a signed verification link)
            // We use OTP-based verification via WA/Email instead.
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

        // Also store same code for email so both channels accept the same OTP
        \Illuminate\Support\Facades\Cache::put('email_otp_' . $user->id, $code, now()->addMinutes(5));

        // Send via configured Fonte API if available
        $to = $this->normalizeWaNumber($user->wa_number);
        $message = "Your verification code: {$code}";
        $sent = $this->sendWhatsAppMessage($to, $message);

        if (! $sent) {
            \Log::error("WA OTP NOT SENT for user {$user->id} ({$user->wa_number}): {$code}");
            // still attempt sending email if configured
            $emailSent = $this->sendEmailMessage($user->email, $user->name, $code);
            if ($emailSent) {
                \Log::info("Email OTP sent for user {$user->id} ({$user->email}) after WA failed");
                return true;
            }
            return false;
        }

        // Also send same code via email if Brevo configured
        $this->sendEmailMessage($user->email, $user->name, $code);

        \Log::info("WA OTP sent for user {$user->id} ({$user->wa_number})");
        return true;
    }

    /**
     * Send OTP to an email address using Brevo (if configured). This is used for pre-register flows.
     */
    public function sendOtpToEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email']
        ]);

        $email = $request->email;
        $sessionId = session()->getId();
        $cacheKey = 'email_otp_session_' . $sessionId;
        $cacheEmailKey = 'email_pending_email_' . $sessionId;

        $code = rand(100000, 999999);
        \Illuminate\Support\Facades\Cache::put($cacheKey, $code, now()->addMinutes(5));
        \Illuminate\Support\Facades\Cache::put($cacheEmailKey, $email, now()->addMinutes(5));

        $sent = $this->sendEmailMessage($email, null, $code);

        if ($sent) {
            return response()->json(['status' => 'ok', 'message' => 'OTP telah dikirim ke email.']);
        }

        \Log::error("(pre-register) Email OTP NOT SENT for session {$sessionId} ({$email}): {$code}");
        return response()->json(['status' => 'error', 'message' => 'Gagal mengirim OTP lewat email. Periksa konfigurasi.']);
    }

    /**
     * Send email using Brevo's transactional API.
     */
    public function sendEmailMessage(string $toEmail, ?string $toName, int $code): bool
    {
        $apiKey = env('BREVO_API_KEY');
        if (! $apiKey || ! $toEmail) {
            \Log::warning('Brevo API key not configured or missing recipient email.');
            return false;
        }

        $fromEmail = env('MAIL_FROM_ADDRESS', 'no-reply@setyobarbershop.local');
        $fromName = env('MAIL_FROM_NAME', 'Setyo Barbershop');

        // If MAIL_FROM_ADDRESS is a placeholder or local dev address, prefer the SMTP username
        // since Brevo requires a verified sender address for reliable delivery.
        $smtpUser = env('MAIL_USERNAME');
        // Only use MAIL_USERNAME as sender if it's a valid email address.
        if ($smtpUser && filter_var($smtpUser, FILTER_VALIDATE_EMAIL)
            && (str_contains($fromEmail, 'example.com') || str_contains($fromEmail, 'local') || $fromEmail === 'no-reply@setyobarbershop.local')) {
            $fromEmail = $smtpUser;
            \Log::info('Adjusted from email to SMTP username for Brevo delivery: ' . $fromEmail);
        }

        // Render blade template if exists to provide nicer HTML
        try {
            $htmlContent = view('emails.otp', ['code' => $code, 'name' => $toName])->render();
        } catch (\Throwable $e) {
            $htmlContent = "<p>Kode verifikasi Anda: <strong>{$code}</strong></p>";
        }

        $recipientName = $toName ?: preg_replace('/@.*$/', '', $toEmail);

        $body = [
            'sender' => ['name' => $fromName, 'email' => $fromEmail],
            'to' => [['email' => $toEmail, 'name' => $recipientName] ],
            'subject' => 'Kode Verifikasi Anda',
            'htmlContent' => $htmlContent,
            'textContent' => "Kode verifikasi Anda: {$code}"
        ];

        try {
            $response = Http::withHeaders(['api-key' => $apiKey, 'Accept' => 'application/json'])
                ->post('https://api.brevo.com/v3/smtp/email', $body);

            \Log::info('Brevo response', ['status' => $response->status(), 'body' => $response->body()]);

            // Save same code under email cache for verification parity if user exists
            if ($response->successful()) {
                try {
                    $user = \App\Models\User::where('email', $toEmail)->first();
                    if ($user) {
                        \Illuminate\Support\Facades\Cache::put('email_otp_' . $user->id, $code, now()->addMinutes(5));
                    }
                } catch (\Throwable $e) {
                    \Log::warning('Unable to cache email OTP per-user: '.$e->getMessage());
                }
                return true;
            }
            return false;
        } catch (\Throwable $e) {
            \Log::error('Failed to send email via Brevo: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send OTP to a WA number using the current session as a temporary holder.
     * This is intended for pre-registration 'Send' button.
     */
    public function sendOtpToNumber(Request $request)
    {
        $request->validate([
            'wa_number' => ['required', 'string', 'min:7', 'max:20'],
            'email' => ['nullable', 'email'],
        ]);

        $wa = $request->wa_number;
        $email = $request->email;
        $sessionId = session()->getId();
        $cacheKeyWa = 'wa_otp_session_' . $sessionId;
        $cacheNumberKey = 'wa_pending_number_' . $sessionId;
        $cacheKeyEmail = 'email_otp_session_' . $sessionId;
        $cacheEmailKey = 'email_pending_email_' . $sessionId;

        $code = rand(100000, 999999);
        // Cache both session codes so verification accepts either channel
        \Illuminate\Support\Facades\Cache::put($cacheKeyWa, $code, now()->addMinutes(5));
        \Illuminate\Support\Facades\Cache::put($cacheNumberKey, $wa, now()->addMinutes(5));
        if ($email) {
            \Illuminate\Support\Facades\Cache::put($cacheKeyEmail, $code, now()->addMinutes(5));
            \Illuminate\Support\Facades\Cache::put($cacheEmailKey, $email, now()->addMinutes(5));
        }

        // Send via device API for WA
        $to = $this->normalizeWaNumber($wa);
        $message = "Your verification code: {$code}";
        $sentWa = $this->sendWhatsAppMessage($to, $message);

        // Send via Brevo for email if provided
        $sentEmail = false;
        if ($email) {
            $sentEmail = $this->sendEmailMessage($email, null, $code);
        }

        if ($sentWa || $sentEmail) {
            $channels = [];
            if ($sentWa) $channels[] = 'WhatsApp';
            if ($sentEmail) $channels[] = 'Email';
            $msg = 'OTP telah dikirim via ' . implode(' & ', $channels) . '.';
            return response()->json(['status' => 'ok', 'message' => $msg]);
        }

        \Log::error("(pre-register) OTP NOT SENT for session {$sessionId} ({$wa} / {$email}): {$code}");
        return response()->json(['status' => 'error', 'message' => 'Gagal mengirim OTP. Periksa konfigurasi.']);
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