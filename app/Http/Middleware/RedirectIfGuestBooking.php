<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfGuestBooking
{
    public function handle($request, Closure $next)
    {
        // Jika user belum login
        if (!Auth::check()) {

            // Simpan perintah redirect setelah login
            session(['after_login_redirect' => route('welcome')]);

            // Arahkan ke halaman login
            return redirect()->route('login');
        }

        return $next($request);
    }
}
