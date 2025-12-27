<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'category_id',
        'nama_service',
        'deskripsi',
        'harga',
        'durasi',
        'gambar'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function bookings()
{
    // Sesuaikan 'booking_service' dengan nama tabel pivot Anda jika berbeda
    return $this->belongsToMany(Booking::class, 'booking_service');
}
}
