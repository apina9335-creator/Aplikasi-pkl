<?php

namespace App\Http\Controllers\Advisor;

use App\Http\Controllers\Controller;
use App\Models\InternshipApplication;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Menampilkan Daftar Siswa Binaan (Yang sudah diterima PKL)
    public function index(Request $request)
    {
        // 1. Ambil daftar Sekolah UNIK (Distinct) untuk isi Dropdown
        // Hanya ambil dari mahasiswa yang statusnya 'approved'
        $schools = \App\Models\InternshipApplication::where('status', 'approved')
                    ->select('school')
                    ->distinct()
                    ->pluck('school');

        // 2. Query Data Siswa Magang
        $query = \App\Models\InternshipApplication::with('user')
                    ->where('status', 'approved');

        // 3. Jika ada Filter Sekolah yang dipilih
        if ($request->has('school') && $request->school != '') {
            $query->where('school', $request->school);
        }

        // Ambil data (paginate agar rapi)
        $students = $query->latest()->paginate(10);

        return view('advisor.dashboard', compact('students', 'schools'));
    }

    // Halaman Detail untuk Memantau 1 Siswa
   public function monitor($id)
    {
        // 1. Cari Data Magang berdasarkan ID Lamaran (Primary Key)
        // Kita pakai findOrFail($id) karena yang dikirim dari dashboard adalah ID Lamaran
        $internship = \App\Models\InternshipApplication::with('user')
                        ->findOrFail($id); 

        // 2. Cari Laporan Siswa Tersebut
        // Karena laporan disimpan per User, kita ambil user_id dari data internship di atas
        $reports = \App\Models\Report::where('user_id', $internship->user_id)
                        ->orderBy('activity_date', 'desc')
                        ->get();

        // 3. Kirim data ke View
        return view('advisor.monitoring', compact('internship', 'reports'));
    }
}