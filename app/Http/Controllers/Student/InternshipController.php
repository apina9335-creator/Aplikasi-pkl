<?php
// app/Http/Controllers/Student/InternshipController.php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\Company;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    public function index()
    {
        $internships = auth()->user()->internships()
            ->with(['company', 'advisor'])
            ->latest()
            ->get();
            
        $companies = Company::where('is_active', true)->get();
        
        return view('student.internship.index', compact('internships', 'companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'proposal' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $internship = Internship::create([
            'student_id' => auth()->id(),
            'company_id' => $request->company_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'pending',
        ]);

        // Upload proposal
        if ($request->hasFile('proposal')) {
            $path = $request->file('proposal')->store('proposals');
            $internship->update(['proposal_path' => $path]);
        }

        return redirect()->route('student.internship.index')
            ->with('success', 'Pendaftaran PKL berhasil diajukan.');
    }

    public function proposeCompany(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
        ]);

        $company = Company::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'description' => $request->description,
            'is_active' => false, // Need admin approval
            'proposed_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Perusahaan berhasil diajukan. Menunggu verifikasi admin.');
    }
}