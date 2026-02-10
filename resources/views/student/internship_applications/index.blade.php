@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Aplikasi PKL Saya</h1>
                <p class="mt-2 text-gray-600">Kelola pendaftaran magang Anda</p>
            </div>
            <a href="{{ route('student.internship-applications.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                + Aplikasi Baru
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-4">
            @forelse ($applications as $app)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <div class="p-6 flex flex-col md:flex-row justify-between items-start">
                        
                        {{-- BAGIAN KIRI: INFO DETAIL --}}
                        <div class="flex-1 mb-4 md:mb-0">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    {{ $app->company->name ?? 'PT Global Intermedia' }}
                                </h3>
                                <span class="inline-block px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wide
                                    @if ($app->status === 'pending')
                                        bg-yellow-100 text-yellow-800
                                    @elseif ($app->status === 'approved')
                                        bg-green-100 text-green-800
                                    @else
                                        bg-red-100 text-red-800
                                    @endif
                                ">
                                    {{ ucfirst($app->status) }}
                                </span>
                            </div>
                            
                            <p class="text-sm text-gray-600">
                                Diajukan: {{ $app->created_at->format('d M Y') }}
                            </p>
                            
                            {{-- Info Tambahan: Disetujui/Ditolak --}}
                            @if ($app->status == 'approved')
                                <p class="text-sm text-green-700 mt-1 font-medium">
                                    ✓ Disetujui oleh Admin
                                </p>
                            @elseif ($app->status == 'rejected')
                                <p class="text-sm text-red-700 mt-1 font-medium">
                                    ✗ Ditolak
                                </p>
                            @endif
                        </div>

                        {{-- BAGIAN KANAN: TOMBOL AKSI --}}
                        <div class="flex flex-wrap gap-2">
                            
                            {{-- 1. TOMBOL LIHAT FILE PDF (BARU) --}}
                            @if($app->cv_path)
                                <a href="{{ Storage::url($app->cv_path) }}" target="_blank" 
                                   class="px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600 transition flex items-center text-sm">
                                    📄 File
                                </a>
                            @endif

                            {{-- 2. TOMBOL DETAIL --}}
                            <a href="{{ route('student.internship-applications.show', $app->id) }}" 
                               class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition text-sm">
                                Detail
                            </a>

                            {{-- 3. TOMBOL EDIT & BATAL (Hanya jika Pending) --}}
                            @if ($app->status === 'pending')
                                <a href="{{ route('student.internship-applications.edit', $app->id) }}" 
                                   class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition text-sm">
                                    Edit
                                </a>
                                
                                <form action="{{ route('student.internship-applications.destroy', $app->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition text-sm"
                                            onclick="return confirm('Yakin ingin membatalkan aplikasi ini?')">
                                        Batal
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-md p-12 text-center border-dashed border-2 border-gray-300">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <p class="text-gray-600 mb-4 text-lg">Belum ada lamaran PKL yang diajukan.</p>
                    <a href="{{ route('student.internship-applications.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        + Buat Lamaran Pertama
                    </a>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $applications->links() }}
        </div>
    </div>
</div>
@endsection