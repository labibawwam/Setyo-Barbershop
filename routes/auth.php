<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\WaOtpController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    // AJAX: send OTP to a provided WA number before form submit
    Route::post('wa/send-otp', [RegisteredUserController::class, 'sendOtpToNumber'])->name('wa.send_otp');
    // AJAX: send OTP to a provided email before form submit
    Route::post('email/send-otp', [RegisteredUserController::class, 'sendOtpToEmail'])->name('email.send_otp');

    // WhatsApp OTP verification
    Route::get('wa/verify', [WaOtpController::class, 'showVerifyForm'])->name('wa.verify.form');
    Route::post('wa/verify', [WaOtpController::class, 'verify'])->name('wa.verify');
    Route::post('wa/verify/resend', [WaOtpController::class, 'resend'])->name('wa.verify.resend');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // OTP-based email verification (Brevo)
    Route::get('verify-email/otp', [\App\Http\Controllers\Auth\EmailOtpController::class, 'showVerifyForm'])
        ->name('verification.otp.form');
    Route::post('verify-email/otp', [\App\Http\Controllers\Auth\EmailOtpController::class, 'verify'])
        ->name('verification.otp.verify');
    Route::post('verify-email/otp/send', [\App\Http\Controllers\Auth\EmailOtpController::class, 'send'])
        ->name('verification.otp.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
