<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
   // app/Http/Controllers/UserController.php

public function redirectAfterLogin()
{
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    // Jika customer, langsung ke halaman booking
    return redirect()->route('booking.create');
}
}
