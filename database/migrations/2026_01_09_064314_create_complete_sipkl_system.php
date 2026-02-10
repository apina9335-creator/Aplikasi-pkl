<?php
// database/migrations/xxxx_create_complete_sipkl_system.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom ke users untuk SIPKL
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'dosen', 'mahasiswa'])
                      ->default('mahasiswa')
                      ->after('email');
            }
            
            if (!Schema::hasColumn('users', 'nim')) {
                $table->string('nim')->nullable()->after('role');
            }
            
            if (!Schema::hasColumn('users', 'nidn')) {
                $table->string('nidn')->nullable()->after('nim');
            }
            
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('nidn');
            }
            
            if (!Schema::hasColumn('users', 'major')) {
                $table->string('major')->nullable()->after('phone');
            }
            
            if (!Schema::hasColumn('users', 'semester')) {
                $table->integer('semester')->nullable()->after('major');
            }
        });

        // 2. Create companies table
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->string('phone');
            $table->string('email');
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('proposed_by')->nullable()->constrained('users');
            $table->timestamps();
        });

        // 3. Create internships table
        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('advisor_id')->nullable()->constrained('users');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->string('proposal_path')->nullable();
            $table->timestamps();
        });

        // 4. Create guidance_sessions table dengan session_time
        Schema::create('guidance_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id')->constrained('internships')->onDelete('cascade');
            $table->date('session_date');
            $table->time('session_time'); // INI PENTING
            $table->text('topic');
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->text('advisor_notes')->nullable();
            $table->timestamps();
        });

        // 5. Create reports table
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id')->constrained('internships')->onDelete('cascade');
            $table->string('title');
            $table->string('file_path');
            $table->enum('status', ['draft', 'submitted', 'reviewed', 'approved', 'rejected'])->default('draft');
            $table->text('feedback')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });

        // 6. Create scores table
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id')->constrained('internships')->onDelete('cascade');
            $table->decimal('score', 5, 2);
            $table->text('comments')->nullable();
            $table->foreignId('graded_by')->constrained('users');
            $table->timestamp('graded_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Hapus dengan urutan yang benar
        Schema::dropIfExists('scores');
        Schema::dropIfExists('reports');
        Schema::dropIfExists('guidance_sessions');
        Schema::dropIfExists('internships');
        Schema::dropIfExists('companies');
        
        // Optional: Hapus kolom dari users
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'nim', 'nidn', 'phone', 'major', 'semester']);
        });
    }
};