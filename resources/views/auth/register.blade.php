<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun - SIPKL CORE</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen font-sans text-slate-100 selection:bg-red-600 selection:text-white relative flex items-center justify-center p-4 py-12 bg-cover bg-center bg-no-repeat bg-fixed" style="background-image: url('{{ asset('images/carousel/slide_baru_1.png') }}');">

    {{-- OVERLAY GELAP & VIGNETTE --}}
    <div class="fixed inset-0 bg-black/70 backdrop-blur-[6px] z-0 pointer-events-none"></div>
    <div class="fixed inset-0 shadow-[inset_0_0_200px_rgba(0,0,0,0.9)] z-0 pointer-events-none"></div>
    
    {{-- GLOW DECORATION MERAH (Tengah) --}}
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-red-900/40 rounded-full blur-[150px] pointer-events-none z-0 mix-blend-screen"></div>

    {{-- KOTAK REGISTER GLASSMORPHISM --}}
    <div class="w-full max-w-2xl bg-black/60 backdrop-blur-2xl border border-red-900/50 rounded-[2.5rem] p-8 md:p-10 shadow-[0_30px_60px_rgba(0,0,0,0.8)] relative z-10 ring-1 ring-white/10">
        
        {{-- HEADER LOGO --}}
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo-gi.png') }}" alt="Logo GI" class="w-16 mx-auto mb-4 drop-shadow-[0_0_20px_rgba(255,255,255,0.2)]">
            <h2 class="text-3xl font-black text-white tracking-tighter uppercase drop-shadow-md">BUAT <span class="text-red-600">AKUN</span></h2>
            <p class="text-[10px] font-bold text-zinc-400 mt-2 uppercase tracking-[0.3em]">Pendaftaran Mahasiswa / Siswa PKL</p>
        </div>

        {{-- ERROR VALIDASI --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-900/30 border border-red-500/50 p-4 rounded-xl">
                <ul class="text-xs text-red-400 font-bold space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM REGISTER --}}
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- NAMA LENGKAP --}}
                <div>
                    <label for="name" class="block text-[10px] font-black text-red-500 uppercase tracking-widest mb-2">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus 
                           class="w-full bg-black/50 border border-zinc-700/80 rounded-2xl p-3.5 text-white focus:bg-black/80 focus:ring-2 focus:ring-red-600/50 focus:border-red-500 transition-all outline-none font-bold text-sm">
                </div>

                {{-- NIM / NIS --}}
                <div>
                    <label for="nim" class="block text-[10px] font-black text-red-500 uppercase tracking-widest mb-2">NIM / NIS</label>
                    <input id="nim" type="text" name="nim" value="{{ old('nim') }}" required 
                           class="w-full bg-black/50 border border-zinc-700/80 rounded-2xl p-3.5 text-white focus:bg-black/80 focus:ring-2 focus:ring-red-600/50 focus:border-red-500 transition-all outline-none font-bold text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- ASAL SEKOLAH --}}
                <div>
                    <label for="school" class="block text-[10px] font-black text-red-500 uppercase tracking-widest mb-2">Asal Sekolah / Kampus</label>
                    <input id="school" type="text" name="school" value="{{ old('school') }}" required placeholder="Contoh: SMK N 1 Jakarta"
                           class="w-full bg-black/50 border border-zinc-700/80 rounded-2xl p-3.5 text-white focus:bg-black/80 focus:ring-2 focus:ring-red-600/50 focus:border-red-500 transition-all outline-none font-bold text-sm placeholder-zinc-600">
                </div>

                {{-- NO WHATSAPP --}}
                <div>
                    <label for="phone" class="block text-[10px] font-black text-red-500 uppercase tracking-widest mb-2">Nomor WhatsApp (Aktif)</label>
                    <input id="phone" type="number" name="phone" value="{{ old('phone') }}" required placeholder="08..."
                           class="w-full bg-black/50 border border-zinc-700/80 rounded-2xl p-3.5 text-white focus:bg-black/80 focus:ring-2 focus:ring-red-600/50 focus:border-red-500 transition-all outline-none font-bold text-sm placeholder-zinc-600">
                </div>
            </div>

            {{-- EMAIL --}}
            <div>
                <label for="email" class="block text-[10px] font-black text-red-500 uppercase tracking-widest mb-2">Email Access</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                       class="w-full bg-black/50 border border-zinc-700/80 rounded-2xl p-3.5 text-white focus:bg-black/80 focus:ring-2 focus:ring-red-600/50 focus:border-red-500 transition-all outline-none font-bold text-sm">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- PASSWORD --}}
                <div>
                    <label for="password" class="block text-[10px] font-black text-red-500 uppercase tracking-widest mb-2">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           class="w-full bg-black/50 border border-zinc-700/80 rounded-2xl p-3.5 text-white focus:bg-black/80 focus:ring-2 focus:ring-red-600/50 focus:border-red-500 transition-all outline-none font-bold text-sm">
                </div>

                {{-- KONFIRMASI PASSWORD --}}
                <div>
                    <label for="password_confirmation" class="block text-[10px] font-black text-red-500 uppercase tracking-widest mb-2">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           class="w-full bg-black/50 border border-zinc-700/80 rounded-2xl p-3.5 text-white focus:bg-black/80 focus:ring-2 focus:ring-red-600/50 focus:border-red-500 transition-all outline-none font-bold text-sm">
                </div>
            </div>

            {{-- LINK KE LOGIN & TOMBOL SUBMIT --}}
            <div class="flex items-center justify-between pt-6 mt-2 border-t border-zinc-800">
                <a href="{{ route('login') }}" class="text-[10px] font-bold text-zinc-400 hover:text-white uppercase tracking-widest transition-colors border-b border-dashed border-zinc-600 hover:border-white pb-0.5">
                    Sudah Punya Akun?
                </a>

                <button type="submit" class="bg-gradient-to-r from-red-700 to-red-600 hover:from-red-600 hover:to-red-500 text-white font-black py-3 px-8 rounded-xl shadow-[0_10px_20px_rgba(220,38,38,0.3)] transition-all transform hover:-translate-y-1 active:scale-[0.98] flex items-center justify-center gap-2 tracking-widest text-xs border border-red-500/50">
                    <span>DAFTAR SEKARANG</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </form>
    </div>
    
</body>
</html>