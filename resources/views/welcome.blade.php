<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPKL CORE - Portal Laporan PKL</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,700,900&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body { font-family: 'Figtree', sans-serif; }
        
        /* Background putih ramai dengan pola jaring halus */
        .bg-grid-light {
            background-size: 40px 40px;
            background-image: linear-gradient(to right, rgba(0, 0, 0, 0.05) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(0, 0, 0, 0.05) 1px, transparent 1px);
        }
        
        /* Kustomisasi scrollbar untuk taskbar kiri */
        .taskbar-scroll::-webkit-scrollbar { width: 5px; }
        .taskbar-scroll::-webkit-scrollbar-track { background: transparent; }
        .taskbar-scroll::-webkit-scrollbar-thumb { background: #7f1d1d; border-radius: 10px; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-red-600 selection:text-white bg-grid-light flex flex-col lg:flex-row min-h-screen">

    {{-- ========================================== --}}
    {{-- TASKBAR KIRI (SIDEBAR MENU AKSES) --}}
    {{-- ========================================== --}}
    <aside class="w-full lg:w-[24rem] lg:fixed lg:h-screen bg-black lg:border-r-4 border-b-4 lg:border-b-0 border-red-600 shadow-[0_10px_30px_rgba(220,38,38,0.4)] lg:shadow-[10px_0_30px_rgba(220,38,38,0.3)] z-50 flex flex-col justify-between relative overflow-hidden taskbar-scroll overflow-y-auto shrink-0">
        
        {{-- Efek Glow di dalam taskbar --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-red-900/20 rounded-full blur-[80px] pointer-events-none"></div>

        <div class="p-6 md:p-8 relative z-10">
            
            {{-- LOGO & BRANDING --}}
            <div class="flex items-center gap-4 mb-10 pb-6 border-b border-red-900/30">
                <img src="{{ asset('images/logo-gi.png') }}" alt="Logo GI" class="w-14 drop-shadow-[0_0_15px_rgba(220,38,38,0.5)]">
                <div>
                    <h1 class="text-3xl font-black text-white tracking-tighter leading-none mb-1">SIPKL <span class="text-red-600">CORE</span></h1>
                    <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest">Portal Akses Sistem</span>
                </div>
            </div>

            <h2 class="text-xs font-black text-red-500 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(220,38,38,0.8)]"></span>
                MENU UTAMA
            </h2>

            {{-- DAFTAR MENU (Tersusun ke bawah) --}}
            <div class="flex flex-col gap-4">
                
                {{-- MENU 1: DAFTAR PKL --}}
                <a href="{{ url('/daftar-pkl') }}" class="group flex items-start gap-4 p-5 rounded-2xl bg-zinc-900/40 border border-zinc-800 hover:border-red-500 hover:bg-red-950/30 transition-all duration-300">
                    <div class="w-12 h-12 shrink-0 bg-black border border-zinc-700 group-hover:border-red-500 rounded-xl flex items-center justify-center text-zinc-400 group-hover:text-red-500 transition-all shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-white uppercase tracking-widest mb-1 group-hover:text-red-400 transition-colors">Daftar PKL</h3>
                        <p class="text-[10px] text-zinc-400 font-medium leading-relaxed">Isi formulir pendaftaran siswa baru untuk mengajukan magang.</p>
                    </div>
                </a>

                {{-- MENU 2: ISI LAPORAN HARIAN --}}
                <a href="{{ url('/akses-logbook') }}" class="group flex items-start gap-4 p-5 rounded-2xl bg-zinc-900/40 border border-zinc-800 hover:border-red-500 hover:bg-red-950/30 transition-all duration-300">
                    <div class="w-12 h-12 shrink-0 bg-black border border-zinc-700 group-hover:border-red-500 rounded-xl flex items-center justify-center text-zinc-400 group-hover:text-red-500 transition-all shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-white uppercase tracking-widest mb-1 group-hover:text-red-400 transition-colors">Isi Laporan</h3>
                        <p class="text-[10px] text-zinc-400 font-medium leading-relaxed">Wajib masukkan Token Rahasia dari WA untuk mengisi kegiatan.</p>
                    </div>
                </a>

                {{-- MENU 3: MONITORING DOSEN --}}
                <a href="{{ url('/monitoring-siswa') }}" class="group flex items-start gap-4 p-5 rounded-2xl bg-zinc-900/40 border border-zinc-800 hover:border-red-500 hover:bg-red-950/30 transition-all duration-300">
                    <div class="w-12 h-12 shrink-0 bg-black border border-zinc-700 group-hover:border-red-500 rounded-xl flex items-center justify-center text-zinc-400 group-hover:text-red-500 transition-all shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-white uppercase tracking-widest mb-1 group-hover:text-red-400 transition-colors">Monitoring</h3>
                        <p class="text-[10px] text-zinc-400 font-medium leading-relaxed">Akses tinjauan cepat bagi Guru / Dosen pembimbing lapangan.</p>
                    </div>
                </a>

                {{-- MENU 4: LOGIN ADMIN --}}
                <a href="{{ route('login') }}" class="group flex items-start gap-4 p-5 rounded-2xl bg-zinc-900/40 border border-zinc-800 hover:border-red-500 hover:bg-red-950/30 transition-all duration-300 mt-4 border-t border-t-red-900/30 pt-6">
                    <div class="w-12 h-12 shrink-0 bg-black border border-zinc-700 group-hover:border-red-500 rounded-xl flex items-center justify-center text-zinc-400 group-hover:text-red-500 transition-all shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-white uppercase tracking-widest mb-1 group-hover:text-red-400 transition-colors">Login Admin</h3>
                        <p class="text-[10px] text-zinc-400 font-medium leading-relaxed">Akses kontrol penuh pengelola sistem (Command Center).</p>
                    </div>
                </a>

            </div>
        </div>

        <div class="p-6 relative z-10 hidden lg:block">
            <p class="text-zinc-600 font-bold text-[10px] uppercase tracking-[0.2em] text-center">
                &copy; {{ date('Y') }} SIPKL CORE SYSTEM
            </p>
        </div>
    </aside>

    {{-- ========================================== --}}
    {{-- KONTEN UTAMA (SISI KANAN) --}}
    {{-- ========================================== --}}
    <main class="flex-1 lg:ml-[24rem] min-h-screen relative p-6 md:p-12 lg:p-16 flex flex-col justify-center overflow-hidden">
        
        {{-- EFEK GLOW KANAN --}}
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-red-900/10 rounded-full blur-[150px] pointer-events-none z-0"></div>

        {{-- HERO SECTION --}}
        <div class="bg-black border border-red-600 rounded-[3rem] p-10 md:p-16 shadow-[0_20px_60px_rgba(220,38,38,0.4)] relative overflow-hidden mb-12 z-10">
            <div class="absolute inset-0 bg-gradient-to-br from-red-900/20 to-transparent pointer-events-none"></div>

            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-red-500/50 bg-red-900/30 text-red-400 text-xs font-black uppercase tracking-widest mb-6">
                    <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                    Sistem Laporan PKL Harian
                </div>
                
                <h2 class="text-5xl md:text-6xl font-black text-white tracking-tighter mb-4 leading-tight">
                    SELAMAT DATANG <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-red-600 drop-shadow-[0_0_20px_rgba(220,38,38,0.6)]">DI PORTAL UTAMA</span>
                </h2>
                
                <p class="mt-4 text-base md:text-lg text-zinc-400 max-w-2xl font-medium mb-0 leading-relaxed">
                    Platform digital resmi untuk pendaftaran, monitoring, dan pengisian laporan harian. 
                    <span class="text-white font-bold block mt-2">👉 Silakan gunakan Menu Utama di panel sebelah kiri untuk mengakses layanan sistem.</span>
                </p>
            </div>
        </div>

        {{-- ALUR JALUR TOKEN SECTION --}}
        <div class="relative z-10 bg-white/80 backdrop-blur-xl border border-zinc-200 p-8 md:p-12 rounded-[3rem] shadow-xl">
            <div class="mb-10">
                <h3 class="text-2xl font-black text-slate-900 tracking-tighter uppercase border-l-4 border-red-600 pl-4">
                    ALUR JALUR <span class="text-red-600">TOKEN WA</span>
                </h3>
                <p class="mt-2 text-gray-500 font-bold uppercase tracking-widest text-[10px] pl-5">Proses pengisian Logbook tanpa ribet bikin akun</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                {{-- Step 1 --}}
                <div class="bg-slate-50 border border-zinc-200 p-6 rounded-3xl relative group hover:border-red-300 transition-colors shadow-sm hover:shadow-md">
                    <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center font-black text-lg text-white absolute -top-5 left-6 shadow-lg shadow-red-600/30">1</div>
                    <div class="mt-3">
                        <h4 class="text-base font-black text-slate-800 uppercase tracking-wider mb-2">Daftar</h4>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed">Isi formulir pendaftaran & upload berkas lewat web ini.</p>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="bg-slate-50 border border-zinc-200 p-6 rounded-3xl relative group hover:border-red-300 transition-colors shadow-sm hover:shadow-md">
                    <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center font-black text-lg text-white absolute -top-5 left-6 shadow-lg shadow-red-600/30">2</div>
                    <div class="mt-3">
                        <h4 class="text-base font-black text-slate-800 uppercase tracking-wider mb-2">Validasi</h4>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed">Admin memeriksa berkas Anda di halaman Command Center.</p>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="bg-slate-50 border border-zinc-200 p-6 rounded-3xl relative group hover:border-red-300 transition-colors shadow-sm hover:shadow-md">
                    <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center font-black text-lg text-white absolute -top-5 left-6 shadow-lg shadow-red-600/30">3</div>
                    <div class="mt-3">
                        <h4 class="text-base font-black text-slate-800 uppercase tracking-wider mb-2">Terima Token</h4>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed">Nomor sistem otomatis menembak Token baru ke WA Anda.</p>
                    </div>
                </div>

                {{-- Step 4 --}}
                <div class="bg-slate-50 border border-zinc-200 p-6 rounded-3xl relative group hover:border-red-300 transition-colors shadow-sm hover:shadow-md">
                    <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center font-black text-lg text-white absolute -top-5 left-6 shadow-lg shadow-red-600/30">4</div>
                    <div class="mt-3">
                        <h4 class="text-base font-black text-slate-800 uppercase tracking-wider mb-2">Isi Logbook</h4>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed">Masuk ke menu 'Isi Laporan' pakai token tersebut.</p>
                    </div>
                </div>
            </div>
        </div>
        
    </main>

</body>
</html>