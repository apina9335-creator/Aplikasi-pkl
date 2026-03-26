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
        Schema::table('internship_applications', function (Blueprint $table) {
            $table->enum('registration_type', ['individu', 'kelompok'])->default('individu')->after('status');
            $table->text('group_members')->nullable()->after('registration_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internship_applications', function (Blueprint $table) {
            //
        });
    }
};
