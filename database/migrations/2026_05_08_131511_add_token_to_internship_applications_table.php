<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('internship_applications', function (Blueprint $table) {
            // Tambahkan kolom token unik
            $table->string('token')->nullable()->unique()->after('id');
            
            // PERBAIKAN: Longgarkan user_id DAN company_id menjadi boleh kosong
            $table->foreignId('user_id')->nullable()->change();
            $table->foreignId('company_id')->nullable()->change(); 
            
            // Tambah kolom identitas dasar
            $table->string('name')->nullable()->after('token');
            $table->string('email')->nullable()->after('name');
        });
    }

    public function down(): void {
        Schema::table('internship_applications', function (Blueprint $table) {
            $table->dropColumn(['token', 'name', 'email']);
        });
    }
};