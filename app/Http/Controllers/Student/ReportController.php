<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 

class ReportController extends Controller
{
    // 1. INDEX: Menampilkan Daftar
    public function index()
    {
        // Cari data PKL mahasiswa yang sedang login
        $internship = Internship::where('student_id', Auth::id())->first();

        // Jika ada data PKL, ambil laporannya berdasarkan internship_id
        $reports = $internship 
            ? Report::where('internship_id', $internship->id)->orderBy('activity_date', 'desc')->get() 
            : collect(); // Jika belum daftar PKL, kembalikan array kosong
                             
        return view('student.reports.index', compact('reports'));
    }

    // 2. CREATE: Menampilkan Form
    public function create()
    {
        $internship = Internship::where('student_id', Auth::id())->first();

        // Cegah mahasiswa yang belum daftar PKL untuk membuat laporan
        if (!$internship) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Maaf, Anda belum memiliki data PKL.');
        }

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

        $internship = Internship::where('student_id', Auth::id())->first();

        if (!$internship) {
            return back()->with('error', 'Gagal menyimpan. Data pendaftaran PKL Anda tidak ditemukan.');
        }

        $imagePath = null;
        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('reports', 'public');
        }

        // PERBAIKAN: Gunakan internship_id (bukan user_id)
        Report::create([
            'internship_id' => $internship->id, 
            'activity_date' => $request->activity_date,
            'description'   => $request->description,
            'image_path'    => $imagePath,
            'status'        => 'pending',
            
            // Kolom bawaan wajib dari migrasi, kita isi nilai default
            'title'         => 'Laporan ' . \Carbon\Carbon::parse($request->activity_date)->format('d-M-Y'), 
            'file_path'     => '-', 
        ]);

        return redirect()->route('student.reports.index')->with('success', 'Laporan berhasil disimpan!');
    }

    // 4. EDIT: Menampilkan Form Edit
    public function edit($id)
    {
        $internship = Internship::where('student_id', Auth::id())->firstOrFail();
        
        // Cari laporan berdasarkan internship_id
        $report = Report::where('internship_id', $internship->id)->findOrFail($id);
        
        // Cegah edit jika sudah disetujui
        if ($report->status == 'approved') {
            return back()->with('error', 'Laporan yang sudah disetujui dosen tidak bisa diedit.');
        }

        return view('student.reports.edit', compact('report'));
    }

    // 5. UPDATE: Menyimpan Perubahan
    public function update(Request $request, $id)
    {
        $internship = Internship::where('student_id', Auth::id())->firstOrFail();
        $report = Report::where('internship_id', $internship->id)->findOrFail($id);

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
        
        // Update title agar sesuai tanggal baru
        $report->title = 'Laporan ' . \Carbon\Carbon::parse($request->activity_date)->format('d-M-Y');
        
        $report->save();

        return redirect()->route('student.reports.index')->with('success', 'Laporan berhasil diperbarui!');
    }

    // 6. DESTROY: Menghapus Laporan
    public function destroy($id)
    {
        $internship = Internship::where('student_id', Auth::id())->firstOrFail();
        $report = Report::where('internship_id', $internship->id)->findOrFail($id);

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