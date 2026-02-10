<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Company;
use App\Models\Internship;
use App\Models\GuidanceSession;
use App\Models\Report;
use App\Models\Score;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key check
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Hapus data dengan urutan yang benar
        Score::truncate();
        Report::truncate();
        GuidanceSession::truncate();
        Internship::truncate();
        Company::truncate();
        User::truncate();
        
        // Aktifkan kembali foreign key check
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // 1. Buat Users
        $admin = User::create([
            'name' => 'Admin SIPKL',
            'email' => 'admin@sipkl.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $dosen = User::create([
            'name' => 'Dr. Ahmad Fauzi, M.Kom',
            'email' => 'dosen@sipkl.test',
            'password' => Hash::make('password'),
            'role' => 'dosen',
            'nidn' => '12345678',
            'phone' => '081234567890',
            'major' => 'Teknik Informatika',
            'email_verified_at' => now(),
        ]);

        $mahasiswa = User::create([
            'name' => 'Budi Santoso',
            'email' => 'mahasiswa@sipkl.test',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'nim' => '20210101',
            'phone' => '081234567891',
            'major' => 'Teknik Informatika',
            'semester' => 7,
            'email_verified_at' => now(),
        ]);

        // 2. Buat Companies - PERBAIKI URUTAN KOLOM
        $company1 = Company::create([
            'name' => 'PT. Teknologi Indonesia',
            'address' => 'Jl. Sudirman No. 123, Jakarta',
            'phone' => '021-1234567',
            'email' => 'hrd@teknologi-indonesia.co.id',  // Email di sini
            'website' => 'https://teknologi-indonesia.co.id', // Website di sini
            'description' => 'Perusahaan pengembangan software terkemuka di Indonesia',
            'is_active' => true,
        ]);

        $company2 = Company::create([
            'name' => 'PT. Digital Solution',
            'address' => 'Jl. Thamrin No. 45, Jakarta',
            'phone' => '021-7654321',
            'email' => 'info@digitalsolution.co.id',
            'website' => 'https://digitalsolution.co.id',
            'description' => 'Startup teknologi bidang fintech',
            'is_active' => true,
        ]);

        $company3 = Company::create([
            'name' => 'PT Global Intermedia',
            'address' => 'Jl. Gatot Subroto No. 56, Jakarta Selatan',
            'phone' => '021-5555555',
            'email' => 'hrd@globalintermedia.co.id',
            'website' => 'https://globalintermedia.co.id',
            'description' => 'Perusahaan media digital dan layanan komunikasi terpadu',
            'is_active' => true,
        ]);

        // 3. Buat Internships
        $internship = Internship::create([
            'student_id' => $mahasiswa->id,
            'company_id' => $company1->id,
            'advisor_id' => $dosen->id,
            'start_date' => now()->addDays(7),
            'end_date' => now()->addDays(100),
            'status' => 'approved',
        ]);

        // 4. Buat Guidance Sessions
        for ($i = 1; $i <= 4; $i++) {
            GuidanceSession::create([
                'internship_id' => $internship->id,
                'session_date' => now()->addDays($i * 14),
                'session_time' => '10:00:00',
                'topic' => 'Bimbingan ' . $i . ' - Progress Laporan',
                'notes' => 'Diskusi mengenai bab ' . $i . ' laporan PKL',
                'status' => $i <= 3 ? 'approved' : 'pending',
            ]);
        }

        // 5. Buat Score
        Score::create([
            'internship_id' => $internship->id,
            'score' => 85.50,
            'comments' => 'Kerja sangat baik, laporan lengkap dan rapi',
            'graded_by' => $dosen->id,
        ]);

        $this->command->info('===========================================');
        $this->command->info('Database seeded successfully!');
        $this->command->info('===========================================');
        $this->command->info('Admin: admin@sipkl.test / password');
        $this->command->info('Dosen: dosen@sipkl.test / password');
        $this->command->info('Mahasiswa: mahasiswa@sipkl.test / password');
        $this->command->info('===========================================');
    }
}