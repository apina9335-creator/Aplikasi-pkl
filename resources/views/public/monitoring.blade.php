<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPKL - Monitoring Kegiatan</title>
    {{-- JALAN PINTAS: Memanggil Tailwind CSS langsung dari server internet --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Efek transisi smooth untuk gambar */
        .zoom-hover { transition: transform 0.7s ease-in-out; }
        .group:hover .zoom-hover { transform: scale(1.1); }
    </style>
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
        
        {{-- PESAN SUKSES SETELAH KOMENTAR DISIMPAN --}}
        @if(session('success'))
            <div class="mb-6 bg-green-500/20 border border-green-500 text-green-400 px-6 py-4 rounded-2xl text-sm font-bold flex items-center justify-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- HEADER TARGET MONITORING --}}
        <div class="bg-zinc-900 border border-zinc-800 rounded-[2.5rem] p-8 md:p-10 shadow-2xl mb-12 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-80 h-full bg-gradient-to-l from-red-600/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
            
            <div class="flex flex-col md:flex-row items-center gap-8 text-center md:text-left">
                <div class="relative">
                    <div class="w-24 h-24 bg-zinc-800 rounded-[2rem] flex items-center justify-center text-red-600 text-4xl font-black shadow-2xl border-2 border-zinc-700 group-hover:border-red-600 transition-colors duration-500">
                        {{ strtoupper(substr($application->name, 0, 1)) }}
                    </div>
                </div>

                <div class="flex-1">
                    <p class="text-[10px] font-black text-red-500 uppercase tracking-[0.3em] mb-2 flex items-center justify-center md:justify-start gap-2">
                        <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                        Target Magang
                    </p>
                    <h2 class="text-3xl md:text-4xl font-black text-white leading-tight mb-2 tracking-tight capitalize">{{ $application->name }}</h2>
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

        @php
            $laporanHariIni = $reports->firstWhere('activity_date', \Carbon\Carbon::today()->toDateString());
        @endphp

        {{-- HIGHLIGHT: PROGRES HARI INI --}}
        @if($laporanHariIni)
            <div class="mb-16 bg-gradient-to-br from-red-900/30 to-black border-2 border-red-600/50 rounded-[2.5rem] p-1 shadow-[0_0_50px_rgba(220,38,38,0.15)] relative overflow-hidden group">
                <div class="absolute top-0 right-8 bg-red-600 text-white text-xs font-black uppercase px-6 py-2 rounded-b-xl tracking-widest z-20 shadow-lg">
                    🔥 Progres Hari Ini
                </div>
                
                <div class="bg-zinc-900/90 rounded-[2.3rem] p-8 md:p-10 flex flex-col md:flex-row gap-8 relative z-10 backdrop-blur-sm">
                    <div class="flex-1">
                        <p class="text-red-500 font-bold mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ \Carbon\Carbon::parse($laporanHariIni->activity_date)->locale('id')->translatedFormat('l, d F Y') }}
                        </p>
                        <h3 class="text-2xl md:text-3xl font-black text-white mb-6 leading-relaxed">{{ $laporanHariIni->description }}</h3>
                        
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-black/50 border border-zinc-800">
                            @if($laporanHariIni->status == 'approved')
                                <div class="w-2 h-2 bg-green-500 rounded-full shadow-[0_0_8px_rgba(34,197,94,0.8)]"></div>
                                <span class="text-xs font-black text-green-500 uppercase tracking-widest">Disetujui Pembimbing</span>
                            @else
                                <div class="w-2 h-2 bg-yellow-500 rounded-full shadow-[0_0_8px_rgba(234,179,8,0.8)] animate-pulse"></div>
                                <span class="text-xs font-black text-yellow-500 uppercase tracking-widest">Menunggu Pemeriksaan</span>
                            @endif
                        </div>

                        {{-- KOTAK KOMENTAR GURU (HARI INI) --}}
                        @if($laporanHariIni->advisor_comment)
                            <div class="mt-6 bg-black/40 p-5 rounded-2xl border border-zinc-800 border-l-4 border-l-red-500">
                                <p class="text-[10px] text-zinc-500 font-black uppercase mb-1">Catatan Pembimbing:</p>
                                <p class="text-sm text-zinc-300 italic">"{{ $laporanHariIni->advisor_comment }}"</p>
                            </div>
                        @else
                            <form action="{{ route('token.monitor.comment', $laporanHariIni->id) }}" method="POST" class="mt-6 w-full">
                                @csrf
                                <textarea name="advisor_comment" rows="2" required class="w-full bg-black/50 border border-zinc-700 rounded-xl p-4 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-red-500 transition-colors" placeholder="Ketik catatan atau evaluasi untuk siswa di sini..."></textarea>
                                <button type="submit" class="mt-3 bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2.5 px-6 rounded-lg transition-colors shadow-lg">
                                    Simpan Komentar & Setujui
                                </button>
                            </form>
                        @endif

                    </div>

                    @if($laporanHariIni->image_path)
                        <div class="w-full md:w-80 h-56 rounded-3xl overflow-hidden shrink-0 border-4 border-zinc-800 shadow-2xl relative">
                            <a href="{{ asset('storage/'.$laporanHariIni->image_path) }}" target="_blank" class="block w-full h-full">
                                <img src="{{ asset('storage/'.$laporanHariIni->image_path) }}" class="w-full h-full object-cover zoom-hover" alt="Foto Progres">
                            </a>
                        </div>
                    @else
                        <div class="w-full md:w-80 h-56 rounded-3xl bg-zinc-800 border-2 border-dashed border-zinc-700 flex flex-col items-center justify-center text-zinc-500">
                            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="text-sm font-bold">Tidak ada foto dilampirkan</span>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- DAFTAR LAPORAN (TIMELINE LENGKAP) --}}
        <div class="space-y-8">
            <div class="flex items-center gap-4 px-4">
                <div class="h-[1px] flex-1 bg-gradient-to-r from-transparent via-zinc-800 to-transparent"></div>
                <h3 class="text-lg font-black text-zinc-500 uppercase tracking-[0.2em]">Riwayat Laporan Sebelumnya</h3>
                <div class="h-[1px] flex-1 bg-gradient-to-r from-transparent via-zinc-800 to-transparent"></div>
            </div>

            @forelse($reports as $report)
                @if($laporanHariIni && $report->id === $laporanHariIni->id)
                    @continue 
                @endif

                <div class="group bg-zinc-900 border border-zinc-800 rounded-[2rem] p-6 md:p-8 hover:border-zinc-600 transition-all duration-300">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="flex-1">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="bg-black px-4 py-1.5 rounded-lg text-[10px] font-black text-zinc-400 border border-zinc-800 uppercase tracking-widest">
                                    {{ \Carbon\Carbon::parse($report->activity_date)->locale('id')->translatedFormat('l, d F Y') }}
                                </div>
                                @if($report->status == 'approved')
                                    <div class="text-[10px] text-green-500 font-bold uppercase tracking-wider">Disetujui</div>
                                @else
                                    <div class="text-[10px] text-yellow-500 font-bold uppercase tracking-wider">Pending</div>
                                @endif
                                <div class="h-[1px] flex-1 bg-zinc-800"></div>
                            </div>
                            
                            <p class="text-zinc-400 leading-relaxed font-medium text-base group-hover:text-zinc-200 transition-colors">
                                {{ $report->description }}
                            </p>

                            {{-- KOTAK KOMENTAR GURU (RIWAYAT) --}}
                            @if($report->advisor_comment)
                                <div class="mt-4 bg-black/40 p-4 rounded-xl border border-zinc-800 border-l-2 border-l-red-500">
                                    <p class="text-[10px] text-zinc-500 font-black uppercase mb-1">Catatan Pembimbing:</p>
                                    <p class="text-sm text-zinc-300 italic">"{{ $report->advisor_comment }}"</p>
                                </div>
                            @else
                                <form action="{{ route('token.monitor.comment', $report->id) }}" method="POST" class="mt-4 w-full">
                                    @csrf
                                    <textarea name="advisor_comment" rows="1" required class="w-full bg-black/30 border border-zinc-700 rounded-lg p-3 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-red-500 transition-colors" placeholder="Berikan komentar untuk laporan ini..."></textarea>
                                    <button type="submit" class="mt-2 bg-zinc-800 hover:bg-red-600 text-white text-xs font-bold py-2 px-5 rounded-lg border border-zinc-700 hover:border-red-500 transition-all">
                                        Simpan & Setujui
                                    </button>
                                </form>
                            @endif

                        </div>
                        
                        @if($report->image_path)
                            <div class="w-full md:w-48 h-32 rounded-2xl overflow-hidden shrink-0 border-2 border-zinc-800 group-hover:border-zinc-600 transition-colors">
                                <a href="{{ asset('storage/'.$report->image_path) }}" target="_blank" class="block w-full h-full">
                                    <img src="{{ asset('storage/'.$report->image_path) }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 zoom-hover" alt="Dokumentasi">
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                @if(!$laporanHariIni)
                    <div class="bg-zinc-900 rounded-[2.5rem] p-20 text-center border border-zinc-800 shadow-inner">
                        <div class="w-24 h-24 bg-zinc-800 rounded-full flex items-center justify-center mx-auto mb-8 text-zinc-700">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h4 class="text-xl font-black text-white mb-2 uppercase tracking-widest">Belum Ada Aktivitas</h4>
                        <p class="text-zinc-500 font-bold">Siswa target ini belum mencatat progres harian apapun ke dalam sistem.</p>
                    </div>
                @endif
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