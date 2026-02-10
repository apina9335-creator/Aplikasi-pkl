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
        Schema::table('reports', function (Blueprint $table) {
            // Pastikan kolom 'description' memang ada di tabel reports Anda.
            // Jika di database namanya 'activities', ganti 'description' jadi 'activities'.
            // Atau jika ragu, hapus saja bagian ->after('description')
            $table->string('image_path')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }
};