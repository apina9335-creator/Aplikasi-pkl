<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // <--- PENTING: Jangan lupa import ini!
use App\Models\InternshipApplication;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Statistik
        // Nama key di sini HARUS sama dengan yang dipanggil di dashboard.blade.php
        $stats = [
            'total_pelamar' => InternshipApplication::count(),
            'pending'       => InternshipApplication::where('status', 'pending')->count(),
            'diterima'      => InternshipApplication::where('status', 'approved')->count(),
            'ditolak'       => InternshipApplication::where('status', 'rejected')->count(),
        ];

        // 2. Ambil 5 Pelamar Terbaru
        $recentApplications = InternshipApplication::with('user')
                                ->latest()
                                ->take(5)
                                ->get();

        return view('admin.dashboard', compact('stats', 'recentApplications'));
    }

    /**
     * Menampilkan Detail Lamaran Mahasiswa
     */
    public function show($id)
    {
        // Cari lamaran berdasarkan ID, sekalian ambil data user-nya
        $application = InternshipApplication::with('user')->findOrFail($id);

        return view('admin.applications.show', compact('application'));
    }

    /**
     * Memproses Terima / Tolak
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected', // Hanya boleh 'approved' atau 'rejected'
        ]);

        $application = InternshipApplication::findOrFail($id);
        
        $application->update([
            'status' => $request->status
        ]);

        // Pesan notifikasi
        $statusMsg = $request->status == 'approved' ? 'diterima' : 'ditolak';

        return redirect()->route('admin.dashboard')
            ->with('success', "Lamaran mahasiswa berhasil $statusMsg.");
    }
}