<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('kapster_shifts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('kapster_id')->constrained('kapsters')->onDelete('cascade');
        $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
        $table->time('jam_mulai')->default('10:00');
        $table->time('jam_selesai')->default('21:00');
        $table->boolean('is_libur')->default(false);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kapster_shifts');
    }
};
