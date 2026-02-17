<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'identifier' => ['required'],
            'password' => ['required'],
        ]);

        $identifier = $data['identifier'];
        $password = $data['password'];

        // Determine if identifier is an email
        $attempted = false;
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $attempted = Auth::attempt(['email' => $identifier, 'password' => $password], $request->boolean('remember'));
        }

        if (! $attempted) {
            // Try as WhatsApp number: build candidate formats and search user record,
            // then attempt auth using the user's email (more reliable across stored formats).
            $digits = preg_replace('/[^0-9]/', '', $identifier);
            $intl = $digits;
            if (str_starts_with($digits, '0')) {
                $intl = '62' . ltrim($digits, '0');
            }
            if (str_starts_with($digits, '8')) {
                $intl = '62' . $digits;
            }

            $candidates = array_filter(array_unique([$identifier, $digits, $intl]));
            // also try leading-zero variant if we have international form
            if (str_starts_with($intl, '62')) {
                $candidates[] = '0' . substr($intl, 2);
            }

            $user = User::whereIn('wa_number', $candidates)->first();
            if (! $user) {
                // try a loose match: compare digits-only of wa_number column
                $user = User::get()->first(function ($u) use ($digits) {
                    return preg_replace('/[^0-9]/', '', $u->wa_number) === $digits;
                });
            }

            if ($user) {
                $attempted = Auth::attempt(['email' => $user->email, 'password' => $password], $request->boolean('remember'));
            }
        }

        if (! $attempted) {
            return back()->withErrors([
                'identifier' => 'Email/WhatsApp atau password salah.',
            ]);
        }

        $request->session()->regenerate();

        // LOGIKA REDIRECT BERDASARKAN ROLE
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        } 
        
        // Pada method store() di AuthenticatedSessionController.php

if ($user->role === 'customer') {
    return redirect()->intended(route('booking.create'))
        ->with('success', 'Selamat datang kembali, ' . $user->name . '! Siap untuk ritual ketampanan hari ini?');
}

        // Default jika role tidak terdefinisi
        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}