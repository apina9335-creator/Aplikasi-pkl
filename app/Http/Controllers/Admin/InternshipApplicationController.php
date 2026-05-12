<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail; // WAJIB DITAMBAHKAN UNTUK EMAIL

class InternshipApplicationController extends Controller
{
    public function index()
    {
        $applications = InternshipApplication::with(['user', 'company'])
            ->latest()
            ->paginate(15);
        return view('admin.internship_applications.index', compact('applications'));
    }

    public function show(InternshipApplication $internshipApplication)
    {
        $internshipApplication->load(['user', 'company']);
        return view('admin.internship_applications.show', compact('internshipApplication'));
    }

    public function approve(InternshipApplication $internshipApplication)
    {
        if (!$internshipApplication->isPending()) {
            return redirect()->back()->with('error', 'Aplikasi sudah diproses.');
        }

        $internshipApplication->update([
            'status' => 'approved',
            'approved_at' => now()->toDateString(),
            'approved_by' => Auth::user()->name ?? 'Admin',
        ]);

        // ==========================================
        // PROSES KIRIM EMAIL (DITERIMA / APPROVE)
        // ==========================================
        try {
            Mail::send('emails.approved', ['application' => $internshipApplication], function($message) use ($internshipApplication) {
                $message->to($internshipApplication->email)
                        ->subject('Selamat! Pendaftaran PKL Anda Diterima');
            });
        } catch (\Exception $e) {
            return redirect()->route('admin.internship-applications.show', $internshipApplication)
                             ->with('error', 'Aplikasi disetujui, TAPI gagal mengirim Email. Pastikan settingan .env benar!');
        }

        return redirect()
            ->route('admin.internship-applications.show', $internshipApplication)
            ->with('success', 'Aplikasi PKL disetujui dan Email Token berhasil dikirim ke Siswa!');
    }

    public function reject(Request $request, InternshipApplication $internshipApplication)
    {
        if (!$internshipApplication->isPending()) {
            return redirect()->back()->with('error', 'Aplikasi sudah diproses.');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:5|max:500',
        ]);

        $internshipApplication->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'approved_by' => Auth::user()->name ?? 'Admin',
            'approved_at' => now()->toDateString(),
        ]);

        // ==========================================
        // PROSES KIRIM EMAIL (DITOLAK / REJECT)
        // ==========================================
        try {
            Mail::send('emails.rejected', ['application' => $internshipApplication], function($message) use ($internshipApplication) {
                $message->to($internshipApplication->email)
                        ->subject('Mohon Maaf, Pendaftaran PKL Anda Ditolak');
            });
        } catch (\Exception $e) {
            return redirect()->route('admin.internship-applications.show', $internshipApplication)
                             ->with('error', 'Aplikasi ditolak, TAPI gagal mengirim Email penolakan ke siswa!');
        }

        return redirect()
            ->route('admin.internship-applications.show', $internshipApplication)
            ->with('success', 'Aplikasi PKL ditolak dan Email alasan penolakan berhasil dikirim!');
    }
}