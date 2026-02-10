<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\User;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    public function index()
    {
        $internships = Internship::with(['student', 'company', 'advisor'])->paginate(15);
        return view('admin.internships.index', compact('internships'));
    }

    public function show(Internship $internship)
    {
        $internship->load(['student', 'company', 'advisor', 'guidanceSessions', 'reports']);
        return view('admin.internships.show', compact('internship'));
    }

    public function approve(Internship $internship)
    {
        if ($internship->status !== 'pending') {
            return redirect()->back()->with('error', 'Internship tidak dapat disetujui');
        }
        
        $internship->update(['status' => 'approved']);
        
        return redirect()->back()->with('success', 'Internship berhasil disetujui');
    }

    public function reject(Request $request, Internship $internship)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);
        
        $internship->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason']
        ]);
        
        return redirect()->back()->with('success', 'Internship berhasil ditolak');
    }
}
