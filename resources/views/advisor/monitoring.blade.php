<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Monitoring Siswa: ') }} <span class="text-blue-600 dark:text-blue-400">{{ $internship->user->name }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Tombol Kembali --}}
            <div class="mb-8">
                <a href="{{ route('advisor.dashboard') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-900 transition-all duration-200 hover:-translate-x-1">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar Siswa
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- KARTU PROFIL SISWA (Kiri - Lebar 1 Kolom) --}}
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden sticky top-6 transition-colors duration-300 hover:shadow-md">
                        {{-- Header Profil --}}
                        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 px-6 py-8 text-center relative">
                            {{-- Ornamen background --}}
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2"></div>
                            
                            <div class="relative z-10">
                                <div class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-white dark:bg-gray-800 shadow-xl text-4xl font-black text-blue-600 dark:text-blue-400 mb-4 border-4 border-blue-100 dark:border-gray-700">
                                    {{ substr($internship->user->name, 0, 1) }}
                                </div>
                                <h3 class="font-bold text-xl text-white tracking-wide">{{ $internship->user->name }}</h3>
                                <p class="text-blue-100 text-sm mt-1 opacity-90">{{ $internship->user->email }}</p>
                            </div>
                        </div>

                        {{-- Info Detail Profil --}}
                        <div class="p-6 space-y-4 bg-white dark:bg-gray-800">
                            
                            {{-- Asal Sekolah --}}
                            <div class="flex items-start space-x-4 p-3 rounded-xl bg-slate-50 dark:bg-gray-700/50 border border-slate-100 dark:border-gray-600/50">
                                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg text-blue-600 dark:text-blue-400 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Asal Sekolah</p>
                                    <p class="font-bold text-gray-900 dark:text-gray-100 leading-tight">{{ $internship->school }}</p>
                                </div>
                            </div>
                            
                            {{-- Tanggal Mulai --}}
                            <div class="flex items-start space-x-4 p-3 rounded-xl bg-slate-50 dark:bg-gray-700/50 border border-slate-100 dark:border-gray-600/50">
                                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg text-indigo-600 dark:text-indigo-400 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Tanggal Mulai PKL</p>
                                    <p class="font-bold text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($internship->start_date)->translatedFormat('d F Y') }}</p>
                                </div>
                            </div>

                            {{-- Tanggal Selesai (BARU DITAMBAHKAN) --}}
                            <div class="flex items-start space-x-4 p-3 rounded-xl bg-slate-50 dark:bg-gray-700/50 border border-slate-100 dark:border-gray-600/50">
                                <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg text-emerald-600 dark:text-emerald-400 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l2 2 4-4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Tanggal Selesai PKL</p>
                                    <p class="font-bold text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($internship->end_date)->translatedFormat('d F Y') }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- DAFTAR LAPORAN HARIAN (Kanan - Lebar 2 Kolom) --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="flex items-center justify-between bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <h3 class="font-bold text-xl text-gray-800 dark:text-gray-100 flex items-center gap-3">
                            <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            Logbook Kegiatan
                        </h3>
                        <span class="text-sm font-semibold text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-900/30 px-4 py-1.5 rounded-full border border-blue-100 dark:border-blue-800/50">
                            Total: {{ $reports->count() }} Laporan
                        </span>
                    </div>

                    {{-- List Laporan / Timeline --}}
                    <div class="space-y-5">
                        @forelse($reports as $report)
                            <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-all duration-300 overflow-hidden relative">
                                {{-- Garis timeline dekoratif di sebelah kiri --}}
                                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-gradient-to-b from-blue-400 to-indigo-500"></div>
                                
                                <div class="p-6 sm:p-8 ml-2">
                                    <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                                        <div>
                                            <h4 class="font-bold text-gray-900 dark:text-white text-lg flex items-center gap-2">
                                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($report->activity_date)->translatedFormat('l, d F Y') }}
                                            </h4>
                                        </div>
                                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-3 py-1.5 rounded-lg whitespace-nowrap">
                                            ⏳ Diinput {{ $report->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    
                                    <div class="space-y-5">
                                        <div class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap bg-slate-50 dark:bg-gray-900/50 p-4 rounded-xl border border-slate-100 dark:border-gray-700">
                                            {{ $report->description }}
                                        </div>

                                        @if($report->image_path)
                                            <div class="mt-2">
                                                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    Dokumentasi Kegiatan
                                                </p>
                                                <a href="{{ Storage::url($report->image_path) }}" target="_blank" class="inline-block relative group/image">
                                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/image:opacity-100 transition-opacity duration-300 rounded-xl flex items-center justify-center z-10">
                                                        <span class="text-white font-medium bg-black/50 px-3 py-1 rounded-lg backdrop-blur-sm">🔍 Perbesar Foto</span>
                                                    </div>
                                                    <img src="{{ Storage::url($report->image_path) }}" 
                                                         alt="Bukti Kegiatan {{ \Carbon\Carbon::parse($report->activity_date)->format('d M Y') }}" 
                                                         class="h-48 sm:h-56 w-auto object-cover rounded-xl shadow-sm border-2 border-gray-200 dark:border-gray-600 transition-transform duration-300 group-hover/image:scale-[1.02]">
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 bg-gray-50 dark:bg-gray-700 rounded-full flex items-center justify-center mb-5 border border-gray-100 dark:border-gray-600">
                                        <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-2">Belum Ada Logbook</h4>
                                    <p class="text-gray-500 dark:text-gray-400 max-w-sm mx-auto">
                                        Siswa ini belum mengisi atau mengirimkan satupun laporan kegiatan harian PKL-nya.
                                    </p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>