<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Kapster;
use App\Models\Category; // 1. Pastikan Model Category di-import
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // 2. Ambil data kategori beserta layanan di dalamnya (Eager Loading)
        // Ini akan menghilangkan error "Undefined variable $categories"
        $categories = Category::with('services')->get(); 
        
        $kapsters = Kapster::all();

        // 3. Masukkan 'categories' ke dalam array pengiriman data
        return view('welcome', [
            'categories' => $categories,
            'kapsters'   => $kapsters
        ]);
    }
}