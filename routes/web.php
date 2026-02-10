<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Student\DashboardController as StudentDashboard;
use App\Http\Controllers\Advisor\DashboardController as AdvisorDashboard;
use App\Http\Controllers\Student\InternshipApplicationController as StudentInternshipApplication;
use App\Http\Controllers\Advisor\StudentActivityController;
use App\Http\Controllers\Student\ReportController; // Pastikan ini ada

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
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
                'admin' => redirect()->route('admin.dashboard'),
                'dosen' => redirect()->route('advisor.dashboard'),
                'teacher' => redirect()->route('advisor.dashboard'), // Jaga-jaga kalau role teacher
                default => redirect()->route('student.dashboard'),
            };
        })->name('dashboard');

        // 2. ROUTE KHUSUS ADMIN
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::middleware('check.role:admin')->group(function () {
                // Dashboard
                Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
                
                // Review Lamaran
                Route::get('/applications/{id}', [AdminDashboard::class, 'show'])->name('applications.show');
                Route::patch('/applications/{id}/update', [AdminDashboard::class, 'updateStatus'])->name('applications.update');
            });
        });

        // 3. ROUTE KHUSUS DOSEN
        Route::prefix('advisor')->group(function () {
            Route::middleware('check.role:dosen')->group(function () {
                
                // Dashboard (Daftar Siswa)
                Route::get('/dashboard', [AdvisorDashboard::class, 'index'])->name('advisor.dashboard');
                
                // Monitoring Laporan Siswa
                Route::get('/monitor/{id}', [AdvisorDashboard::class, 'monitor'])->name('advisor.monitor');

                // Route Activity
                Route::resource('student-activity', StudentActivityController::class, ['as' => 'advisor']);
            });
        });

        // ... Kode atas biarkan ...

// 4. ROUTE KHUSUS MAHASISWA
Route::prefix('student')->name('student.')->group(function () {
    Route::middleware('check.role:mahasiswa')->group(function () {
        
        // Dashboard & Internship Apps
        Route::get('/dashboard', [StudentDashboard::class, 'index'])->name('dashboard');
        Route::resource('internship-applications', StudentInternshipApplication::class);

        // === MANAJEMEN LAPORAN HARIAN (FULL) ===
        // 1. Lihat Daftar
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        
        // 2. Buat Laporan Baru
        Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
        Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
        
        // 3. Edit Laporan
        Route::get('/reports/{id}/edit', [ReportController::class, 'edit'])->name('reports.edit');
        Route::put('/reports/{id}', [ReportController::class, 'update'])->name('reports.update');
        
        // 4. Hapus Laporan
        Route::delete('/reports/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');
    
    });
});

    }); // End of Verified Middleware
}); // End of Auth Middleware

require __DIR__.'/auth.php';