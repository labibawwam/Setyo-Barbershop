<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KapsterShift extends Model
{
    protected $fillable = [
        'kapster_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'is_libur'
    ];

    // Relasi balik ke Kapster
    public function kapster()
    {
        return $this->belongsTo(Kapster::class);
    }
}