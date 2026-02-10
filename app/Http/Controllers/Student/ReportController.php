<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // WAJIB ADA untuk hapus foto

class ReportController extends Controller
{
    // 1. INDEX: Menampilkan Daftar
    public function index()
    {
        $reports = Report::where('user_id', Auth::id())
                         ->orderBy('activity_date', 'desc')
                         ->get();
                         
        return view('student.reports.index', compact('reports'));
    }

    // 2. CREATE: Menampilkan Form
    public function create()
    {
        // Cek apakah punya akses magang (Gunakan 'student_id' sesuai DB Anda)
        $internship = Internship::where('student_id', Auth::id())->first();

        // KODE PENGAMAN (Aktifkan jika sistem sudah rilis)
        // if (!$internship || $internship->status !== 'approved') {
        //      return redirect()->route('student.reports.index')
        //         ->with('error', 'Maaf, Anda harus berstatus "Approved" untuk mengisi laporan.');
        // }

        return view('student.reports.create');
    }

    // 3. STORE: Menyimpan Data Baru
    public function store(Request $request)
    {
        $request->validate([
            'activity_date' => 'required|date',
            'description'   => 'required|string',
            'photo'         => 'nullable|image|max:2048', 
        ]);

        $imagePath = null;
        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('reports', 'public');
        }

        Report::create([
            'user_id'       => Auth::id(),
            'activity_date' => $request->activity_date,
            'description'   => $request->description,
            'image_path'    => $imagePath,
            'status'        => 'pending',
        ]);

        return redirect()->route('student.reports.index')->with('success', 'Laporan berhasil disimpan!');
    }

    // 4. EDIT: Menampilkan Form Edit
    public function edit($id)
    {
        $report = Report::where('user_id', Auth::id())->findOrFail($id);
        
        // Opsional: Cegah edit jika sudah disetujui
        if ($report->status == 'approved') {
            return back()->with('error', 'Laporan yang sudah disetujui dosen tidak bisa diedit.');
        }

        return view('student.reports.edit', compact('report'));
    }

    // 5. UPDATE: Menyimpan Perubahan
    public function update(Request $request, $id)
    {
        $report = Report::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'activity_date' => 'required|date',
            'description'   => 'required|string',
            'photo'         => 'nullable|image|max:2048',
        ]);

        // Logic Update Foto
        if ($request->hasFile('photo')) {
            // Hapus foto lama
            if ($report->image_path && Storage::disk('public')->exists($report->image_path)) {
                Storage::disk('public')->delete($report->image_path);
            }
            // Simpan foto baru
            $report->image_path = $request->file('photo')->store('reports', 'public');
        }

        $report->activity_date = $request->activity_date;
        $report->description   = $request->description;
        $report->save();

        return redirect()->route('student.reports.index')->with('success', 'Laporan berhasil diperbarui!');
    }

    // 6. DESTROY: Menghapus Laporan
    public function destroy($id)
    {
        $report = Report::where('user_id', Auth::id())->findOrFail($id);

        if ($report->status == 'approved') {
            return back()->with('error', 'Laporan yang sudah disetujui tidak bisa dihapus.');
        }

        // Hapus file fisik
        if ($report->image_path && Storage::disk('public')->exists($report->image_path)) {
            Storage::disk('public')->delete($report->image_path);
        }

        $report->delete();

        return redirect()->route('student.reports.index')->with('success', 'Laporan berhasil dihapus.');
    }
}