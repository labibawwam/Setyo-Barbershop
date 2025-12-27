<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // Pastikan nama tabel di database adalah 'bookings'
    protected $table = 'bookings';

    protected $fillable = [
    'user_id', 'kapster_id', 'tgl_booking', 
    'jam_mulai', 'jam_selesai', 'total_harga', 'status'
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

public function services()
{
    return $this->belongsToMany(Service::class, 'booking_service');
}

public function kapster() {
    return $this->belongsTo(Kapster::class);
}
}