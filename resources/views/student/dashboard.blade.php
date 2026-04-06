<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard Mahasiswa') }}
            </h2>
            <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ now()->format('d F Y') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 min-h-[calc(100vh-5rem)] bg-slate-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto">
            
            {{-- Welcome Banner --}}
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl shadow-lg mb-8 overflow-hidden relative">
                {{-- Ornamen Lingkaran Transparan di Background --}}
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-48 h-48 rounded-full bg-white opacity-10 blur-2xl"></div>
                <div class="absolute bottom-0 right-20 -mb-8 w-32 h-32 rounded-full bg-white opacity-10 blur-xl"></div>
                
                <div class="px-6 py-8 sm:px-8 sm:py-10 relative z-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2 tracking-tight">
                                Selamat Datang, {{ Auth::user()->name }}! 👋
                            </h1>
                            <p class="text-blue-100 text-sm sm:text-base font-medium">
                                Kelola dan pantau status Praktek Kerja Lapangan Anda di sini
                            </p>
                        </div>
                        <div class="hidden sm:block">
                            <svg class="w-20 h-20 text-white opacity-20 transform -rotate-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Status PKL Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden mb-8 transition-all duration-300 hover:shadow-md">
                <div class="border-b border-gray-100 dark:border-gray-700 px-6 py-4 bg-gray-50/50 dark:bg-gray-800/50">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-blue-100 dark:bg-blue-900/40 rounded-xl">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Status PKL Anda</h3>
                    </div>
                </div>
                
                <div class="p-6">
                    @if(!$application)
                        {{-- KONDISI 1: BELUM DAFTAR --}}
                        <div class="bg-blue-50 dark:bg-blue-900/10 rounded-2xl p-8 text-center border border-blue-100 dark:border-blue-800/30">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center mb-5 shadow-sm border border-blue-100 dark:border-gray-700">
                                    <svg class="w-10 h-10 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Belum Mendaftar PKL</h4>
                                <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md">
                                    Anda belum mengajukan pendaftaran PKL. Silakan daftar sekarang untuk memulai proses magang.
                                </p>
                                <a href="{{ route('student.internship-applications.index') }}" 
                                   class="inline-flex items-center gap-2 px-8 py-3.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all duration-200 shadow-md hover:shadow-lg hover:-translate-y-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Daftar PKL Sekarang
                                </a>
                            </div>
                        </div>

                    @elseif($application->status == 'pending')
                        {{-- KONDISI 2: SUDAH DAFTAR, TAPI MASIH PENDING --}}
                        <div class="bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-200 dark:border-yellow-800/30 rounded-2xl p-6">
                            <div class="flex items-start gap-5">
                                <div class="flex-shrink-0">
                                    <div class="w-14 h-14 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center shadow-sm border border-yellow-100 dark:border-gray-700 pulse-slow">
                                        <svg class="w-7 h-7 text-yellow-500 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 pt-1">
                                    <h4 class="text-lg font-bold text-yellow-800 dark:text-yellow-300 mb-1">Menunggu Persetujuan Admin</h4>
                                    <p class="text-yellow-700 dark:text-yellow-400/80 text-sm mb-4">
                                        Lamaran Anda sedang dalam proses review oleh admin sekolah/kampus.
                                    </p>
                                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-100 dark:bg-yellow-900/40 rounded-lg text-sm font-medium text-yellow-700 dark:text-yellow-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Fitur laporan harian akan terbuka otomatis setelah disetujui
                                    </div>
                                </div>
                            </div>
                        </div>

                    @elseif($application->status == 'rejected')
                        {{-- KONDISI 3: DITOLAK --}}
                        <div class="bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800/30 rounded-2xl p-6">
                            <div class="flex items-start gap-5">
                                <div class="flex-shrink-0">
                                    <div class="w-14 h-14 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center shadow-sm border border-red-100 dark:border-gray-700">
                                        <svg class="w-7 h-7 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 pt-1">
                                    <h4 class="text-lg font-bold text-red-800 dark:text-red-300 mb-1">Mohon Maaf, Lamaran Ditolak</h4>
                                    <p class="text-red-700 dark:text-red-400/80 text-sm mb-4">
                                        Silakan hubungi admin untuk informasi lebih lanjut atau ajukan ulang pendaftaran Anda.
                                    </p>
                                    @if($application->notes)
                                        <div class="p-4 bg-white dark:bg-gray-800 border border-red-100 dark:border-red-900/50 rounded-xl shadow-sm">
                                            <p class="text-xs text-red-500 dark:text-red-400 font-bold uppercase tracking-wider mb-1">Catatan Penolakan:</p>
                                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $application->notes }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    @elseif($application->status == 'approved')
                      {{-- Welcome Message --}}
                            <div class="bg-emerald-50 dark:bg-gray-800 border border-emerald-200 dark:border-gray-700 rounded-2xl p-6 shadow-sm">
                                <div class="flex items-center gap-5">
                                    <div class="flex-shrink-0">
                                        <div class="w-14 h-14 bg-white dark:bg-gray-700 rounded-full flex items-center justify-center shadow-sm border border-emerald-100 dark:border-gray-600">
                                            <span class="text-2xl">🎉</span>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Selamat! Anda Diterima PKL</h4>
                                        <p class="text-gray-600 dark:text-gray-300 text-sm">
                                            Anda telah resmi diterima. Silakan mulai rutinitas mengisi laporan kegiatan harian Anda di bawah.
                                        </p>
                                        @if($application->company_name)
                                            <div class="mt-3 inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-100 dark:bg-gray-700 border border-transparent dark:border-gray-600 rounded-lg text-xs font-semibold text-emerald-800 dark:text-gray-200">
                                                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                                {{ $application->company_name }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- FITUR LAPORAN HARIAN & RIWAYAT --}}
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                                
                                {{-- Form Input Kegiatan (Porsi Lebih Besar) --}}
                                <div class="lg:col-span-7 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                                    <div class="border-b border-gray-100 dark:border-gray-700 px-6 py-4 bg-gray-50/50 dark:bg-gray-800/50">
                                        <h4 class="font-bold text-gray-800 dark:text-white flex items-center gap-2">
                                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Input Laporan Hari Ini
                                        </h4>
                                    </div>
                                    
                                    <div class="p-6">
                                        <form action="{{ route('student.reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                                            @csrf
                                            
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                                    Tanggal Kegiatan
                                                </label>
                                                <input type="date" name="activity_date" 
                                                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white focus:bg-white dark:focus:bg-gray-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all duration-200" 
                                                       required>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                                    Deskripsi Kegiatan
                                                </label>
                                                <textarea name="description" rows="4" 
                                                          class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white placeholder-gray-400 focus:bg-white dark:focus:bg-gray-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all duration-200 resize-none" 
                                                          placeholder="Contoh: Memperbaiki bug pada fitur login, melakukan testing sistem..." 
                                                          required></textarea>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                                    Bukti Foto <span class="text-xs font-normal text-gray-400">(Opsional, Maks 2MB)</span>
                                                </label>
                                                <div class="relative group border-2 border-dashed border-gray-200 dark:border-gray-600 rounded-xl p-6 hover:border-blue-400 hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-all duration-200 text-center">
                                                    <input type="file" name="photo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                                    <div class="flex flex-col items-center justify-center gap-2">
                                                        <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center group-hover:bg-blue-100 dark:group-hover:bg-blue-900/40 transition-colors">
                                                            <svg class="h-5 w-5 text-gray-500 dark:text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                                            </svg>
                                                        </div>
                                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                                            <span class="font-semibold text-blue-600 dark:text-blue-400">Klik untuk upload</span> foto kegiatan
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="submit" 
                                                    class="w-full mt-2 bg-blue-600 text-white font-semibold py-3 px-4 rounded-xl hover:bg-blue-700 transition-all duration-200 shadow-md hover:shadow-lg hover:-translate-y-0.5 flex justify-center items-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                                </svg>
                                                Kirim Laporan
                                            </button>
                                        </form>
                                    </div>
                                </div>

                              {{-- Informasi dan Link Riwayat (Porsi Lebih Kecil) --}}
                                <div class="lg:col-span-5 flex flex-col gap-6">
                                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden relative flex-1 flex flex-col">
                                        {{-- Background Pattern (Titik-titik transparan) --}}
                                        <div class="absolute inset-0 opacity-[0.03] dark:opacity-10 text-gray-900 dark:text-white" style="background-image: radial-gradient(circle at 2px 2px, currentColor 1px, transparent 0); background-size: 20px 20px;"></div>
                                        
                                        <div class="p-8 relative z-10 flex flex-col h-full justify-center items-center text-center">
                                            <div class="w-20 h-20 bg-blue-50 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center mb-5 border border-blue-100 dark:border-blue-800/50">
                                                <svg class="w-10 h-10 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            
                                            <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Riwayat Laporan</h4>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-8 leading-relaxed">
                                                Akses seluruh rekam jejak kegiatan PKL Anda yang telah dikirimkan sebelumnya.
                                            </p>
                                            
                                            <a href="{{ route('student.reports.index') }}" 
                                               class="w-full bg-blue-50 dark:bg-gray-700 text-blue-700 dark:text-blue-400 font-bold py-3.5 px-6 rounded-xl hover:bg-blue-100 dark:hover:bg-gray-600 transition-all duration-200 border border-blue-100 dark:border-gray-600 hover:-translate-y-0.5">
                                                Lihat Semua Laporan
                                            </a>

                                            {{-- Statistik sederhana --}}
                                            @if(isset($reportsCount))
                                            <div class="w-full mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
                                                <div class="flex justify-between items-center px-2">
                                                    <span class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Laporan Terkirim</span>
                                                    <span class="font-black text-3xl text-gray-900 dark:text-white">{{ $reportsCount }}</span>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {{-- STYLE DIKELUARKAN DARI PUSH AGAR DIJAMIN RENDER --}}
    <style>
        .pulse-slow {
            animation: pulse-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse-slow {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }
        
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }
        
        /* Custom scrollbar untuk Textarea */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .dark ::-webkit-scrollbar-thumb {
            background: #4b5563;
        }
        
        /* Style untuk Date Picker agar rapi */
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: grayscale(100%);
            opacity: 0.5;
            cursor: pointer;
        }
        .dark input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(100%) grayscale(100%);
            opacity: 0.4;
        }
    </style>
</x-app-layout>