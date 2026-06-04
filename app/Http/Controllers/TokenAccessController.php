<?php

namespace App\Http\Controllers;

use App\Models\InternshipApplication;
use App\Models\Report;
use Illuminate\Http\Request;

class TokenAccessController extends Controller
{
    // ==========================================
    // 1. HALAMAN LOGBOOK SISWA (Gerbang & Isi)
    // ==========================================
    public function logbook(Request $request) {
        // Ambil token dari URL (?token=...) atau dari Session yang sudah tersimpan
        $token = $request->token ?? session('siswa_token');

        // Jika belum ada token sama sekali, tampilkan Gerbang Token
        if (!$token) {
            return view('public.token-gate', ['jenis_akses' => 'logbook']);
        }

        // Jika ada token, cek validitas ke database
        $application = InternshipApplication::where('token', $token)->first();

        if (!$application) {
            session()->forget('siswa_token'); // Hapus session jika token ngasal
            return redirect()->route('token.logbook')->with('error', 'Token tidak ditemukan atau salah ketik!');
        }

        if ($application->status !== 'approved') {
            session()->forget('siswa_token');
            return redirect()->route('token.logbook')->with('error', 'Maaf, Pendaftaran Anda belum disetujui Admin. Logbook belum bisa diisi.');
        }

        // Token Valid! Simpan di session biar refresh halaman tidak minta token terus
        session(['siswa_token' => $token]);

        // Ambil riwayat laporan milik token ini
        $reports = Report::where('application_id', $application->id)->orderBy('activity_date', 'desc')->get();

        return view('public.logbook', compact('application', 'reports', 'token'));
    }

    // ==========================================
    // 2. SIMPAN LOGBOOK BARU
    // ==========================================
    public function storeLogbook(Request $request) {
        $request->validate([
            'activity_date' => 'required|date',
            'description'   => 'required|string',
            'image'         => 'nullable|image|max:2048', // Sesuaikan dengan <input name="image"> di Blade Kakak
        ]);

        // Ambil data siswa menggunakan token yang sudah tersimpan di session
        $token = session('siswa_token') ?? $request->token;
        $app = InternshipApplication::where('token', $token)->firstOrFail();

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Karena nama input di Blade Kakak 'image' bukan 'photo'
            $imagePath = $request->file('image')->store('reports', 'public');
        }

        Report::create([
            'application_id' => $app->id,
            'activity_date'  => $request->activity_date,
            'description'    => $request->description,
            'image_path'     => $imagePath,
            'status'         => 'pending',
            'title'          => 'Laporan Harian',
            'file_path'      => '-'
        ]);

        return redirect()->route('token.logbook')->with('success', 'Laporan hari ini berhasil dikirim!');
    }

    // ==========================================
    // 3. HALAMAN MONITORING DOSEN/GURU (Gerbang & Isi)
    // ==========================================
    public function monitor(Request $request) {
        // Ambil token dari URL (?token=...) atau dari Session yang sudah tersimpan
        $token = $request->token ?? session('dosen_token');

        if (!$token) {
            return view('public.token-gate', ['jenis_akses' => 'monitoring']);
        }

        $application = InternshipApplication::where('token', $token)->first();

        if (!$application) {
            session()->forget('dosen_token');
            return redirect()->route('token.monitor')->with('error', 'Token siswa tidak ditemukan!');
        }

        // Simpan ke session
        session(['dosen_token' => $token]);

        $reports = Report::where('application_id', $application->id)->orderBy('activity_date', 'desc')->get();

        return view('public.monitoring', compact('application', 'reports'));
    }

    // ==========================================
    // 4. SIMPAN KOMENTAR GURU & APPROVE LAPORAN
    // ==========================================
    public function addComment(Request $request, Report $report)
    {
        $request->validate([
            'advisor_comment' => 'required|string|max:1000'
        ]);

        // Simpan komentar dan otomatis ubah status laporan menjadi disetujui
        $report->update([
            'advisor_comment' => $request->advisor_comment,
            'status' => 'approved' 
        ]);

        return back()->with('success', 'Komentar berhasil dikirim dan Laporan harian telah disetujui!');
    }
}