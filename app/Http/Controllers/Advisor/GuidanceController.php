<?php
// app/Http/Controllers/Advisor/GuidanceController.php

namespace App\Http\Controllers\Advisor;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\GuidanceSession;
use Illuminate\Http\Request;

class GuidanceController extends Controller
{
    public function index()
    {
        $internships = auth()->user()->supervisedInternships()
            ->with(['student', 'company'])
            ->where('status', 'approved')
            ->get();
            
        return view('advisor.guidance.index', compact('internships'));
    }

    public function updateSessionStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'advisor_notes' => 'required_if:status,rejected|string|max:500'
        ]);

        $session = GuidanceSession::findOrFail($id);
        $session->update([
            'status' => $request->status,
            'advisor_notes' => $request->advisor_notes
        ]);

        $statusText = $request->status === 'approved' ? 'disetujui' : 'ditolak';
        return redirect()->back()->with('success', "Bimbingan berhasil {$statusText}.");
    }

    public function inputScore(Request $request, $internshipId)
    {
        $internship = Internship::findOrFail($internshipId);
        
        // Check if minimum 4 guidance sessions approved
        if ($internship->approvedGuidanceSessions()->count() < 4) {
            return redirect()->back()
                ->with('error', 'Mahasiswa harus memiliki minimal 4x bimbingan yang disetujui.');
        }

        $request->validate([
            'score' => 'required|numeric|min:0|max:100',
            'comments' => 'required|string|max:1000'
        ]);

        $internship->score()->create([
            'score' => $request->score,
            'comments' => $request->comments,
            'graded_by' => auth()->id(),
            'graded_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Nilai berhasil diinput.');
    }
}