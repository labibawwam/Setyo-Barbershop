<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Kapster;
use App\Models\Service;
use App\Models\Schedule;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $kapsters = Kapster::all();
        $services = Service::all();
        $schedules = Schedule::all();

        return view('booking.index', compact('kapsters', 'services', 'schedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kapster_id'  => 'required|exists:kapsters,id',
            'service_id'  => 'required|exists:services,id',
            'schedule_id' => 'required|exists:schedules,id',
        ]);

        Booking::create([
            'user_id'     => auth()->id(),
            'kapster_id'  => $request->kapster_id,
            'service_id'  => $request->service_id,
            'schedule_id' => $request->schedule_id,
            'status'      => 'pending',
        ]);

        return redirect()->route('booking.success');
    }

    public function success()
    {
        return view('booking.success');
    }
}
