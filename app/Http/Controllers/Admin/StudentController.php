<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        // 1. Ambil semua pendaftar yang sudah lolos (approved)
        $students = InternshipApplication::where('status', 'approved')->latest()->get();

        $pklStudents = collect();
        $magangStudents = collect();

        // 2. Pisahkan PKL dan Magang, lalu HAPUS KATEGORI "LAINNYA"
        foreach ($students as $student) {
            $schoolNameLower = strtolower(trim($student->school ?? ''));

            if (empty($schoolNameLower) || $schoolNameLower === 'lainnya') {
                continue; // Skip / Hapus jika asalnya "Lainnya"
            } elseif (str_contains($schoolNameLower, 'smk') || str_contains($schoolNameLower, 'sma') || str_contains($schoolNameLower, 'sekolah')) {
                $pklStudents->push($student);
            } else {
                // Selain SMK/SMA masuk ke Magang (Kampus)
                $magangStudents->push($student);
            }
        }

        // 3. Ambil daftar nama sekolah/kampus untuk filter dropdown (tanpa 'Lainnya')
        $sekolahUnik = $students->pluck('school')->map(function($s) {
            return trim($s);
        })->filter(function($s) {
            return strtolower($s) !== 'lainnya' && !empty($s);
        })->unique()->values();

        return view('admin.students.index', compact('pklStudents', 'magangStudents', 'sekolahUnik'));
    }

    public function destroy($id)
    {
        $student = InternshipApplication::findOrFail($id);
        $student->delete();
        
        return redirect()->route('admin.students.index')->with('success', 'Data peserta berhasil dihapus dari sistem.');
    }
}