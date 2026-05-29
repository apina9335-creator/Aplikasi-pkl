<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPKL - Monitoring Kegiatan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .zoom-hover { transition: transform 0.7s ease-in-out; }
        .zoom-hover:hover { transform: scale(1.1); }
        /* Kustomisasi scrollbar biar estetik di dark mode */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #7f1d1d; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #b91c1c; }
    </style>
</head>
<body class="min-h-screen font-sans text-slate-100 pb-20 selection:bg-red-600 selection:text-white relative bg-cover bg-center bg-no-repeat bg-fixed" style="background-image: url('{{ asset('images/carousel/slide_baru_1.png') }}');">
    
    {{-- OVERLAY GELAP & VIGNETTE (Meredupkan gambar agar konten tetap terbaca jelas) --}}
    <div class="fixed inset-0 bg-black/70 backdrop-blur-[4px] z-0 pointer-events-none"></div>
    <div class="fixed inset-0 shadow-[inset_0_0_200px_rgba(0,0,0,0.9)] z-0 pointer-events-none"></div>

    {{-- GLOW DECORATION MERAH --}}
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0 mix-blend-screen">
        <div class="absolute top-[20%] left-[-10%] w-[500px] h-[500px] bg-red-900/30 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[10%] right-[-10%] w-[400px] h-[400px] bg-red-900/20 rounded-full blur-[100px]"></div>
    </div>

    {{-- TOP BAR --}}
    <div class="bg-black/40 backdrop-blur-xl border-b border-red-900/30 sticky top-0 z-40 shadow-[0_4px_30px_rgba(220,38,38,0.1)]">
        <div class="max-w-5xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                {{-- LOGO GLOBAL INTERMEDIA --}}
                <div class="mr-2">
                    <img src="{{ asset('images/logo-gi.png') }}" alt="Logo GI" class="w-10 h-auto drop-shadow-[0_0_10px_rgba(255,255,255,0.2)]">
                </div>
                <div>
                    <span class="font-black text-xl tracking-tighter text-white block leading-none drop-shadow-md">SIPKL <span class="text-red-500">MONITORING</span></span>
                    <span class="text-[10px] text-zinc-400 font-bold uppercase tracking-[0.2em]">Guru / Dosen Version</span>
                </div>
            </div>
            <a href="{{ url('/') }}" class="group flex items-center gap-2 bg-black/50 backdrop-blur-md hover:bg-red-600 transition-all duration-300 px-5 py-2.5 rounded-xl border border-zinc-700 hover:border-red-500 shadow-[0_0_15px_rgba(0,0,0,0)] hover:shadow-[0_0_15px_rgba(220,38,38,0.4)]">
                <span class="text-xs font-black text-zinc-300 group-hover:text-white uppercase tracking-widest">Tutup</span>
                <svg class="w-4 h-4 text-zinc-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </a>
        </div>
    </div>

    <div class="max-w-5xl mx-auto pt-10 px-6 relative z-10">
        
        {{-- PESAN SUKSES --}}
        @if(session('success'))
            <div class="mb-6 bg-green-500/20 backdrop-blur-md border border-green-500/50 text-green-400 px-6 py-4 rounded-2xl text-sm font-bold flex items-center justify-center gap-3 shadow-[0_0_20px_rgba(34,197,94,0.2)]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- HEADER TARGET MONITORING (GLASSMORPHISM) --}}
        <div class="bg-black/60 backdrop-blur-xl border border-red-900/40 rounded-[2.5rem] p-8 md:p-10 shadow-[0_0_40px_rgba(220,38,38,0.1)] mb-12 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-80 h-full bg-gradient-to-l from-red-600/10 to-transparent pointer-events-none"></div>
            
            <div class="flex flex-col md:flex-row items-center gap-8 text-center md:text-left relative z-10">
                <div class="relative">
                    <div class="w-24 h-24 bg-black/80 rounded-[2rem] flex items-center justify-center text-red-500 text-4xl font-black shadow-[0_0_30px_rgba(220,38,38,0.2)] border-2 border-red-600/50 backdrop-blur-sm">
                        {{ strtoupper(substr($application->name, 0, 1)) }}
                    </div>
                </div>

                <div class="flex-1">
                    <p class="text-[10px] font-black text-red-400 uppercase tracking-[0.3em] mb-2 flex items-center justify-center md:justify-start gap-2">
                        <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(220,38,38,0.8)]"></span>
                        Target Magang
                    </p>
                    <h2 class="text-3xl md:text-4xl font-black text-white leading-tight mb-2 tracking-tight capitalize drop-shadow-md">{{ $application->name }}</h2>
                    <p class="text-sm font-bold text-zinc-300 flex items-center justify-center md:justify-start gap-2 drop-shadow-sm">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        {{ $application->school }}
                    </p>
                </div>
                
                <div class="bg-black/50 backdrop-blur-md border border-red-900/30 px-6 py-4 rounded-3xl shadow-[inset_0_0_20px_rgba(220,38,38,0.05)] text-center">
                    <p class="text-[10px] font-black text-zinc-400 uppercase tracking-[0.2em] mb-1">Total Laporan</p>
                    <p class="text-3xl font-black text-white">{{ $reports->count() }} <span class="text-sm text-red-500">Hari</span></p>
                </div>
            </div>
        </div>

        @php
            $laporanHariIni = $reports->firstWhere('activity_date', \Carbon\Carbon::today()->toDateString());
        @endphp

        {{-- HIGHLIGHT: PROGRES HARI INI --}}
        @if($laporanHariIni)
            <div class="mb-16 bg-gradient-to-br from-red-900/50 to-black/80 backdrop-blur-xl border-2 border-red-600/50 rounded-[2.5rem] p-1 shadow-[0_0_60px_rgba(220,38,38,0.3)] relative overflow-hidden">
                <div class="absolute top-0 right-8 bg-red-600 text-white text-xs font-black uppercase px-6 py-2 rounded-b-xl tracking-widest z-20 shadow-[0_5px_20px_rgba(220,38,38,0.5)]">
                    🔥 Progres Terkini
                </div>
                
                <div class="bg-black/60 rounded-[2.3rem] p-8 md:p-10 flex flex-col md:flex-row gap-8 relative z-10 shadow-[inset_0_0_40px_rgba(220,38,38,0.05)]">
                    <div class="flex-1">
                        <p class="text-red-400 font-bold mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ \Carbon\Carbon::parse($laporanHariIni->activity_date)->locale('id')->translatedFormat('l, d F Y') }}
                        </p>
                        
                        <div class="mb-6">
                            <p class="text-[10px] font-black text-red-500 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Progres Kegiatan:
                            </p>
                            <h3 class="text-2xl md:text-3xl font-black text-white leading-relaxed bg-black/50 p-4 rounded-xl border border-red-900/30 shadow-[inset_0_0_20px_rgba(220,38,38,0.05)] drop-shadow-md">{{ $laporanHariIni->description }}</h3>
                        </div>
                        
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-black/60 border border-red-900/30 backdrop-blur-sm">
                            @if($laporanHariIni->status == 'approved')
                                <div class="w-2 h-2 bg-green-400 rounded-full shadow-[0_0_8px_rgba(74,222,128,0.8)]"></div>
                                <span class="text-xs font-black text-green-400 uppercase tracking-widest">Disetujui Pembimbing</span>
                            @else
                                <div class="w-2 h-2 bg-yellow-400 rounded-full shadow-[0_0_8px_rgba(250,204,21,0.8)] animate-pulse"></div>
                                <span class="text-xs font-black text-yellow-400 uppercase tracking-widest">Menunggu Pemeriksaan</span>
                            @endif
                        </div>

                        {{-- KOTAK KOMENTAR GURU --}}
                        @if($laporanHariIni->advisor_comment)
                            <div class="mt-6 bg-black/50 backdrop-blur-md p-5 rounded-2xl border border-red-900/30 border-l-4 border-l-red-500 shadow-[inset_0_0_15px_rgba(220,38,38,0.05)]">
                                <p class="text-[10px] text-zinc-400 font-black uppercase mb-1">Catatan Pembimbing:</p>
                                <p class="text-sm text-zinc-200 italic drop-shadow-sm">"{{ $laporanHariIni->advisor_comment }}"</p>
                            </div>
                        @else
                            <form action="{{ route('token.monitor.comment', $laporanHariIni->id) }}" method="POST" class="mt-6 w-full">
                                @csrf
                                <textarea name="advisor_comment" rows="2" required class="w-full bg-black/60 backdrop-blur-sm border border-zinc-700/80 rounded-xl p-4 text-sm text-white placeholder-zinc-500 focus:outline-none focus:border-red-500 focus:shadow-[0_0_20px_rgba(220,38,38,0.3)] transition-all" placeholder="Ketik catatan atau evaluasi untuk siswa di sini..."></textarea>
                                <button type="submit" class="mt-3 bg-gradient-to-r from-red-700 to-red-600 hover:from-red-600 hover:to-red-500 text-white text-xs font-bold py-2.5 px-6 rounded-lg transition-all shadow-[0_0_15px_rgba(220,38,38,0.4)] border border-red-500/50 hover:-translate-y-0.5">
                                    Simpan Komentar & Setujui
                                </button>
                            </form>
                        @endif

                    </div>

                    <div class="flex flex-col gap-2 shrink-0">
                        <p class="text-[10px] font-black text-red-500 uppercase tracking-widest flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Foto Bukti:
                        </p>
                        @if($laporanHariIni->image_path)
                            <div class="w-full md:w-80 h-56 rounded-3xl overflow-hidden border-4 border-red-900/40 shadow-[0_0_30px_rgba(220,38,38,0.2)] relative bg-black/50 backdrop-blur-sm">
                                <a href="{{ asset('storage/'.$laporanHariIni->image_path) }}" target="_blank" class="block w-full h-full overflow-hidden">
                                    <img src="{{ asset('storage/'.$laporanHariIni->image_path) }}" class="w-full h-full object-cover zoom-hover opacity-90 hover:opacity-100 transition-opacity" alt="Foto Progres">
                                </a>
                            </div>
                        @else
                            <div class="w-full md:w-80 h-56 rounded-3xl bg-black/60 backdrop-blur-sm border-2 border-dashed border-red-900/50 flex flex-col items-center justify-center text-zinc-400">
                                <svg class="w-12 h-12 mb-2 text-red-900/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-sm font-bold">Tidak ada foto dilampirkan</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        {{-- DAFTAR LAPORAN (TIMELINE LENGKAP - GLASSMORPHISM) --}}
        <div class="space-y-8">
            <div class="flex items-center gap-4 px-4">
                <div class="h-[1px] flex-1 bg-gradient-to-r from-transparent via-red-900/50 to-transparent"></div>
                <h3 class="text-lg font-black text-red-500/90 uppercase tracking-[0.2em] drop-shadow-md">Riwayat Laporan Sebelumnya</h3>
                <div class="h-[1px] flex-1 bg-gradient-to-r from-transparent via-red-900/50 to-transparent"></div>
            </div>

            @forelse($reports as $report)
                @if($laporanHariIni && $report->id === $laporanHariIni->id)
                    @continue 
                @endif

                <div class="bg-black/60 backdrop-blur-xl border border-red-900/40 shadow-[0_0_20px_rgba(220,38,38,0.1)] rounded-[2rem] p-6 md:p-8 relative overflow-hidden">
                    <div class="absolute left-0 top-0 w-1.5 h-full bg-gradient-to-b from-red-600 to-transparent opacity-80"></div>
                    
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="flex-1">
                            
                            {{-- HEADER TANGGAL & STATUS --}}
                            <div class="flex items-center gap-4 mb-4">
                                <div class="bg-red-900/20 px-4 py-1.5 rounded-lg text-[10px] font-black text-red-400 border border-red-900/30 uppercase tracking-widest backdrop-blur-sm">
                                    {{ \Carbon\Carbon::parse($report->activity_date)->locale('id')->translatedFormat('l, d F Y') }}
                                </div>
                                
                                @if($report->status == 'approved')
                                    <div class="flex items-center gap-1.5 text-[10px] text-green-400 font-bold uppercase tracking-wider bg-green-500/10 px-3 py-1.5 rounded-lg border border-green-500/20 backdrop-blur-sm">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        Disetujui
                                    </div>
                                @elseif($report->status == 'rejected')
                                    <div class="flex items-center gap-1.5 text-[10px] text-red-400 font-bold uppercase tracking-wider bg-red-500/10 px-3 py-1.5 rounded-lg border border-red-500/20 backdrop-blur-sm">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Ditolak
                                    </div>
                                @else
                                    <div class="flex items-center gap-1.5 text-[10px] text-yellow-400 font-bold uppercase tracking-wider bg-yellow-500/10 px-3 py-1.5 rounded-lg border border-yellow-500/20 animate-pulse backdrop-blur-sm">
                                        <div class="w-2 h-2 bg-yellow-400 rounded-full"></div>
                                        Pending
                                    </div>
                                @endif
                                <div class="h-[1px] flex-1 bg-red-900/30"></div>
                            </div>
                            
                            {{-- ISI LAPORAN --}}
                            <p class="text-[10px] font-black text-red-400 uppercase tracking-widest mb-1">Progres:</p>
                            <p class="text-zinc-200 leading-relaxed font-medium text-base mb-4 drop-shadow-sm">
                                {{ $report->description }}
                            </p>

                            {{-- KOMENTAR PEMBIMBING --}}
                            @if($report->advisor_comment)
                                <div class="mt-4 bg-black/50 backdrop-blur-md p-4 rounded-xl border border-red-900/30 border-l-2 border-l-red-500 shadow-[inset_0_0_10px_rgba(220,38,38,0.05)]">
                                    <p class="text-[10px] text-zinc-400 font-black uppercase mb-1 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                        Catatan Pembimbing:
                                    </p>
                                    <p class="text-sm text-white italic">"{{ $report->advisor_comment }}"</p>
                                </div>
                            @else
                                <form action="{{ route('token.monitor.comment', $report->id) }}" method="POST" class="mt-4 w-full">
                                    @csrf
                                    <textarea name="advisor_comment" rows="1" required class="w-full bg-black/60 backdrop-blur-sm border border-zinc-700/80 rounded-lg p-3 text-sm text-white placeholder-zinc-500 focus:outline-none focus:border-red-500 focus:shadow-[0_0_20px_rgba(220,38,38,0.2)] transition-all" placeholder="Berikan komentar untuk laporan ini..."></textarea>
                                    <button type="submit" class="mt-2 bg-gradient-to-r from-red-800 to-red-700 hover:from-red-700 hover:to-red-600 text-white text-xs font-bold py-2 px-5 rounded-lg border border-red-500/50 transition-all hover:shadow-[0_0_15px_rgba(220,38,38,0.4)]">
                                        Simpan & Setujui
                                    </button>
                                </form>
                            @endif

                        </div>
                        
                        {{-- FOTO BUKTI --}}
                        <div class="flex flex-col gap-2 shrink-0">
                            @if($report->image_path)
                                <p class="text-[10px] font-black text-red-400 uppercase tracking-widest">Foto Dokumentasi:</p>
                                <div class="w-full md:w-48 h-32 rounded-2xl overflow-hidden border-2 border-red-900/40 shadow-[0_0_15px_rgba(220,38,38,0.1)] bg-black/50 backdrop-blur-sm">
                                    <a href="{{ asset('storage/'.$report->image_path) }}" target="_blank" class="block w-full h-full overflow-hidden">
                                        <img src="{{ asset('storage/'.$report->image_path) }}" class="w-full h-full object-cover zoom-hover opacity-90 hover:opacity-100 transition-opacity" alt="Dokumentasi">
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                @if(!$laporanHariIni)
                    <div class="bg-black/60 backdrop-blur-xl rounded-[2.5rem] p-20 text-center border border-zinc-800 shadow-inner">
                        <div class="w-24 h-24 bg-zinc-800/80 rounded-full flex items-center justify-center mx-auto mb-8 text-zinc-500 shadow-[inset_0_0_20px_rgba(0,0,0,0.5)]">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <h4 class="text-xl font-black text-white mb-2 uppercase tracking-widest">Belum Ada Aktivitas</h4>
                        <p class="text-zinc-400 font-bold">Siswa target ini belum mencatat progres harian apapun ke dalam sistem.</p>
                    </div>
                @endif
            @endforelse
        </div>
        
    </div>

    {{-- Footer --}}
    <footer class="mt-20 py-10 border-t border-zinc-800/50 text-center relative z-10 bg-black/20 backdrop-blur-sm">
        <div class="inline-flex items-center gap-4 px-6 py-2 bg-black/60 border border-zinc-700/50 rounded-full shadow-[0_0_20px_rgba(220,38,38,0.1)]">
            <span class="text-[10px] font-black text-zinc-400 uppercase tracking-[0.4em]">Sistem Monitoring Dosen &bull; SIPKL</span>
            <div class="w-2 h-2 bg-red-500 rounded-full shadow-[0_0_10px_rgba(220,38,38,0.8)] animate-pulse"></div>
        </div>
    </footer>

</body>
</html>