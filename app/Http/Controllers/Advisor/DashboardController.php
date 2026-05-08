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
        // 1. Cari data pendaftaran PKL berdasarkan ID
        $internship = \App\Models\InternshipApplication::with('user')->findOrFail($id);

        // 2. Kunci Keamanan Dosen (SAYA MATIKAN SEMENTARA UNTUK TESTING)
        /*
        if ($internship->advisor_id !== auth()->id()) {
            abort(403, 'Akses ditolak. Anda bukan Dosen Pembimbing untuk siswa ini.');
        }
        */

        // 3. Kita butuh ID Internship resmi untuk mencari laporannya
        $activeInternship = \App\Models\Internship::where('student_id', $internship->user_id)->first();

        // 4. Cari laporan menggunakan 'internship_id'
        $reports = collect();
        if ($activeInternship) {
            $reports = \App\Models\Report::where('internship_id', $activeInternship->id)
                                         ->orderBy('activity_date', 'desc')
                                         ->get();
        }

        return view('advisor.monitoring', compact('internship', 'reports'));
    }
}