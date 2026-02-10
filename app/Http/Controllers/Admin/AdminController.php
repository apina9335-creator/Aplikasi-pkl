<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_mahasiswa' => User::where('role', 'mahasiswa')->count(),
            'total_dosen' => User::where('role', 'dosen')->count(),
            'total_perusahaan' => Company::count(),
            'pending_internships' => Internship::where('status', 'pending')->count(),
            'active_internships' => Internship::where('status', 'approved')
                ->where('end_date', '>=', now())
                ->count(),
        ];

        $recentInternships = Internship::with(['student', 'company'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentInternships'));
    }

    public function importUsers(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
            'role' => 'required|in:mahasiswa,dosen'
        ]);

        // Process Excel file
        $file = $request->file('file');
        $data = \Excel::toArray([], $file)[0];
        
        $imported = 0;
        foreach ($data as $row) {
            // Process each row
            $userData = [
                'name' => $row[0],
                'email' => $row[1],
                // ... map other columns
                'role' => $request->role,
                'password' => bcrypt('password123') // Default password
            ];
            
            User::create($userData);
            $imported++;
        }

        return redirect()->back()->with('success', "Berhasil mengimport {$imported} data.");
    }
}