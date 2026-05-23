<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data Statistik Utama
        $totalApplications = InternshipApplication::count();
        $pendingApplications = InternshipApplication::where('status', 'pending')->count();
        
        // Menghitung siswa yang benar-benar aktif magang (sudah ACC)
        $activeInternships = InternshipApplication::where('status', 'approved')->count();

        // 2. Data Grafik Tipe (HANYA MENGHITUNG YANG SUDAH DI-ACC / APPROVED)
        $individuCount = InternshipApplication::where('registration_type', 'individu')
                            ->where('status', 'approved')
                            ->count();
                            
        $kelompokCount = InternshipApplication::where('registration_type', 'kelompok')
                            ->where('status', 'approved')
                            ->count();

        // 3. Data Grafik Tren (HANYA MENGHITUNG YANG SUDAH DI-ACC / APPROVED)
        $recentApplications = InternshipApplication::where('status', 'approved')
                                ->where('created_at', '>=', now()->subMonths(6))
                                ->orderBy('created_at')
                                ->get();
                                
        $trendData = $recentApplications->groupBy(function($app) {
            return $app->created_at->format('M Y');
        })->map(fn($group) => $group->count());

        $trendLabels = $trendData->keys()->toArray();
        $trendValues = $trendData->values()->toArray();

        // 4. Ambil 5 Data Terbaru untuk Panel "Desktop" (Tetap tampilkan semua agar admin tahu ada yang baru masuk)
        $latestApplications = InternshipApplication::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalApplications',
            'pendingApplications',
            'activeInternships',
            'individuCount',
            'kelompokCount',
            'trendLabels',
            'trendValues',
            'latestApplications'
        ));
    }
}