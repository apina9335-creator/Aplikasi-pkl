@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8 transition-colors duration-300">
    <div class="max-w-5xl mx-auto">
        
        {{-- Tombol Kembali --}}
        <div class="mb-6">
            <a href="{{ route('admin.internship-applications.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none transition-all duration-200 hover:-translate-x-1">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar Lamaran
            </a>
        </div>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/40 border border-green-400 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg font-medium shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- KOTAK INFO UTAMA --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-colors duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg text-blue-600 dark:text-blue-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h3 class="text-sm font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Data Pelamar</h3>
                </div>
                
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $internshipApplication->user->name }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $internshipApplication->user->email }}</p>
                <p class="text-sm text-gray-800 dark:text-gray-300 mt-2 font-medium">{{ $internshipApplication->school ?? 'Sekolah Tidak Diketahui' }}</p>

                {{-- INFO KELOMPOK / INDIVIDU --}}
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs text-gray-500 dark:text-gray-400 font-semibold">Tipe Pendaftaran:</span>
                        <span class="text-xs font-bold px-2 py-1 bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 rounded uppercase border border-indigo-200 dark:border-indigo-800/50">
                            {{ $internshipApplication->registration_type ?? 'INDIVIDU' }}
                        </span>
                    </div>
                    
                    @if($internshipApplication->registration_type === 'kelompok' && !empty($internshipApplication->group_members))
                        <div class="mt-3 p-3 bg-slate-50 dark:bg-gray-900/50 rounded-lg border border-slate-100 dark:border-gray-700">
                            <p class="text-xs font-bold text-gray-500 dark:text-gray-400 mb-1">Anggota Kelompok:</p>
                            <p class="text-sm text-gray-800 dark:text-gray-200 whitespace-pre-line">{{ $internshipApplication->group_members }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-colors duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg text-purple-600 dark:text-purple-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-sm font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Tujuan PKL</h3>
                </div>
                
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $internshipApplication->company->name ?? '-' }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $internshipApplication->company->city ?? 'Yogyakarta' }}</p>

                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mb-1">Durasi Pelaksanaan PKL:</p>
                    <p class="text-sm font-bold text-gray-800 dark:text-gray-200">
                        {{ $internshipApplication->start_date ? \Carbon\Carbon::parse($internshipApplication->start_date)->translatedFormat('d M Y') : '-' }} 
                        <span class="mx-1 text-gray-400">➔</span> 
                        {{ $internshipApplication->end_date ? \Carbon\Carbon::parse($internshipApplication->end_date)->translatedFormat('d M Y') : '-' }}
                    </p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-colors duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg text-emerald-600 dark:text-emerald-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-sm font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Status Aplikasi</h3>
                </div>
                
                <div class="mt-2">
                    <span class="inline-block px-4 py-2 text-sm font-bold rounded-full border
                        @if ($internshipApplication->status === 'pending' || $internshipApplication->status === 'menunggu')
                            bg-yellow-100 dark:bg-yellow-900/40 text-yellow-800 dark:text-yellow-300 border-yellow-200 dark:border-yellow-800/50
                        @elseif ($internshipApplication->status === 'approved' || $internshipApplication->status === 'diterima')
                            bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300 border-green-200 dark:border-green-800/50
                        @else
                            bg-red-100 dark:bg-red-900/40 text-red-800 dark:text-red-300 border-red-200 dark:border-red-800/50
                        @endif
                    ">
                        {{ strtoupper($internshipApplication->status) }}
                    </span>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-4">
                    Diajukan pada: <br>
                    <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $internshipApplication->created_at?->format('d M Y, H:i') }} WIB</span>
                </p>
            </div>
        </div>

        {{-- MOTIVASI & DOKUMEN --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-colors duration-300">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Motivasi Mengikuti PKL
                </h3>
                <div class="bg-slate-50 dark:bg-gray-900/50 p-5 rounded-xl border border-slate-100 dark:border-gray-700 text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed text-sm">
                    {{ $internshipApplication->motivation }}
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-colors duration-300">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                    Dokumen Pendukung
                </h3>
                <div class="space-y-3">
                    @if ($internshipApplication->attachment_path)
                        <a href="{{ Storage::url($internshipApplication->attachment_path) }}" target="_blank" class="flex items-center justify-between p-4 bg-slate-50 dark:bg-gray-700/50 border border-slate-200 dark:border-gray-600 rounded-xl hover:bg-slate-100 dark:hover:bg-gray-700 transition-colors group">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg text-blue-600 dark:text-blue-400">📄</div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800 dark:text-gray-200">Surat Pengantar Sekolah</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Klik untuk melihat file</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        </a>
                    @endif

                    @if ($internshipApplication->cv_path)
                        <a href="{{ Storage::url($internshipApplication->cv_path) }}" target="_blank" class="flex items-center justify-between p-4 bg-slate-50 dark:bg-gray-700/50 border border-slate-200 dark:border-gray-600 rounded-xl hover:bg-slate-100 dark:hover:bg-gray-700 transition-colors group">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg text-indigo-600 dark:text-indigo-400">📑</div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800 dark:text-gray-200">Curriculum Vitae (CV)</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Klik untuk melihat file</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        </a>
                    @endif

                    @if (!$internshipApplication->attachment_path && !$internshipApplication->cv_path)
                        <p class="text-sm text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg text-center border border-dashed border-gray-300 dark:border-gray-600">Tidak ada dokumen yang dilampirkan.</p>
                    @endif
                </div>
            </div>
        </div>

        @if ($internshipApplication->isRejected())
            <div class="bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800/30 rounded-2xl p-6 mb-6">
                <h3 class="text-lg font-bold text-red-900 dark:text-red-400 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Alasan Penolakan
                </h3>
                <p class="text-red-700 dark:text-red-300 p-4 bg-white dark:bg-red-900/20 rounded-xl border border-red-100 dark:border-red-800/20">{{ $internshipApplication->rejection_reason }}</p>
                <p class="text-xs text-red-600 dark:text-red-400 mt-3 font-semibold">Telah ditolak oleh: {{ $internshipApplication->approved_by ?? 'Admin' }}</p>
            </div>
        @endif

        @if ($internshipApplication->isApproved())
            <div class="bg-green-50 dark:bg-green-900/10 border border-green-200 dark:border-green-800/30 rounded-2xl p-6 mb-6 flex items-center gap-4">
                <div class="p-3 bg-green-100 dark:bg-green-900/40 rounded-full text-green-600 dark:text-green-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-green-900 dark:text-green-400">Lamaran Disetujui</h3>
                    <p class="text-sm text-green-700 dark:text-green-300 mt-1">Disetujui oleh <span class="font-bold">{{ $internshipApplication->approved_by ?? 'Admin' }}</span> pada {{ $internshipApplication->approved_at ? \Carbon\Carbon::parse($internshipApplication->approved_at)->translatedFormat('d F Y') : '-' }}</p>
                </div>
            </div>
        @endif

        @if ($internshipApplication->isPending())
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-blue-100 dark:border-gray-700 p-6 md:p-8 mt-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 text-center">Tentukan Keputusan Anda</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
                    <form action="{{ route('admin.internship-applications.approve', $internshipApplication) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-6 py-4 bg-green-500 text-white rounded-xl font-bold hover:bg-green-600 hover:-translate-y-1 transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2"
                                onclick="return confirm('Apakah Anda yakin ingin MENYETUJUI aplikasi PKL ini?')">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Terima / Setujui Aplikasi
                        </button>
                    </form>

                    <button onclick="toggleRejectForm()" class="w-full px-6 py-4 bg-red-500 text-white rounded-xl font-bold hover:bg-red-600 hover:-translate-y-1 transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Tolak Aplikasi
                    </button>
                </div>

                <div id="rejectForm" class="hidden mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <form action="{{ route('admin.internship-applications.reject', $internshipApplication) }}" method="POST" class="bg-red-50 dark:bg-gray-700/50 p-6 rounded-xl border border-red-100 dark:border-gray-600">
                        @csrf
                        <div class="mb-4">
                            <label for="rejection_reason" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                Tuliskan Alasan Penolakan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="rejection_reason" id="rejection_reason" rows="3" required minlength="10"
                                      placeholder="Contoh: Kuota perusahaan sudah penuh..."
                                      class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors"></textarea>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Minimal 10 karakter.</p>
                            @error('rejection_reason')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex gap-3">
                            <button type="submit" class="flex-1 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-bold shadow-sm transition-colors"
                                    onclick="return confirm('Anda yakin menolak aplikasi ini secara permanen?')">
                                Konfirmasi Penolakan
                            </button>
                            <button type="button" onclick="toggleRejectForm()" class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 font-bold shadow-sm transition-colors">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    function toggleRejectForm() {
        const form = document.getElementById('rejectForm');
        // Toggle class hidden and add small animation
        if(form.classList.contains('hidden')) {
            form.classList.remove('hidden');
            form.style.opacity = 0;
            setTimeout(() => form.style.opacity = 1, 50);
        } else {
            form.classList.add('hidden');
        }
    }
</script>
@endsection