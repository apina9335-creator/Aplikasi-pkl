<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class StudentController extends Controller
{
    /**
     * Tampilkan daftar siswa
     */
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['mahasiswa', 'student']);

        // Jika ada pencarian
        if ($request->has('q') && $request->q != '') {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%")
                  ->orWhere('school', 'like', "%{$searchTerm}%")
                  ->orWhere('nim', 'like', "%{$searchTerm}%")
                  ->orWhere('nis', 'like', "%{$searchTerm}%");
            });
        }

        // Ambil data siswa dengan paginasi
        $students = $query->latest()->paginate(15);

        return view('admin.students.index', compact('students'));
    }

    /**
     * Tampilkan form tambah siswa baru
     */
    public function create()
    {
        return view('admin.students.create');
    }

    /**
     * Simpan data siswa baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nis' => ['nullable', 'string', 'max:50'],
            'school' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
            'nis' => $request->nis,
            'school' => $request->school,
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.students.index')
            ->with('success', 'Akun siswa berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit siswa
     */
    public function edit($id)
    {
        $student = User::findOrFail($id);
        return view('admin.students.edit', compact('student'));
    }

    /**
     * Update data siswa
     */
    public function update(Request $request, $id)
    {
        $student = User::findOrFail($id);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            'nis' => ['nullable', 'string', 'max:50'],
            'school' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ];

        // Jika admin mengisi password baru
        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Rules\Password::defaults()];
        }

        $request->validate($rules);

        $student->name = $request->name;
        $student->email = $request->email;
        $student->nis = $request->nis;
        $student->school = $request->school;
        $student->phone = $request->phone;

        if ($request->filled('password')) {
            $student->password = Hash::make($request->password);
        }

        $student->save();

        return redirect()->route('admin.students.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Hapus data siswa
     */
    public function destroy($id)
    {
        $student = User::findOrFail($id);
        
        // Opsional: Hapus foto profil jika ada
        if ($student->profile_photo_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($student->profile_photo_path);
        }
        
        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Data siswa berhasil dihapus permanen.');
    }

    /**
     * FUNGSI BARU: Export Data Siswa ke Excel
     */
    public function exportExcel()
    {
        // 1. Ambil data siswa beserta lamaran PKL terbarunya
        $students = User::whereIn('role', ['student', 'mahasiswa'])
                        ->with('latestInternshipApplication')
                        ->get();

        // 2. Buat Header Excel (Nama Kolom)
        $csvData = "No,Nama Lengkap,NIS/NIM,Asal Sekolah,Tipe Daftar,Anggota Kelompok,Email,No. HP\n";

        // 3. Isi Data
        foreach ($students as $index => $student) {
            $app = $student->latestInternshipApplication;
            
            // Membersihkan data dari karakter yang bisa merusak format Excel/CSV
            $nama    = '"' . str_replace('"', '""', $student->name) . '"';
            $nis     = '"' . str_replace('"', '""', $student->nis ?? $student->nim ?? '-') . '"';
            $sekolah = '"' . str_replace('"', '""', $student->school ?? '-') . '"';
            
            // Logika Tipe Daftar
            $tipe = "Belum Daftar";
            $anggota = "-";
            
            if ($app) {
                $tipe = strtoupper($app->registration_type);
                // Jika kelompok, gabungkan nama anggota jadi 1 baris agar rapi di Excel
                if ($app->registration_type === 'kelompok' && $app->group_members) {
                    $anggota = '"' . str_replace(["\r", "\n", '"'], ["", "; ", '""'], $app->group_members) . '"';
                }
            }

            $email = '"' . $student->email . '"';
            $phone = '"' . ($student->phone ?? '-') . '"';

            // Gabungkan jadi baris CSV
            $csvData .= ($index + 1) . ",{$nama},{$nis},{$sekolah},{$tipe},{$anggota},{$email},{$phone}\n";
        }

        // 4. Download File
        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="Data_Siswa_SIPKL_'.date('d-m-Y').'.csv"');
    }
}