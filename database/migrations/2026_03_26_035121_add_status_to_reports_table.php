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
        // Harus dibungkus dengan Schema::table seperti ini Kak:
        Schema::table('reports', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // Ini untuk menghapus kolom jika migration di-rollback
            $table->dropColumn('status');
        });
    }
};