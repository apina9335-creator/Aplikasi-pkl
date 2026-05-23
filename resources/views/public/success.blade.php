<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Berhasil - SIPKL</title>
    
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* Pola Background Grid Kotak-Kotak Halus */
        .bg-grid-pattern {
            background-image: linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 30px 30px;
            background-position: center top;
        }
    </style>
</head>
<body class="min-h-screen font-sans text-slate-100 selection:bg-red-600 selection:text-white relative flex items-center justify-center py-10 px-4">

    {{-- DEKORASI BACKGROUND (FOTO KANTOR + OVERLAY GELAP + GRID) --}}
    <div class="fixed top-0 left-0 w-full h-full z-0">
        {{-- Foto Background --}}
        <div class="absolute inset-0 bg-[url('//gi.co.id/dist/images/intro-carousel/slide_1.jpg')] bg-cover bg-center bg-no-repeat"></div>
        
        {{-- Overlay Hitam Transparan --}}
        <div class="absolute inset-0 bg-black/80 backdrop-blur-[2px]"></div>
        
        {{-- Garis Kotak-Kotak Grid --}}
        <div class="absolute inset-0 bg-grid-pattern"></div>

        {{-- Cahaya Dekorasi Tambahan --}}
        <div class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] bg-red-900/30 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[400px] h-[400px] bg-green-900/20 rounded-full blur-[100px] pointer-events-none"></div>
    </div>

    {{-- KOTAK UTAMA (CARD) --}}
    <div class="w-full max-w-2xl bg-zinc-950/90 backdrop-blur-md rounded-[2.5rem] shadow-[0_30px_60px_rgba(0,0,0,0.5)] border border-zinc-800 relative z-10 p-8 md:p-14 text-center">
        
        {{-- Ikon Sukses --}}
        <div class="w-20 h-20 bg-green-500/10 rounded-full flex items-center justify-center mx-auto mb-6 border border-green-500/20 shadow-[0_0_40px_rgba(34,197,94,0.2)]">
            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <h2 class="text-3xl md:text-4xl font-black text-white mb-4 tracking-tighter">Pendaftaran <span class="text-green-500">Berhasil!</span></h2>
        <p class="text-zinc-400 text-sm mb-10 leading-relaxed max-w-lg mx-auto">
            Terima kasih telah mendaftar. Data dan dokumen pengajuan magang Anda telah diproses oleh tim GI untuk analisis sistem dan perancangan database.
        </p>

        {{-- AREA KODE TOKEN (DISENSOR) --}}
        <div class="bg-black/60 border border-zinc-800 rounded-3xl p-8 mb-8 relative overflow-hidden group shadow-inner">
            <div class="absolute inset-0 bg-red-600/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-3 relative z-10">KODE TOKEN AKSES ANDA</p>
            
            {{-- Menampilkan Awalan Saja, Sisanya Bintang (Sensor) --}}
            <h3 class="text-4xl md:text-5xl font-black text-white tracking-widest relative z-10 mb-4 font-mono">
                {{ substr($token, 0, 4) }}******
            </h3>
            
            <p class="text-xs font-bold text-red-500 bg-red-500/10 inline-block px-4 py-2 rounded-lg border border-red-500/20 relative z-10">
                ⚠️ Kode rahasia (Token Penuh) akan diberikan jika diterima!
            </p>
            <p class="text-[11px] text-zinc-500 mt-4 relative z-10">
                Token ini akan Anda gunakan untuk masuk ke sistem dan mengisi Logbook Harian. Harap tunggu konfirmasi dari Admin.
            </p>
        </div>

        {{-- INFO CEK EMAIL --}}
        <div class="bg-blue-950/40 border border-blue-900/50 rounded-2xl p-6 mb-10 text-left flex gap-4 items-start shadow-inner">
            <div class="w-10 h-10 shrink-0 bg-blue-600/20 rounded-full flex items-center justify-center text-blue-500 mt-1 border border-blue-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div>
                <h4 class="text-sm font-black text-blue-400 uppercase tracking-widest mb-2">Pantau Terus Email Anda!</h4>
                <p class="text-xs text-zinc-300 leading-relaxed">
                    Tim Admin kami akan segera mereview dokumen permohonan Anda. 
                    <span class="font-bold text-white">Hasil seleksi (Diterima / Ditolak) beserta instruksi selanjutnya akan diinformasikan sepenuhnya melalui Email yang Anda daftarkan.</span> 
                </p>
            </div>
        </div>

        {{-- TOMBOL KEMBALI --}}
        <a href="{{ url('/') }}" class="inline-flex items-center justify-center w-full sm:w-auto bg-zinc-800 hover:bg-zinc-700 text-white font-black py-4 px-10 rounded-xl transition-all gap-3 tracking-widest text-sm shadow-lg border border-zinc-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            KEMBALI KE BERANDA
        </a>

    </div>

</body>
</html>