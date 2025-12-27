<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id(); // ID
            $table->string('nama_service'); // Nama Service
            $table->text('deskripsi')->nullable(); // Deskripsi
            $table->integer('harga'); // Harga
            $table->integer('durasi'); // Durasi (menit)
            $table->string('gambar')->nullable(); // Path gambar
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
