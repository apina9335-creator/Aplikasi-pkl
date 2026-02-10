<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('internship_applications', function (Blueprint $table) {
            
            // Tambahkan ->nullable() agar data lama tidak error
            if (!Schema::hasColumn('internship_applications', 'school')) {
                $table->string('school')->nullable()->after('user_id');
            }
            
            if (!Schema::hasColumn('internship_applications', 'start_date')) {
                $table->date('start_date')->nullable()->after('school');
            }
            
            if (!Schema::hasColumn('internship_applications', 'end_date')) {
                $table->date('end_date')->nullable()->after('start_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('internship_applications', function (Blueprint $table) {
            $table->dropColumn(['school', 'start_date', 'end_date']);
        });
    }
};