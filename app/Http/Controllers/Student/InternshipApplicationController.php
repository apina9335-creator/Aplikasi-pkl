<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InternshipApplication;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
// App\Models\Internship; <--- Tidak perlu di sini

class InternshipApplicationController extends Controller
{
    /**
     * 1. Menampilkan Daftar Lamaran (INDEX)
     */
    public function index()
    {
        $applications = InternshipApplication::where('user_id', Auth::id())
            ->with('company')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('student.internship_applications.index', compact('applications'));
    }

    /**
     * 2. Menampilkan Form Pendaftaran (CREATE)
     */
    public function create()
    {
        return view('student.internship_applications.create');
    }

    /**
     * 3. Memproses Penyimpanan Data (STORE)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'school' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'motivation' => 'required|string|min:50',
            'attachment' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        try {
            $company = Company::firstOrCreate(
                ['name' => 'PT Global Intermedia'],
                [
                    'city' => 'Yogyakarta',
                    'address' => 'Jl. Taman Siswa No. ...',
                    'email' => 'hrd@globalintermedia.com'
                ]
            );

            if ($request->hasFile('attachment')) {
                $filePath = $request->file('attachment')->store('cvs', 'public');
            } else {
                return back()->withErrors(['attachment' => 'Gagal upload file.']);
            }

            InternshipApplication::create([
                'user_id'       => Auth::id(),
                'company_id'    => $company->id,
                'school'        => $validated['school'],
                'start_date'    => $validated['start_date'],
                'end_date'      => $validated['end_date'],
                'motivation'    => $validated['motivation'],
                'cv_path'       => $filePath,
                'status'        => 'pending',
                'applied_at'    => now(),
            ]);

            return redirect()->route('student.internship-applications.index')
                ->with('success', 'Lamaran ke PT Global Intermedia berhasil dikirim!');

        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * 4. Menampilkan Form Edit (EDIT)
     */
    public function edit($id)
    {
        $application = InternshipApplication::findOrFail($id);

        if ($application->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengedit lamaran ini.');
        }

        if ($application->status !== 'pending') {
            return redirect()->back()->with('error', 'Lamaran yang sudah diproses tidak dapat diedit.');
        }

        $companies = Company::all();
        return view('student.internship_applications.edit', compact('application', 'companies'));
    }

    /**
     * 5. Memproses Update Data (UPDATE)
     */
    public function update(Request $request, $id)
    {
        $application = InternshipApplication::findOrFail($id);

        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'school' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'motivation' => 'required|string|min:50',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        try {
            if ($request->hasFile('attachment')) {
                $filePath = $request->file('attachment')->store('cvs', 'public');
                if ($application->cv_path && Storage::disk('public')->exists($application->cv_path)) {
                    Storage::disk('public')->delete($application->cv_path);
                }
                $application->cv_path = $filePath;
            }

            $application->update([
                'school'     => $validated['school'],
                'start_date' => $validated['start_date'],
                'end_date'   => $validated['end_date'],
                'motivation' => $validated['motivation'],
            ]);

            return redirect()->route('student.internship-applications.index')
                ->with('success', 'Lamaran berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors(['error' => 'Gagal update: ' . $e->getMessage()]);
        }
    }

    /**
     * 6. Menampilkan Detail Lamaran (SHOW)
     */
    public function show($id)
    {
        $application = InternshipApplication::with('company')->findOrFail($id);

        if ($application->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak melihat data ini.');
        }

        return view('student.internship_applications.show', compact('application'));
    }

    /**
     * 7. Menghapus Data Lamaran (DESTROY)
     */
    public function destroy($id)
    {
        $application = InternshipApplication::findOrFail($id);

        if ($application->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak menghapus data ini.');
        }

        if ($application->status !== 'pending') {
            return back()->with('error', 'Lamaran yang sudah diproses tidak dapat dibatalkan/dihapus.');
        }

        try {
            if ($application->cv_path && Storage::disk('public')->exists($application->cv_path)) {
                Storage::disk('public')->delete($application->cv_path);
            }

            $application->delete();

            return redirect()->route('student.internship-applications.index')
                ->with('success', 'Lamaran berhasil dibatalkan.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}