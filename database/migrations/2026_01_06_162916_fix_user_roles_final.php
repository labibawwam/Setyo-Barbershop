<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        // Pastikan menginstal doctrine/dbal (composer require doctrine/dbal) 
        // agar fungsi ->change() ini jalan
        $table->enum('role', ['admin', 'customer'])->default('customer')->change();
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('role')->change();
    });
}
};
