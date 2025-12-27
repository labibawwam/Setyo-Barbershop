<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom
            $table->dropColumn(['phone_number', 'profile_picture']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Jika dikembalikan (rollback), kolom dibuat lagi
            $table->string('phone_number')->nullable();
            $table->string('profile_picture')->nullable();
        });
    }
};