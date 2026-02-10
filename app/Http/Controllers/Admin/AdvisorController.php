<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;    
use Illuminate\Http\Request;

class AdvisorController extends Controller
{
    public function index()
    {
        $advisors = User::where('role', 'dosen')->paginate(15);
        return view('admin.advisors.index', compact('advisors'));
    }

    public function show(User $user)
    {
        if ($user->role !== 'dosen') {
            abort(404);
        }
        
        $supervisedInternships = $user->supervisedInternships()->with(['student', 'company'])->get();
        return view('admin.advisors.show', compact('user', 'supervisedInternships'));
    }

    public function edit(User $user)
    {
        if ($user->role !== 'dosen') {
            abort(404);
        }
        
        return view('admin.advisors.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role !== 'dosen') {
            abort(404);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nidn' => 'required|string|unique:users,nidn,' . $user->id,
            'phone' => 'nullable|string',
        ]);
        
        $user->update($validated);
        
        return redirect()->route('admin.advisors.show', $user)->with('success', 'Dosen berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'dosen') {
            abort(404);
        }
        
        $user->delete();
        return redirect()->route('admin.advisors.index')->with('success', 'Dosen berhasil dihapus');
    }
}
