<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPKL - Logbook Harian</title>
    {{-- JALAN PINTAS: Memanggil Tailwind CSS langsung dari server internet --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-black text-slate-100 pb-20 selection:bg-red-600 selection:text-white font-sans antialiased">
    
    {{-- GLOW DECORATION --}}
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
        <div class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] bg-red-900/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[400px] h-[400px] bg-red-900/10 rounded-full blur-[100px]"></div>
    </div>

    {{-- TOP BAR --}}
    <div class="bg-zinc-900/80 backdrop-blur-md border-b border-zinc-800 sticky top-0 z-50 shadow-2xl">
        <div class="max-w-6xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center shadow-[0_0_20px_rgba(220,38,38,0.5)]">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div>
                    <span class="font-black text-xl tracking-tighter text-white block leading-none">SIPKL <span class="text-red-600">LOGBOOK</span></span>
                    <span class="text-[10px] text-zinc-500 font-bold uppercase tracking-[0.2em]">Siswa Version 2.0</span>
                </div>
            </div>
            <a href="{{ url('/') }}" class="group flex items-center gap-2 bg-zinc-800 hover:bg-red-600 transition-all duration-300 px-5 py-2.5 rounded-xl border border-zinc-700 hover:border-red-500 shadow-lg">
                <span class="text-xs font-black text-zinc-400 group-hover:text-white uppercase tracking-widest">Logout</span>
                <svg class="w-4 h-4 text-zinc-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            </a>
        </div>
    </div>

    <div class="max-w-6xl mx-auto pt-10 px-6 relative z-10">
        
        {{-- HEADER PROFIL --}}
        <div class="bg-zinc-900 border border-zinc-800 rounded-[2.5rem] p-8 md:p-10 shadow-2xl mb-10 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-80 h-full bg-gradient-to-l from-red-600/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
            
            <div class="flex flex-col md:flex-row items-center gap-10">
                <div class="relative">
                    <div class="w-28 h-28 bg-zinc-800 rounded-[2rem] flex items-center justify-center text-red-600 text-5xl font-black shadow-2xl border-2 border-zinc-700 group-hover:border-red-600 transition-colors duration-500">
                        {{ substr($application->name, 0, 1) }}
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 border-4 border-zinc-900 rounded-full animate-pulse"></div>
                </div>

                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-3xl md:text-4xl font-black text-white leading-tight mb-2 tracking-tight">{{ $application->name }}</h2>
                    <div class="flex flex-wrap justify-center md:justify-start gap-4 items-center">
                        <span class="flex items-center gap-2 text-sm font-bold text-zinc-400">
                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0z"/></svg>
                            {{ $application->school }}
                        </span>
                        <span class="h-4 w-[2px] bg-zinc-800 hidden md:block"></span>
                        <span class="bg-red-600/10 text-red-500 px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border border-red-600/20 shadow-[0_0_15px_rgba(220,38,38,0.1)]">Internship Active</span>
                    </div>
                </div>

                <div class="bg-black/50 border border-zinc-800 p-6 rounded-3xl text-center shadow-inner min-w-[200px]">
                    <p class="text-[10px] text-zinc-500 font-black uppercase tracking-[0.3em] mb-2">Private Token</p>
                    <p class="font-mono font-black text-2xl text-red-600 tracking-[0.2em]">{{ $token }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            {{-- KOLOM INPUT (KIRI) --}}
            <div class="lg:col-span-5">
                <div class="bg-zinc-900 border border-zinc-800 rounded-[2.5rem] p-8 shadow-2xl sticky top-28">
                    <div class="flex items-center gap-4 mb-10">
                        <div class="w-12 h-12 bg-red-600/10 text-red-600 rounded-2xl flex items-center justify-center font-bold text-xl border border-red-600/20">🚀</div>
                        <h3 class="text-2xl font-black text-white tracking-tight">Update Laporan</h3>
                    </div>

                    @if(session('success'))
                        <div class="mb-8 p-5 bg-green-500/10 border border-green-500/30 text-green-500 rounded-2xl text-sm font-bold flex items-center gap-3 animate-pulse">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('token.logbook.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        
                        <div>
                            <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-3">Tanggal Kegiatan</label>
                            <input type="date" name="activity_date" value="{{ date('Y-m-d') }}" class="w-full bg-black border border-zinc-800 rounded-2xl p-4 text-white focus:border-red-600 focus:ring-4 focus:ring-red-600/10 transition-all font-bold outline-none">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-3">Apa progresmu hari ini?</label>
                            <textarea name="description" rows="5" class="w-full bg-black border border-zinc-800 rounded-2xl p-5 text-white focus:border-red-600 focus:ring-4 focus:ring-red-600/10 transition-all text-sm leading-relaxed outline-none" placeholder="Tuliskan detail pekerjaan atau kendala yang kamu hadapi..." required></textarea>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-3">Upload Dokumentasi</label>
                            <div class="bg-black border-2 border-dashed border-zinc-800 rounded-2xl p-6 text-center hover:border-red-600/50 transition-colors">
                                <input type="file" name="photo" accept="image/*" class="w-full text-xs text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-zinc-800 file:text-zinc-400 hover:file:bg-red-600 hover:file:text-white transition-all cursor-pointer">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-5 rounded-2xl shadow-[0_10px_30px_rgba(220,38,38,0.3)] transition-all transform active:scale-[0.98] flex items-center justify-center gap-3 text-sm tracking-widest">
                            <span>SUBMIT PROGRES</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </form>
                </div>
            </div>

            {{-- KOLOM RIWAYAT (KANAN) --}}
            <div class="lg:col-span-7 space-y-8">
                <div class="flex items-end justify-between px-2">
                    <div>
                        <h3 class="text-3xl font-black text-white tracking-tight">Timeline Kegiatan</h3>
                        <p class="text-zinc-500 text-xs font-bold mt-1 uppercase tracking-widest">Rekaman progres harian kamu</p>
                    </div>
                    <span class="bg-zinc-900 border border-zinc-800 text-red-500 px-4 py-2 rounded-2xl text-[10px] font-black shadow-lg">{{ $reports->count() }} ENTRIES</span>
                </div>
                
                @forelse($reports as $report)
                    <div class="group bg-zinc-900 border border-zinc-800 rounded-[2.5rem] p-8 hover:border-red-600/50 hover:shadow-[0_20px_50px_rgba(0,0,0,0.5)] transition-all duration-500">
                        <div class="flex flex-col md:flex-row gap-8">
                            <div class="flex-1">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="bg-black px-5 py-2 rounded-xl text-[10px] font-black text-red-500 border border-zinc-800 uppercase tracking-[0.2em]">
                                        {{ \Carbon\Carbon::parse($report->activity_date)->translatedFormat('d F Y') }}
                                    </div>
                                    
                                    <div class="h-[2px] flex-1 bg-zinc-800"></div>

                                    @if($report->status == 'approved')
                                        <span class="flex items-center gap-1.5 text-[10px] font-black text-green-500 uppercase tracking-widest">
                                            <div class="w-2 h-2 bg-green-500 rounded-full"></div> Approved
                                        </span>
                                    @else
                                        <span class="flex items-center gap-1.5 text-[10px] font-black text-zinc-500 uppercase tracking-widest">
                                            <div class="w-2 h-2 bg-zinc-700 rounded-full"></div> Process
                                        </span>
                                    @endif
                                </div>
                                
                                <p class="text-zinc-300 leading-relaxed font-bold text-lg md:text-xl group-hover:text-white transition-colors">
                                    {{ $report->description }}
                                </p>
                            </div>
                            
                            @if($report->image_path)
                                <div class="w-full md:w-52 h-40 rounded-3xl overflow-hidden shrink-0 border-4 border-black shadow-2xl group-hover:border-red-600/30 transition-all duration-500">
                                    <img src="{{ asset('storage/'.$report->image_path) }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 scale-105 group-hover:scale-110 transition-all duration-700" alt="Activity documentation">
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-zinc-900 rounded-[2.5rem] p-20 text-center border border-zinc-800 shadow-inner">
                        <div class="w-24 h-24 bg-zinc-800 rounded-full flex items-center justify-center mx-auto mb-8 text-zinc-700">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="text-xl font-black text-white mb-2 uppercase tracking-widest">Database Kosong</h4>
                        <p class="text-zinc-500 font-bold">Belum ada aktivitas yang tercatat di timeline kamu.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    {{-- Footer --}}
    <footer class="mt-20 py-10 border-t border-zinc-900 text-center relative z-10">
        <div class="inline-flex items-center gap-4 px-6 py-2 bg-zinc-900 border border-zinc-800 rounded-full">
            <span class="text-[10px] font-black text-zinc-600 uppercase tracking-[0.4em]">Aplikasi Laporan PKL Harian &bull; Google Core System</span>
            <div class="w-2 h-2 bg-red-600 rounded-full shadow-[0_0_10px_rgba(220,38,38,0.5)]"></div>
        </div>
    </footer>

</body>
</html>