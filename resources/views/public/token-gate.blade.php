<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akses Token - SIPKL CORE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Animasi getar ringan saat ada error */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
        }
        .animate-shake { animation: shake 0.4s ease-in-out; }
    </style>
</head>
<body class="min-h-screen font-sans text-slate-100 relative flex items-center justify-center p-4 bg-black bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-red-900/20 via-black to-black">

    {{-- EFEK GLOWING ANIMASI DI BELAKANG --}}
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] bg-red-600/20 rounded-full blur-[120px] pointer-events-none z-0 animate-pulse"></div>

    {{-- KOTAK LOGIN TOKEN --}}
    <div class="w-full max-w-md bg-zinc-950/80 backdrop-blur-2xl border border-red-600/50 rounded-[2.5rem] p-8 md:p-12 shadow-[0_30px_60px_rgba(220,38,38,0.15)] relative z-10 text-center ring-1 ring-white/5">
        
        {{-- IKON GEMBOK --}}
        <div class="w-20 h-20 bg-black border-2 border-red-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-[0_0_20px_rgba(220,38,38,0.4)]">
            <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
        </div>

        <h2 class="text-3xl font-black text-white tracking-tighter uppercase mb-2">VALIDASI <span class="text-red-600">TOKEN</span></h2>
        
        {{-- Teks berubah tergantung dia mau ke Logbook atau Monitoring --}}
        <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-[0.2em] mb-8 leading-relaxed">
            Masukkan Token untuk akses <br> 
            <span class="text-white">{{ isset($jenis_akses) && $jenis_akses == 'logbook' ? 'Laporan Harian' : 'Monitoring Siswa' }}</span>
        </p>

        {{-- PESAN ERROR JIKA TOKEN SALAH --}}
        @if (session('error'))
            <div class="mb-6 bg-red-950/50 border border-red-500/50 p-4 rounded-2xl animate-shake">
                <p class="text-xs text-red-400 font-bold flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('error') }}
                </p>
            </div>
        @endif

        {{-- FORM INPUT TOKEN (SUDAH MENGGUNAKAN GET & ROUTE DINAMIS) --}}
        <form method="GET" action="{{ isset($jenis_akses) && $jenis_akses == 'logbook' ? route('token.logbook') : route('token.monitor') }}" class="space-y-6">
            <div>
                <input id="token" type="text" name="token" required autofocus autocomplete="off"
                       class="w-full bg-black border-2 border-zinc-800 rounded-2xl p-5 text-center text-2xl text-white focus:bg-zinc-900 focus:border-red-600 focus:ring-4 focus:ring-red-600/20 transition-all outline-none font-mono font-black tracking-[0.3em] uppercase placeholder-zinc-700" 
                       placeholder="PKL-XXXXXX">
            </div>

            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-4 rounded-xl shadow-[0_0_20px_rgba(220,38,38,0.4)] transition-all transform hover:-translate-y-1 active:scale-[0.98] flex items-center justify-center gap-3 tracking-widest text-sm border border-red-500">
                BUKA AKSES
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </form>

        {{-- KEMBALI KE WEB UTAMA --}}
        <div class="mt-8 pt-6 border-t border-zinc-800">
            <a href="{{ url('/') }}" class="text-[10px] font-bold text-zinc-500 hover:text-white uppercase tracking-widest transition-colors flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Portal Utama
            </a>
        </div>
    </div>
    
</body>
</html>