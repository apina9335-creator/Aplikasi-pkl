<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Controller Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\InternshipApplicationController as AdminInternshipAppController;

// Controller Student (Siswa/Mahasiswa)
use App\Http\Controllers\Student\DashboardController as StudentDashboard;
use App\Http\Controllers\Student\InternshipApplicationController as StudentInternshipApplication;
use App\Http\Controllers\Student\ReportController;

// Controller Advisor (Dosen/Guru)
use App\Http\Controllers\Advisor\DashboardController as AdvisorDashboard;
use App\Http\Controllers\Advisor\StudentActivityController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// === GROUP 1: HANYA PERLU LOGIN (AUTH) ===
Route::middleware('auth')->group(function () {
    
    // Route Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // === GROUP 2: WAJIB VERIFIKASI EMAIL (VERIFIED) ===
    Route::middleware('verified')->group(function () {

        // 1. ROUTE REDIRECT DASHBOARD UTAMA
        Route::get('/dashboard', function () {
            $user = auth()->user();
            return match($user->role) {
                'admin'   => redirect()->route('admin.dashboard'),
                'dosen'   => redirect()->route('advisor.dashboard'),
                'teacher' => redirect()->route('advisor.dashboard'), // Jaga-jaga kalau role teacher
                default   => redirect()->route('student.dashboard'), // Mahasiswa / Siswa
            };
        })->name('dashboard');


        // =====================================
        // 2. ROUTE KHUSUS ADMIN
        // =====================================
        Route::prefix('admin')->name('admin.')->middleware('check.role:admin')->group(function () {
            
            // Dashboard Utama (Hanya Kotak Angka)
            Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
            
            // Export Excel (LAMARAN & SISWA)
            Route::get('/applications/export', [AdminDashboard::class, 'exportExcel'])->name('applications.export');
            Route::get('/students/export', [AdminStudentController::class, 'exportExcel'])->name('students.export'); // <-- INI YANG BARU KITA TAMBAHKAN!
            
            // CRUD Data Siswa
            Route::resource('students', AdminStudentController::class);

            // Manajemen Lamaran PKL
            Route::get('/internship-applications', [AdminInternshipAppController::class, 'index'])->name('internship-applications.index');
            Route::get('/internship-applications/{internshipApplication}', [AdminInternshipAppController::class, 'show'])->name('internship-applications.show');
            Route::post('/internship-applications/{internshipApplication}/approve', [AdminInternshipAppController::class, 'approve'])->name('internship-applications.approve');
            Route::post('/internship-applications/{internshipApplication}/reject', [AdminInternshipAppController::class, 'reject'])->name('internship-applications.reject');
        });


        // =====================================
        // 3. ROUTE KHUSUS DOSEN / PEMBIMBING
        // =====================================
        Route::prefix('advisor')->middleware('check.role:dosen')->group(function () {
            
            // Dashboard (Daftar Siswa)
            Route::get('/dashboard', [AdvisorDashboard::class, 'index'])->name('advisor.dashboard');
            
            // Monitoring Laporan Siswa
            Route::get('/monitor/{id}', [AdvisorDashboard::class, 'monitor'])->name('advisor.monitor');

            // Terima / Tolak Laporan Harian
            Route::patch('/reports/{report}/status', [StudentActivityController::class, 'updateReportStatus'])->name('advisor.reports.update-status');

            // Route Activity
            Route::resource('student-activity', StudentActivityController::class, [
                'as' => 'advisor',
                'parameters' => [
                    'student-activity' => 'student'
                ]
            ]);
        });


        // =====================================
        // 4. ROUTE KHUSUS SISWA / MAHASISWA
        // =====================================
        Route::prefix('student')->name('student.')->middleware('check.role:mahasiswa')->group(function () {
            
            // Dashboard & Pendaftaran PKL
            Route::get('/dashboard', [StudentDashboard::class, 'index'])->name('dashboard');
            Route::resource('internship-applications', StudentInternshipApplication::class);

            // Manajemen Laporan Harian (FULL)
            Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
            Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
            Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
            Route::get('/reports/{id}/edit', [ReportController::class, 'edit'])->name('reports.edit');
            Route::put('/reports/{id}', [ReportController::class, 'update'])->name('reports.update');
            Route::delete('/reports/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');
        });

    }); // End of Verified Middleware
}); // End of Auth Middleware

require __DIR__.'/auth.php';