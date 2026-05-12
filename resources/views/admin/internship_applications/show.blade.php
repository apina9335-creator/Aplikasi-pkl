<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <nav class="flex text-sm text-gray-500 mb-1" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2">
                        <li><a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a></li>
                        <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/></svg></li>
                        <li><a href="{{ route('admin.internship-applications.index') }}" class="hover:text-blue-600">Permohonan</a></li>
                    </ol>
                </nav>
                <h2 class="font-black text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                    {{ __('Detail Pendaftaran') }}
                </h2>
            </div>
            <a href="{{ route('admin.internship-applications.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl font-bold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Alert --}}
            @if(session('success'))
                <div class="mb-6 flex items-center p-4 text-emerald-800 border-t-4 border-emerald-500 bg-emerald-50 dark:bg-gray-800 dark:text-emerald-400 rounded-lg shadow-sm" role="alert">
                    <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <div class="ml-3 text-sm font-bold">{{ session('success') }}</div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- KOLOM KIRI: INFO UTAMA & TOKEN --}}
                <div class="lg:col-span-1 space-y-8">
                    {{-- Card Profil --}}
                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 text-center">
                        <div class="w-24 h-24 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-3xl mx-auto mb-4 flex items-center justify-center text-white text-3xl font-black shadow-xl shadow-blue-500/20">
                            {{ substr($internshipApplication->name, 0, 1) }}
                        </div>
                        <h3 class="text-xl font-black text-gray-900 dark:text-white mb-1">{{ $internshipApplication->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $internshipApplication->email }}</p>
                        
                        <div class="inline-block">
                            @if($internshipApplication->status === 'pending')
                                <span class="px-4 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-black uppercase tracking-wider">Menunggu Review</span>
                            @elseif($internshipApplication->status === 'approved')
                                <span class="px-4 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-black uppercase tracking-wider">Disetujui</span>
                            @else
                                <span class="px-4 py-1 bg-red-100 text-red-700 rounded-full text-xs font-black uppercase tracking-wider">Ditolak</span>
                            @endif
                        </div>
                    </div>

                    {{-- Card Token --}}
                    <div class="bg-blue-600 rounded-3xl p-6 text-white shadow-xl shadow-blue-500/30 relative overflow-hidden">
                        <div class="absolute right-0 top-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-16 -mt-16"></div>
                        <p class="text-blue-100 text-xs font-black uppercase tracking-widest mb-2 relative z-10">Token Akses Siswa</p>
                        <div class="text-3xl font-mono font-black tracking-widest relative z-10">
                            {{ $internshipApplication->token ?? '---' }}
                        </div>
                        <p class="text-blue-100 text-[10px] mt-4 leading-relaxed">Gunakan token ini untuk login logbook harian dan monitoring bimbingan.</p>
                    </div>
                </div>

                {{-- KOLOM KANAN: DETAIL DATA --}}
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="p-8">
                            <h4 class="text-lg font-black text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                                <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-sm">📋</span>
                                Informasi Pendaftaran
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Asal Sekolah / Kampus</label>
                                    <p class="text-gray-900 dark:text-gray-100 font-bold text-lg">{{ $internshipApplication->school }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Tipe Pendaftaran</label>
                                    <p class="text-gray-900 dark:text-gray-100 font-bold text-lg uppercase">{{ $internshipApplication->registration_type }}</p>
                                </div>
                                @if($internshipApplication->registration_type === 'kelompok')
                                <div class="md:col-span-2 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-2xl border border-gray-100 dark:border-gray-600">
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Anggota Kelompok</label>
                                    <p class="text-gray-700 dark:text-gray-300 font-medium leading-relaxed whitespace-pre-line">{{ $internshipApplication->group_members }}</p>
                                </div>
                                @endif
                            </div>

                            <div class="mt-8">
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Alasan & Motivasi Magang</label>
                                <div class="p-6 bg-blue-50/50 dark:bg-gray-900/50 rounded-2xl border border-blue-100 dark:border-gray-700 italic text-gray-700 dark:text-gray-300 leading-relaxed">
                                    "{{ $internshipApplication->motivation }}"
                                </div>
                            </div>
                        </div>

                        {{-- ACTION BUTTONS --}}
                        <div class="bg-gray-50 dark:bg-gray-700/30 p-8 border-t border-gray-100 dark:border-gray-700">
                            @if($internshipApplication->status === 'pending')
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <form action="{{ route('admin.internship-applications.approve', $internshipApplication->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Terima pendaftaran ini? Token akan dikirim via email.')" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 px-6 rounded-2xl shadow-lg shadow-emerald-500/20 transition-all flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            SETUJUI & KIRIM TOKEN
                                        </button>
                                    </form>

                                    <div class="flex-1" x-data="{ open: false }">
                                        <button @click="open = !open" class="w-full bg-white dark:bg-gray-800 border-2 border-red-500 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 font-black py-4 px-6 rounded-2xl transition-all flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            TOLAK APLIKASI
                                        </button>

                                        <div x-show="open" class="mt-4 p-6 bg-white dark:bg-gray-800 rounded-2xl border border-red-200 dark:border-red-800 shadow-xl" x-cloak>
                                            <form action="{{ route('admin.internship-applications.reject', $internshipApplication->id) }}" method="POST">
                                                @csrf
                                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Alasan Penolakan:</label>
                                                <textarea name="rejection_reason" rows="3" class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 mb-4 focus:ring-red-500" placeholder="Contoh: Kuota penuh atau data tidak valid..." required></textarea>
                                                <div class="flex gap-2">
                                                    <button type="submit" class="flex-1 bg-red-600 text-white font-bold py-2 rounded-lg text-sm">Konfirmasi Tolak</button>
                                                    <button type="button" @click="open = false" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-bold">Batal</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="p-6 rounded-2xl border {{ $internshipApplication->status === 'approved' ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-red-50 border-red-200 text-red-800' }} dark:bg-gray-800 dark:border-gray-600 flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 {{ $internshipApplication->status === 'approved' ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-600' }}">
                                        @if($internshipApplication->status === 'approved')
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                        @else
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-black">Aplikasi telah {{ $internshipApplication->status === 'approved' ? 'disetujui' : 'ditolak' }}.</p>
                                        <p class="text-sm opacity-80">Diproses oleh {{ $internshipApplication->approved_by ?? 'Admin' }} pada {{ $internshipApplication->approved_at ?? $internshipApplication->updated_at->format('d M Y') }}.</p>
                                        @if($internshipApplication->rejection_reason)
                                            <div class="mt-3 p-3 bg-white/50 dark:bg-gray-900/50 rounded-lg text-sm">
                                                <strong>Alasan Penolakan:</strong> {{ $internshipApplication->rejection_reason }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>