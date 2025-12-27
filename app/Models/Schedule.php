<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['kapster_id', 'service_id', 'date', 'start_time', 'end_time'];

    public function booking()
    {
        return $this->hasOne(Booking::class);
    }

    public function kapster()
    {
        return $this->belongsTo(Kapster::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}