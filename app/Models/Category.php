<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['nama_kategori', 'gambar_kategori'];

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}