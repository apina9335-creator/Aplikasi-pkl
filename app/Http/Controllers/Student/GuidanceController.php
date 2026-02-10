<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\GuidanceSession;
use App\Models\Internship;
use Illuminate\Http\Request;

class GuidanceController extends Controller
{
    public function index()
    {
        $guidanceSessions = auth()->user()->internships()
            ->with(['guidanceSessions'])
            ->latest()
            ->get();
            
        return view('student.guidance.index', compact('guidanceSessions'));
    }

    public function create(Internship $internship)
    {
        if ($internship->student_id !== auth()->id()) {
            abort(403);
        }
        
        return view('student.guidance.create', compact('internship'));
    }

    public function store(Request $request, Internship $internship)
    {
        if ($internship->student_id !== auth()->id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'session_date' => 'required|date',
            'session_time' => 'required|date_format:H:i',
            'topic' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        
        GuidanceSession::create([
            'internship_id' => $internship->id,
            'session_date' => $validated['session_date'],
            'session_time' => $validated['session_time'],
            'topic' => $validated['topic'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
        ]);
        
        return redirect()->route('student.guidance.index')->with('success', 'Sesi bimbingan berhasil dibuat');
    }

    public function show(GuidanceSession $guidanceSession)
    {
        if ($guidanceSession->internship->student_id !== auth()->id()) {
            abort(403);
        }
        
        return view('student.guidance.show', compact('guidanceSession'));
    }
}
