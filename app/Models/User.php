<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'wa_number',
        'wa_verified',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'wa_verified' => 'boolean',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Send the password reset notification via Brevo HTTP API.
     * This bypasses the SMTP mailer and posts a transactional email.
     */
    public function sendPasswordResetNotification($token)
    {
        $resetUrl = url(route('password.reset', ['token' => $token, 'email' => $this->email], false));
        $subject = sprintf('Reset Kata Sandi — %s', config('app.name', 'Setyo Barbershop'));
        $html = "<p>Halo " . e($this->name ?? $this->email) . ",</p>" .
                "<p>Klik tautan berikut untuk mereset kata sandi Anda:</p>" .
                "<p><a href=\"{$resetUrl}\">Reset Kata Sandi</a></p>" .
                "<p>Jika Anda tidak meminta reset kata sandi, abaikan email ini.</p>";

        try {
            $response = Http::withHeaders([
                'accept' => 'application/json',
                'api-key' => env('BREVO_API_KEY'),
            ])->post('https://api.brevo.com/v3/smtp/email', [
                'sender' => [
                    'name' => env('MAIL_FROM_NAME', config('app.name')),
                    'email' => env('MAIL_FROM_ADDRESS', 'no-reply@localhost'),
                ],
                'to' => [[
                    'email' => $this->email,
                    'name' => $this->name ?? $this->email,
                ]],
                'subject' => $subject,
                'htmlContent' => $html,
            ]);

            if ($response->failed()) {
                Log::error('Brevo reset email failed', ['status' => $response->status(), 'body' => $response->body()]);
            }
        } catch (\Throwable $e) {
            Log::error('Brevo reset email exception', ['message' => $e->getMessage()]);
        }
    }
}
