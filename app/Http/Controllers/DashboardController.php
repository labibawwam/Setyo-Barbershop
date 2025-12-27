<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard sesuai role user
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Data statistik contoh
            $stats = [
                'total_customers' => 120,
                'total_kapster'   => 8,
                'total_services'  => 15,
                'total_bookings'  => 340,
            ];

            return view('admin.dashboard', compact('user', 'stats'));
        }

        if ($user->role === 'customer') {
            // Dummy data booking untuk customer
            $bookings = [
                [
                    'kapster' => 'Budi',
                    'service' => 'Haircut',
                    'date'    => '2025-09-25',
                    'status'  => 'Selesai'
                ],
                [
                    'kapster' => 'Andi',
                    'service' => 'Shaving',
                    'date'    => '2025-09-28',
                    'status'  => 'Dijadwalkan'
                ],
            ];

            return view('customer.dashboard', compact('user', 'bookings'));
        }

        // Kalau role tidak dikenali
        abort(403, 'Unauthorized');
    }
}
