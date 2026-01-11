<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Booking;

class NotificationBell extends Component
{
    protected $listeners = ['bookingUpdated' => '$refresh'];

    public function render()
    {
        return view('livewire.admin.notification-bell', [
            'notifikasiBooking' => Booking::with(['user', 'kapster'])
                ->whereIn('status', ['confirmed', 'completed', 'cancelled'])
                ->orderByDesc('updated_at')
                ->limit(10)
                ->get()
        ]);
    }
}
