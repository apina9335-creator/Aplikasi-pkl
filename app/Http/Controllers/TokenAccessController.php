<?php

namespace App\Http\Controllers;

use App\Models\InternshipApplication;
use App\Models\Report;
use Illuminate\Http\Request;

class TokenAccessController extends Controller
{
    // 1. HALAMAN LOGBOOK SISWA
    public function logbook(Request $request) {
        $token = $request->token;
        $application = InternshipApplication::where('token', $token)->first();

        if (!$application) {
            return redirect('/')->with('error', 'Token tidak ditemukan atau salah ketik!');
        }
        if ($application->status !== 'approved') {
            return redirect('/')->with('error', 'Maaf, Pendaftaran Anda belum disetujui Admin. Logbook belum bisa diisi.');
        }

        // Ambil riwayat laporan milik token ini
        $reports = Report::where('application_id', $application->id)->orderBy('activity_date', 'desc')->get();

        return view('public.logbook', compact('application', 'reports', 'token'));
    }

    // 2. SIMPAN LOGBOOK BARU
    public function storeLogbook(Request $request) {
        $request->validate([
            'activity_date' => 'required|date',
            'description'   => 'required|string',
            'photo'         => 'nullable|image|max:2048', 
        ]);

        $app = InternshipApplication::where('token', $request->token)->firstOrFail();

        $imagePath = null;
        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('reports', 'public');
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

        return redirect()->route('token.logbook', ['token' => $request->token])->with('success', 'Laporan hari ini berhasil dikirim!');
    }

    // 3. HALAMAN MONITORING DOSEN/GURU
    public function monitor(Request $request) {
        $token = $request->token;
        $application = InternshipApplication::where('token', $token)->first();

        if (!$application) {
            return redirect('/')->with('error', 'Token siswa tidak ditemukan!');
        }

        $reports = Report::where('application_id', $application->id)->orderBy('activity_date', 'desc')->get();

        return view('public.monitoring', compact('application', 'reports'));
    }

    // 4. SIMPAN KOMENTAR GURU & APPROVE LAPORAN
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