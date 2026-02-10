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
    Schema::table('users', function (Blueprint $table) {
        // Cek jika kolom belum ada, baru dibuat (agar tidak error)
        if (!Schema::hasColumn('users', 'nim')) {
            $table->string('nim', 20)->nullable()->after('email');
        }
        if (!Schema::hasColumn('users', 'phone')) {
            $table->string('phone', 20)->nullable()->after('nim');
        }
        if (!Schema::hasColumn('users', 'school')) {
            $table->string('school', 100)->nullable()->after('phone'); // Asal Sekolah
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
