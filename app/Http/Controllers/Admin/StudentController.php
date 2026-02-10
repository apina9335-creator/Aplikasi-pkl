<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'mahasiswa')->paginate(15);
        return view('admin.students.index', compact('students'));
    }

    public function show(User $user)
    {
        if ($user->role !== 'mahasiswa') {
            abort(404);
        }
        
        $internships = $user->internships()->with(['company', 'advisor'])->get();
        return view('admin.students.show', compact('user', 'internships'));
    }

    public function edit(User $user)
    {
        if ($user->role !== 'mahasiswa') {
            abort(404);
        }
        
        return view('admin.students.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role !== 'mahasiswa') {
            abort(404);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nim' => 'required|string|unique:users,nim,' . $user->id,
            'phone' => 'nullable|string',
            'major' => 'nullable|string',
            'semester' => 'nullable|integer|min:1|max:8',
        ]);
        
        $user->update($validated);
        
        return redirect()->route('admin.students.show', $user)->with('success', 'Mahasiswa berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'mahasiswa') {
            abort(404);
        }
        
        $user->delete();
        return redirect()->route('admin.students.index')->with('success', 'Mahasiswa berhasil dihapus');
    }
}
