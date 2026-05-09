<?php

namespace App\Http\Controllers;

use App\Models\InternshipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicRegistrationController extends Controller
{
    public function index() {
        return view('public.register'); // Kita akan buat view-nya di langkah 4
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'school' => 'required|string',
            'registration_type' => 'required|in:individu,kelompok',
            'group_members' => 'required_if:registration_type,kelompok',
            'motivation' => 'required|string',
        ]);

        // GENERATE TOKEN UNIK (Contoh: PKL-AB123)
        $token = 'PKL-' . strtoupper(Str::random(6));

        $application = InternshipApplication::create([
            'token' => $token,
            'name' => $request->name,
            'email' => $request->email,
            'school' => $request->school,
            'registration_type' => $request->registration_type,
            'group_members' => $request->group_members,
            'motivation' => $request->motivation,
            'status' => 'pending',
        ]);

        // Alihkan ke halaman sukses sambil membawa Token
        return redirect()->route('public.register.success', $token);
    }

    public function success($token) {
        return view('public.success', compact('token'));
    }
}