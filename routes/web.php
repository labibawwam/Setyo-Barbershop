<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

// Admin Controllers
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\KapsterController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\KapsterShiftController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\ReportController;

// Customer Controllers
use App\Http\Controllers\CustomerBookingController;
use App\Http\Controllers\LandingController;

// --- Public Routes ---
Route::get('/', [LandingController::class, 'index'])->name('welcome');
Route::get('/services', function () {
    return view('services');
})->name('services');

// --- Booking Route (DIUBAH KE TUNGGAL & URL SPESIFIK) ---
// Route khusus Customer
Route::middleware(['auth'])->group(function () {
    Route::get('/booking/create', [CustomerBookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [CustomerBookingController::class, 'store'])->name('booking.store');
    // Route khusus pembatalan customer
   // Tambahkan atau ubah rute yang sudah ada
// Ganti 'destroy' menjadi 'cancel'
Route::patch('/bookings/{id}/cancel', [CustomerBookingController::class, 'cancel'])->name('booking.cancel');
});

// --- Profile Routes ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- Authenticated & Verified Routes ---
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/redirect', [UserController::class, 'redirectAfterLogin'])->name('user.redirect');

    // Admin Group (Role: Admin)
    Route::middleware(['auth', 'role:admin']) // Pastikan ada 'auth' agar aman
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::resource('users', AdminUserController::class);
        Route::resource('kapsters', KapsterController::class);
        Route::resource('services', ServiceController::class);
        Route::resource('kapster_shifts', KapsterShiftController::class);
        Route::resource('bookings', AdminBookingController::class); 
        
        // Perbaikan penulisan di sini:
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        // Atau jika ingin menggunakan resource:
        // Route::resource('reports', ReportController::class);
    });
});

require __DIR__.'/auth.php';