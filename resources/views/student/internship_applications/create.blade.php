@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Pendaftaran PKL Baru</h1>

        {{-- Tampilkan Error Validasi --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('student.internship-applications.store') }}" 
              method="POST" 
              enctype="multipart/form-data" 
              class="bg-white rounded-lg shadow-md p-8">
            
            @csrf

            {{-- 1. PERUSAHAAN TUJUAN (Otomatis) --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Perusahaan Tujuan
                </label>
                <div class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 text-gray-700 font-bold flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    PT Global Intermedia
                </div>
            </div>

            {{-- 2. ASAL SEKOLAH --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Asal Sekolah / Kampus *</label>
                {{-- Value: Mengambil dari profil user jika ada, agar tidak ngetik ulang --}}
                <input type="text" name="school" 
                       value="{{ old('school', Auth::user()->school) }}"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                       placeholder="Contoh: SMK Negeri 1 Yogyakarta" required>
            </div>

            {{-- 3. TANGGAL MAGANG (Grid 2 Kolom) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Rencana Tanggal Mulai *</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Rencana Tanggal Selesai *</label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
            </div> {{-- <--- INI YANG TADI HILANG DI KODE ANDA --}}

            {{-- 4. MOTIVASI --}}
            <div class="mb-6">
                <label for="motivation" class="block text-sm font-medium text-gray-700 mb-2">
                    Motivasi & Alasan Magang <span class="text-red-500">*</span>
                </label>
                <textarea name="motivation" id="motivation" rows="6" required 
                          placeholder="Jelaskan motivasi Anda magang di sini..."
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('motivation') }}</textarea>
                <p class="text-sm text-gray-500 mt-1">Minimal 50 karakter.</p>
            </div>

            {{-- 5. UPLOAD FILE --}}
            <div class="mb-6">
                <label for="attachment" class="block text-sm font-medium text-gray-700 mb-2">
                    Upload CV / Proposal (PDF/DOC) <span class="text-red-500">*</span>
                </label>
                {{-- PENTING: name="attachment" harus sama dengan Controller --}}
                <input type="file" name="attachment" id="attachment" required accept=".pdf,.doc,.docx"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 bg-gray-50">
                <p class="text-xs text-gray-500 mt-1">Maksimal ukuran file 2MB.</p>
            </div>

            {{-- TOMBOL AKSI --}}
            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-bold">
                    Kirim Lamaran
                </button>
                <a href="{{ route('student.internship-applications.index') }}" 
                   class="flex-1 px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition text-center flex items-center justify-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection