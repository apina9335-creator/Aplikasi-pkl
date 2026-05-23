<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Wajib ditambahkan untuk hapus file

class InternshipApplicationController extends Controller
{
    public function index()
    {
        $applications = InternshipApplication::latest()->get();
        return view('admin.internship_applications.index', compact('applications'));
    }

    public function show(InternshipApplication $internshipApplication)
    {
        return view('admin.internship_applications.show', compact('internshipApplication'));
    }

    public function approve(Request $request, InternshipApplication $internshipApplication)
    {
        $internshipApplication->update(['status' => 'approved']);
        return redirect()->route('admin.internship-applications.index')->with('success', 'Lamaran disetujui.');
    }

    public function reject(Request $request, InternshipApplication $internshipApplication)
    {
        $request->validate(['rejection_reason' => 'required|string']);
        
        $internshipApplication->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason
        ]);
        return redirect()->route('admin.internship-applications.index')->with('success', 'Lamaran ditolak.');
    }

    // FUNGSI BARU UNTUK MENGHAPUS DATA & FILE
    public function destroy(InternshipApplication $internshipApplication)
    {
        // 1. Hapus file proposal/dokumen dari storage jika ada
        if ($internshipApplication->attachment_path) {
            Storage::disk('public')->delete($internshipApplication->attachment_path);
        }

        // 2. Hapus data dari database
        $internshipApplication->delete();

        return redirect()->route('admin.internship-applications.index')->with('success', 'Data lamaran beserta filenya berhasil dihapus permanen.');
    }
}