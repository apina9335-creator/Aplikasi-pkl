<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPKL - Monitoring Kegiatan</title>
    {{-- JALAN PINTAS: Memanggil Tailwind CSS langsung dari server internet --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-black text-slate-100 pb-20 selection:bg-red-600 selection:text-white font-sans antialiased">
    
    {{-- GLOW DECORATION --}}
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
        <div class="absolute top-[20%] left-[-10%] w-[500px] h-[500px] bg-red-900/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[10%] right-[-10%] w-[400px] h-[400px] bg-red-900/20 rounded-full blur-[100px]"></div>
    </div>

    {{-- TOP BAR --}}
    <div class="bg-zinc-900/80 backdrop-blur-md border-b border-zinc-800 sticky top-0 z-50 shadow-2xl">
        <div class="max-w-5xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center shadow-[0_0_20px_rgba(220,38,38,0.5)]">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </div>
                <div>
                    <span class="font-black text-xl tracking-tighter text-white block leading-none">SIPKL <span class="text-red-600">MONITORING</span></span>
                    <span class="text-[10px] text-zinc-500 font-bold uppercase tracking-[0.2em]">Guru / Dosen Version</span>
                </div>
            </div>
            <a href="{{ url('/') }}" class="group flex items-center gap-2 bg-zinc-800 hover:bg-red-600 transition-all duration-300 px-5 py-2.5 rounded-xl border border-zinc-700 hover:border-red-500 shadow-lg">
                <span class="text-xs font-black text-zinc-400 group-hover:text-white uppercase tracking-widest">Tutup</span>
                <svg class="w-4 h-4 text-zinc-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </a>
        </div>
    </div>

    <div class="max-w-5xl mx-auto pt-10 px-6 relative z-10">
        
        {{-- HEADER TARGET MONITORING --}}
        <div class="bg-zinc-900 border border-zinc-800 rounded-[2.5rem] p-8 md:p-10 shadow-2xl mb-12 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-80 h-full bg-gradient-to-l from-red-600/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
            
            <div class="flex flex-col md:flex-row items-center gap-8 text-center md:text-left">
                <div class="relative">
                    <div class="w-24 h-24 bg-zinc-800 rounded-[2rem] flex items-center justify-center text-red-600 text-4xl font-black shadow-2xl border-2 border-zinc-700 group-hover:border-red-600 transition-colors duration-500">
                        {{ substr($application->name, 0, 1) }}
                    </div>
                </div>

                <div class="flex-1">
                    <p class="text-[10px] font-black text-red-500 uppercase tracking-[0.3em] mb-2 flex items-center justify-center md:justify-start gap-2">
                        <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                        Monitoring Target
                    </p>
                    <h2 class="text-3xl md:text-4xl font-black text-white leading-tight mb-2 tracking-tight">{{ $application->name }}</h2>
                    <p class="text-sm font-bold text-zinc-400 flex items-center justify-center md:justify-start gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        {{ $application->school }}
                    </p>
                </div>
                
                <div class="bg-black/50 border border-zinc-800 px-6 py-4 rounded-3xl shadow-inner text-center">
                    <p class="text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-1">Total Laporan</p>
                    <p class="text-3xl font-black text-white">{{ $reports->count() }} <span class="text-sm text-red-600">Hari</span></p>
                </div>
            </div>
        </div>

        {{-- DAFTAR LAPORAN (TIMELINE) --}}
        <div class="space-y-8">
            <div class="flex items-center gap-4 px-4">
                <div class="h-[1px] flex-1 bg-gradient-to-r from-transparent via-zinc-800 to-transparent"></div>
                <h3 class="text-xl font-black text-zinc-400 uppercase tracking-[0.2em]">Rekaman Aktivitas</h3>
                <div class="h-[1px] flex-1 bg-gradient-to-r from-transparent via-zinc-800 to-transparent"></div>
            </div>

            @forelse($reports as $report)
                <div class="group bg-zinc-900 border border-zinc-800 rounded-[2.5rem] p-8 hover:border-red-600/50 hover:shadow-[0_20px_50px_rgba(0,0,0,0.5)] transition-all duration-500">
                    <div class="flex flex-col md:flex-row gap-8">
                        <div class="flex-1">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="bg-black px-5 py-2 rounded-xl text-[10px] font-black text-red-500 border border-zinc-800 uppercase tracking-[0.2em]">
                                    {{ \Carbon\Carbon::parse($report->activity_date)->translatedFormat('l, d M Y') }}
                                </div>
                                
                                <div class="h-[2px] flex-1 bg-zinc-800"></div>

                                @if($report->status == 'approved')
                                    <span class="flex items-center gap-1.5 text-[10px] font-black text-green-500 uppercase tracking-widest">
                                        <div class="w-2 h-2 bg-green-500 rounded-full shadow-[0_0_8px_rgba(34,197,94,0.8)]"></div> Disetujui
                                    </span>
                                @else
                                    <span class="flex items-center gap-1.5 text-[10px] font-black text-zinc-500 uppercase tracking-widest">
                                        <div class="w-2 h-2 bg-zinc-600 rounded-full"></div> Menunggu
                                    </span>
                                @endif
                            </div>
                            
                            <p class="text-zinc-300 leading-relaxed font-bold text-lg md:text-xl group-hover:text-white transition-colors">
                                {{ $report->description }}
                            </p>
                        </div>
                        
                        @if($report->image_path)
                            <div class="w-full md:w-64 h-40 rounded-3xl overflow-hidden shrink-0 border-4 border-black shadow-2xl group-hover:border-red-600/30 transition-all duration-500 relative">
                                <a href="{{ asset('storage/'.$report->image_path) }}" target="_blank" class="block w-full h-full">
                                    <div class="absolute inset-0 bg-red-600/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 flex items-center justify-center pointer-events-none">
                                        <svg class="w-8 h-8 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                    </div>
                                    <img src="{{ asset('storage/'.$report->image_path) }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 scale-105 group-hover:scale-110 transition-all duration-700" alt="Dokumentasi">
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-zinc-900 rounded-[2.5rem] p-20 text-center border border-zinc-800 shadow-inner">
                    <div class="w-24 h-24 bg-zinc-800 rounded-full flex items-center justify-center mx-auto mb-8 text-zinc-700">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h4 class="text-xl font-black text-white mb-2 uppercase tracking-widest">Belum Ada Aktivitas</h4>
                    <p class="text-zinc-500 font-bold">Siswa target ini belum mencatat progres harian apapun ke dalam sistem.</p>
                </div>
            @endforelse
        </div>
        
    </div>

    {{-- Footer --}}
    <footer class="mt-20 py-10 border-t border-zinc-900 text-center relative z-10">
        <div class="inline-flex items-center gap-4 px-6 py-2 bg-zinc-900 border border-zinc-800 rounded-full shadow-lg">
            <span class="text-[10px] font-black text-zinc-600 uppercase tracking-[0.4em]">Sistem Monitoring Dosen &bull; SIPKL</span>
            <div class="w-2 h-2 bg-red-600 rounded-full shadow-[0_0_10px_rgba(220,38,38,0.5)]"></div>
        </div>
    </footer>

</body>
</html>