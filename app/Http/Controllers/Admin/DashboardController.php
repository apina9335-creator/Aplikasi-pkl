<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\InternshipApplication;
use App\Models\User;
use App\Models\Internship; // <--- BARU: Import Model Internship

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

        // 3. Ambil daftar siswa terbaru untuk ditampilkan di dashboard (jika ada)
        //    Urutkan berdasarkan waktu pendaftaran terbaru sehingga pendaftar baru terlihat
        $students = User::where('role', 'mahasiswa')
                ->with('latestInternshipApplication')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

        return view('admin.dashboard', compact('stats', 'recentApplications', 'students'));
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

        // 1. Cari data lamaran
        $application = InternshipApplication::findOrFail($id);
        
        // 2. Update status lamaran
        $application->update([
            'status' => $request->status
        ]);

        // 3. LOGIKA BARU: Jika diterima (approved), otomatis buat data PKL aktif
        if ($request->status === 'approved') {
            Internship::create([
                'student_id' => $application->user_id,     // ID Siswa
                'company_id' => $application->company_id,  // ID Perusahaan (PT Global Intermedia)
                'start_date' => $application->start_date,  // Tanggal Mulai
                'end_date'   => $application->end_date,    // Tanggal Selesai
                'status'     => 'approved',                // Status PKL Aktif
                // Note: advisor_id sementara NULL, nanti bisa di-assign oleh Admin/Dosen
            ]);
        }

        // Pesan notifikasi
        $statusMsg = $request->status == 'approved' ? 'diterima dan PKL diaktifkan' : 'ditolak';

        return redirect()->route('admin.dashboard')
            ->with('success', "Lamaran mahasiswa berhasil $statusMsg.");
    }

    /**
     * Export Data ke Excel (Format CSV)
     */
    public function exportExcel()
    {
        $applications = InternshipApplication::with('user')->get();
        
        $filename = "Data_Pendaftar_PKL_" . date('Ymd') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Nama Pendaftar', 'Email', 'Asal Sekolah', 'Tipe Daftar', 'Anggota Kelompok', 'Mulai', 'Selesai', 'Status'];

        $callback = function() use($applications, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($applications as $app) {
                $row['Nama Pendaftar']  = $app->user->name;
                $row['Email']           = $app->user->email;
                $row['Asal Sekolah']    = $app->school;
                $row['Tipe Daftar']     = strtoupper($app->registration_type);
                $row['Anggota Kelompok']= $app->group_members ?? '-';
                $row['Mulai']           = $app->start_date;
                $row['Selesai']         = $app->end_date;
                $row['Status']          = strtoupper($app->status);

                fputcsv($file, array($row['Nama Pendaftar'], $row['Email'], $row['Asal Sekolah'], $row['Tipe Daftar'], $row['Anggota Kelompok'], $row['Mulai'], $row['Selesai'], $row['Status']));
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}