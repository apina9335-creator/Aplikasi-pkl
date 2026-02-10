<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;
use Auth;

class InternshipApplicationController extends Controller
{
    /**
     * Display a listing of all applications
     */
    public function index()
    {
        $applications = InternshipApplication::with(['user', 'company'])
            ->latest()
            ->paginate(15);
        return view('admin.internship_applications.index', compact('applications'));
    }

    /**
     * Display the specified application
     */
    public function show(InternshipApplication $internshipApplication)
    {
        $internshipApplication->load(['user', 'company']);
        return view('admin.internship_applications.show', compact('internshipApplication'));
    }

    /**
     * Approve an application
     */
    public function approve(InternshipApplication $internshipApplication)
    {
        if (!$internshipApplication->isPending()) {
            return redirect()->back()->with('error', 'Aplikasi sudah diproses.');
        }

        $internshipApplication->update([
            'status' => 'approved',
            'approved_at' => now()->toDateString(),
            'approved_by' => Auth::user()->name,
        ]);

        return redirect()
            ->route('admin.internship-applications.show', $internshipApplication)
            ->with('success', 'Aplikasi PKL disetujui.');
    }

    /**
     * Reject an application
     */
    public function reject(Request $request, InternshipApplication $internshipApplication)
    {
        if (!$internshipApplication->isPending()) {
            return redirect()->back()->with('error', 'Aplikasi sudah diproses.');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:10|max:500',
        ]);

        $internshipApplication->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'approved_by' => Auth::user()->name,
            'approved_at' => now()->toDateString(),
        ]);

        return redirect()
            ->route('admin.internship-applications.show', $internshipApplication)
            ->with('success', 'Aplikasi PKL ditolak.');
    }
}
