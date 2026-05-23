<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        // 1. AMBIL SEMUA PENDAFTAR YANG SUDAH DI-ACC (APPROVED)
        $students = InternshipApplication::where('status', 'approved')->latest()->get();

        $pklStudents = collect();
        $magangStudents = collect();
        $otherStudents = collect();

        // 2. LOGIKA PEMISAHAN PKL (SMK) DAN MAGANG (KAMPUS)
        foreach ($students as $student) {
            $schoolNameLower = strtolower($student->school ?? '');

            if (empty($schoolNameLower)) {
                $otherStudents->push($student);
            } elseif (str_contains($schoolNameLower, 'smk') || str_contains($schoolNameLower, 'sma') || str_contains($schoolNameLower, 'sekolah')) {
                $pklStudents->push($student);
            } elseif (str_contains($schoolNameLower, 'universitas') || str_contains($schoolNameLower, 'institut') || str_contains($schoolNameLower, 'politeknik') || str_contains($schoolNameLower, 'akademi') || str_contains($schoolNameLower, 'ugm') || str_contains($schoolNameLower, 'uin')) {
                $magangStudents->push($student);
            } else {
                // Masuk Lainnya jika tidak ada kata kunci yang cocok
                $otherStudents->push($student); 
            }
        }

        return view('admin.students.index', compact('pklStudents', 'magangStudents', 'otherStudents'));
    }

    // Fungsi untuk menghapus data peserta yang sudah di-ACC
    public function destroy($id)
    {
        $student = InternshipApplication::findOrFail($id);
        $student->delete();
        
        return redirect()->route('admin.students.index')->with('success', 'Data peserta berhasil dihapus dari sistem.');
    }
}