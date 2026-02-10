<?php

namespace App\Http\Controllers\Advisor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Internship;
use App\Models\GuidanceSession;
use App\Models\Report;
use Illuminate\Http\Request;

class StudentActivityController extends Controller
{
    /**
     * Display list of students under this advisor
     */
    public function index()
    {
        $students = User::where('role', 'mahasiswa')
            ->with(['internships', 'guidanceSessions'])
            ->paginate(10);
        return view('advisor.student_activity.index', compact('students'));
    }

    /**
     * Display student activity details
     */
    public function show(User $student)
    {
        if ($student->role !== 'mahasiswa') {
            abort(404);
        }

        $student->load(['internships']);
        $internship = $student->internships->first();
        
        $guidanceSessions = $student->guidanceSessions()->latest()->limit(5)->get();
        $reports = $student->reports()->latest()->limit(5)->get();

        $activityStats = [
            'total_guidance' => $student->guidanceSessions()->count(),
            'total_reports' => $student->reports()->count(),
            'last_guidance' => $guidanceSessions->first()?->created_at,
            'last_report' => $reports->first()?->created_at,
            'in_internship' => $internship !== null,
        ];

        return view('advisor.student_activity.show', compact('student', 'internship', 'activityStats', 'guidanceSessions', 'reports'));
    }
}
