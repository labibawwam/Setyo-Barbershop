<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kapster;
use App\Models\Service;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Filter Waktu (Default: Bulan & Tahun Sekarang)
        // Memastikan input adalah integer untuk keamanan query
        $month = (int) $request->get('month', date('m'));
        $year = (int) $request->get('year', date('Y'));

        // 2. DATA DARI TABEL USERS
        $totalUsers = User::count();
        $newUsersThisMonth = User::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        // 3. DATA DARI TABEL KAPSTER (Performa Artist)
        $kapsterPerformance = Kapster::withCount(['bookings' => function($query) use ($month, $year) {
            $query->whereYear('tgl_booking', $year)
                  ->whereMonth('tgl_booking', $month)
                  ->whereIn('status', ['confirmed', 'completed']); // Hanya menghitung yang valid
        }])->get();

        // 4. DATA DARI TABEL SERVICES (Layanan Terlaris)
        // Perbaikan: Gunakan whereHas untuk memastikan filter tgl_booking merujuk ke tabel bookings
        $popularServices = Service::withCount(['bookings' => function($query) use ($month, $year) {
            $query->whereYear('tgl_booking', $year)
                  ->whereMonth('tgl_booking', $month)
                  ->whereIn('status', ['confirmed', 'completed']);
        }])
        ->orderBy('bookings_count', 'desc')
        ->take(5)
        ->get();

        // 5. DATA DARI TABEL BOOKINGS (Financial & Operations)
        // Base query untuk efisiensi
        $bookingsQuery = Booking::whereYear('tgl_booking', $year)
            ->whereMonth('tgl_booking', $month);

        $totalRevenue = (clone $bookingsQuery)
            ->whereIn('status', ['confirmed', 'completed'])
            ->sum('total_harga');

        $totalBookings = (clone $bookingsQuery)->count();

        $statusBreakdown = (clone $bookingsQuery)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // Riwayat Transaksi Detail
        $recentTransactions = Booking::with(['user', 'kapster'])
            ->whereYear('tgl_booking', $year)
            ->whereMonth('tgl_booking', $month)
            ->orderBy('tgl_booking', 'desc')
            ->take(10)
            ->get();

        return view('admin.reports.index', compact(
            'totalUsers',
            'newUsersThisMonth',
            'kapsterPerformance',
            'popularServices',
            'totalRevenue',
            'totalBookings',
            'statusBreakdown',
            'recentTransactions',
            'month',
            'year'
        ));
    }
}