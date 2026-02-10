<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
public function index()
{
    // Ambil data lamaran user yang sedang login
    $application = \App\Models\InternshipApplication::where('user_id', auth()->id())->latest()->first();

    return view('student.dashboard', compact('application'));
}
}
