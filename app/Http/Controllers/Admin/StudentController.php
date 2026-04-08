<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->where('role', 'mahasiswa');

        if ($search = $request->query('q')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('school', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $students = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nim' => 'nullable|string|max:50',
            'school' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $data['role'] = 'mahasiswa';
        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $student = User::where('role', 'mahasiswa')->findOrFail($id);
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $student = User::where('role', 'mahasiswa')->findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$id}",
            'nim' => 'nullable|string|max:50',
            'school' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        $student->update($data);

        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $student = User::where('role', 'mahasiswa')->findOrFail($id);
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil dihapus.');
    }

    /**
     * Download Excel Data Siswa
     */
    public function exportExcel()
    {
        // 1. Ambil data semua siswa
        $students = \App\Models\User::where('role', 'student')
                        ->orWhere('role', 'mahasiswa')
                        ->get();

        // 2. Buat header untuk file CSV/Excel
        $csvData = "No,Nama,NIS/NIM,Asal Sekolah,Email,No. HP\n";

        // 3. Masukkan data per baris
        foreach ($students as $index => $student) {
            // Karena kadang ada koma di nama sekolah, kita bungkus pakai tanda kutip
            $nama    = '"' . str_replace('"', '""', $student->name) . '"';
            $nis     = '"' . str_replace('"', '""', $student->nis ?? $student->id_number ?? '-') . '"';
            $sekolah = '"' . str_replace('"', '""', $student->school ?? '-') . '"';
            $email   = '"' . str_replace('"', '""', $student->email) . '"';
            $phone   = '"' . str_replace('"', '""', $student->phone ?? $student->phone_number ?? '-') . '"';

            $csvData .= ($index + 1) . ",{$nama},{$nis},{$sekolah},{$email},{$phone}\n";
        }

        // 4. Perintah browser untuk download sebagai file CSV (Excel)
        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="Data_Siswa_SIPKL.csv"');
    }
}
