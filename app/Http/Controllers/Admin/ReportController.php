<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kapster;
use App\Models\Service;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
// PDF facade provided by barryvdh/laravel-dompdf
use Barryvdh\DomPDF\Facade\Pdf as PDF;

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
                  ->whereIn('status', ['completed']); // Hanya menghitung yang valid
        }])->get();

        // 4. DATA DARI TABEL SERVICES (Layanan Terlaris)
        // Perbaikan: Gunakan whereHas untuk memastikan filter tgl_booking merujuk ke tabel bookings
        $popularServices = Service::withCount(['bookings' => function($query) use ($month, $year) {
            $query->whereYear('tgl_booking', $year)
                  ->whereMonth('tgl_booking', $month)
                  ->whereIn('status', ['completed']);
        }])
        ->orderBy('bookings_count', 'desc')
        ->take(5)
        ->get();

        // 5. DATA DARI TABEL BOOKINGS (Financial & Operations)
        // Base query untuk efisiensi
        $bookingsQuery = Booking::whereYear('tgl_booking', $year)
            ->whereMonth('tgl_booking', $month);

        $totalRevenue = (clone $bookingsQuery)
            ->whereIn('status', ['completed'])
            ->sum('total_harga');

        $totalBookings = (clone $bookingsQuery)
            ->whereIn('status', ['completed'])
            ->count();

        $statusBreakdown = (clone $bookingsQuery)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // 6. DAILY REVENUE: total pendapatan per hari dalam bulan yang dipilih
        $dailyRevenueData = Booking::select(
                DB::raw('DAY(tgl_booking) as day'),
                DB::raw('SUM(total_harga) as total')
            )
            ->whereYear('tgl_booking', $year)
            ->whereMonth('tgl_booking', $month)
            ->whereIn('status', ['completed'])
            ->groupBy('day')
            ->pluck('total', 'day');

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
            'dailyRevenueData',
            'recentTransactions',
            'month',
            'year'
        ));
    }

    /**
     * Export the current report view to PDF.
     */
    public function pdf(Request $request)
    {
        $month = (int) $request->get('month', date('m'));
        $year = (int) $request->get('year', date('Y'));

        // Reuse same queries as index to prepare data
        $kapsterPerformance = Kapster::withCount(['bookings' => function($query) use ($month, $year) {
            $query->whereYear('tgl_booking', $year)
                  ->whereMonth('tgl_booking', $month)
                  ->whereIn('status', ['completed']);
        }])->get();

        $popularServices = Service::withCount(['bookings' => function($query) use ($month, $year) {
            $query->whereYear('tgl_booking', $year)
                  ->whereMonth('tgl_booking', $month)
                  ->whereIn('status', ['completed']);
        }])->orderBy('bookings_count', 'desc')->take(5)->get();

        $bookingsQuery = Booking::whereYear('tgl_booking', $year)
            ->whereMonth('tgl_booking', $month);

        $totalRevenue = (clone $bookingsQuery)
            ->whereIn('status', ['completed'])
            ->sum('total_harga');

        $totalBookings = (clone $bookingsQuery)
            ->whereIn('status', ['completed'])
            ->count();

        $statusBreakdown = (clone $bookingsQuery)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        $dailyRevenueData = Booking::select(
                DB::raw('DAY(tgl_booking) as day'),
                DB::raw('SUM(total_harga) as total')
            )
            ->whereYear('tgl_booking', $year)
            ->whereMonth('tgl_booking', $month)
            ->whereIn('status', ['completed'])
            ->groupBy('day')
            ->pluck('total', 'day');

        $data = compact(
            'kapsterPerformance',
            'popularServices',
            'totalRevenue',
            'totalBookings',
            'statusBreakdown',
            'dailyRevenueData',
            'month',
            'year'
        );

        $pdf = PDF::loadView('admin.reports.pdf', $data)->setPaper('a4', 'landscape');

        $fileName = sprintf('report-%04d-%02d.pdf', $year, $month);
        return $pdf->download($fileName);
    }
}