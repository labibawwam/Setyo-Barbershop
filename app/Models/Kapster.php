<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kapster extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'status',
        'photo',
    ];

  public function shifts() {
    return $this->hasMany(KapsterShift::class);
}

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
