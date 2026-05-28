<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Http; // Wajib untuk API Fonnte WhatsApp

class InternshipApplicationController extends Controller
{
    public function index()
    {
        // 1. Ambil semua data lamaran terbaru
        $applications = InternshipApplication::latest()->get();

        $pklApplications = collect();
        $magangApplications = collect();

        // 2. Pisahkan pendaftar PKL (Sekolah) dan Magang (Kampus), serta HAPUS "Lainnya"
        foreach ($applications as $app) {
            $schoolNameLower = strtolower(trim($app->school ?? ''));

            if (empty($schoolNameLower) || $schoolNameLower === 'lainnya') {
                continue; // Lewati/Hapus data jika sekolah bernama "Lainnya"
            } elseif (str_contains($schoolNameLower, 'smk') || str_contains($schoolNameLower, 'sma') || str_contains($schoolNameLower, 'sekolah')) {
                $pklApplications->push($app);
            } else {
                $magangApplications->push($app);
            }
        }

        // 3. Ambil daftar sekolah unik untuk dropdown filter (tanpa "Lainnya")
        $sekolahUnik = $applications->pluck('school')->map(function($s) {
            return trim($s);
        })->filter(function($s) {
            return strtolower($s) !== 'lainnya' && !empty($s);
        })->unique()->values();

        // Mengirim variabel yang dibutuhkan ke View Blade
        return view('admin.internship_applications.index', compact('pklApplications', 'magangApplications', 'sekolahUnik'));
    }

    public function show(InternshipApplication $internshipApplication)
    {
        return view('admin.internship_applications.show', compact('internshipApplication'));
    }

    public function approve(Request $request, InternshipApplication $internshipApplication)
    {
        $tokenSiswa = 'PKL-' . strtoupper(Str::random(6));

        $internshipApplication->update([
            'status' => 'approved',
            'token' => $tokenSiswa
        ]);

        $noWa = $internshipApplication->phone;
        $namaSiswa = $internshipApplication->name;

        if ($noWa) {
            $pesanWa = "Halo *{$namaSiswa}*,\n\n";
            $pesanWa .= "Selamat! Pendaftaran PKL Anda di SIPKL telah *DISETUJUI*.\n\n";
            $pesanWa .= "Berikut adalah Token Rahasia Anda untuk mengakses Sistem Laporan PKL Harian:\n";
            $pesanWa .= "🔑 Token: *{$tokenSiswa}*\n\n";
            $pesanWa .= "Silakan masukkan token tersebut di menu Logbook website SIPKL kami.\n";
            $pesanWa .= "_Pesan ini dikirim otomatis oleh Sistem SIPKL._";

            try {
                Http::withHeaders([
                    'Authorization' => 'Z1phzJvSdieYy5FpTZHy' // Token Fonnte Kak Alfian
                ])->post('https://api.fonnte.com/send', [
                    'target' => $noWa,
                    'message' => $pesanWa,
                    'countryCode' => '62',
                ]);
            } catch (\Exception $e) {
                // Abaikan jika error jaringan
            }
        }

        return redirect()->route('admin.internship-applications.index')
                         ->with('success', 'Lamaran disetujui dan Token berhasil dikirim ke WhatsApp Siswa.');
    }

    public function reject(Request $request, InternshipApplication $internshipApplication)
    {
        $request->validate(['rejection_reason' => 'required|string']);
        
        $alasanPenolakan = $request->rejection_reason;

        $internshipApplication->update([
            'status' => 'rejected',
            'rejection_reason' => $alasanPenolakan
        ]);

        $noWa = $internshipApplication->phone;
        $namaSiswa = $internshipApplication->name;

        if ($noWa) {
            $pesanWa = "Mohon maaf *{$namaSiswa}*,\n\n";
            $pesanWa .= "Pendaftaran PKL Anda di aplikasi SIPKL terpaksa kami *TOLAK*.\n\n";
            $pesanWa .= "Alasan Penolakan dari Tim Admin:\n";
            $pesanWa .= "⚠️ _\"{$alasanPenolakan}\"_\n\n";
            $pesanWa .= "Terima kasih atas ketertarikan Anda. Jangan berkecil hati dan tetap semangat!\n";
            $pesanWa .= "_Pesan ini dikirim otomatis oleh Sistem SIPKL._";

            try {
                Http::withHeaders([
                    'Authorization' => 'Z1phzJvSdieYy5FpTZHy' // Token Fonnte Kak Alfian
                ])->post('https://api.fonnte.com/send', [
                    'target' => $noWa,
                    'message' => $pesanWa,
                    'countryCode' => '62',
                ]);
            } catch (\Exception $e) {
                // Abaikan jika error jaringan
            }
        }

        return redirect()->route('admin.internship-applications.index')
                         ->with('success', 'Lamaran berhasil ditolak dan Notifikasi WhatsApp telah dikirim ke siswa.');
    }

    public function destroy(InternshipApplication $internshipApplication)
    {
        if ($internshipApplication->attachment_path) {
            Storage::disk('public')->delete($internshipApplication->attachment_path);
        }
        
        $internshipApplication->delete();

        return redirect()->route('admin.internship-applications.index')->with('success', 'Data lamaran beserta filenya berhasil dihapus permanen.');
    }
}