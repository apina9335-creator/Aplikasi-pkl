<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('reports', function (Blueprint $table) {
            // Tambahkan kolom penampung ID Pendaftaran (Token)
            $table->unsignedBigInteger('application_id')->nullable()->after('internship_id');
            // Longgarkan aturan internship_id karena kita pakai token
            $table->unsignedBigInteger('internship_id')->nullable()->change();
        });
    }

    public function down(): void {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('application_id');
        });
    }
};