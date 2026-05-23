<?php

namespace App\Http\Controllers;

use App\Models\InternshipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicRegistrationController extends Controller
{
    public function index() {
        return view('public.register'); 
    }

    public function store(Request $request) {
        // 1. Validasi Inputan
        $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email',
            'phone'             => 'required|string|max:20', // <-- Validasi No WA
            'school'            => 'required|string',
            'registration_type' => 'required|in:individu,kelompok',
            'group_members'     => 'required_if:registration_type,kelompok',
            'motivation'        => 'required|string',
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after_or_equal:start_date',
            'document_file'     => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // 2. Simpan File Proposal
        $documentPath = null;
        if ($request->hasFile('document_file')) {
            $documentPath = $request->file('document_file')->store('applications_documents', 'public');
        }

        // 3. Generate Token
        $token = 'PKL-' . strtoupper(Str::random(6));

        // 4. Simpan ke Database
        $application = InternshipApplication::create([
            'token'             => $token,
            'name'              => $request->name,
            'email'             => $request->email,
            'phone'             => $request->phone, // <-- Simpan No WA
            'school'            => $request->school,
            'registration_type' => $request->registration_type,
            'group_members'     => $request->group_members,
            'motivation'        => $request->motivation,
            'status'            => 'pending',
            'start_date'        => $request->start_date,
            'end_date'          => $request->end_date,
            'attachment_path'   => $documentPath,
        ]);

        return redirect()->route('public.register.success', $token);
    }

    public function success($token) {
        return view('public.success', compact('token'));
    }
}