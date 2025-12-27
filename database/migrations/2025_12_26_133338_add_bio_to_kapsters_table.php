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
    Schema::table('kapsters', function (Blueprint $table) {
        // Kita taruh kolom bio setelah kolom photo agar rapi
        $table->text('bio')->nullable()->after('photo'); 
    });
}

public function down()
{
    Schema::table('kapsters', function (Blueprint $table) {
        $table->dropColumn('bio');
    });
}
};
