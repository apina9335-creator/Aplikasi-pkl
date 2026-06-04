<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SIPKL CORE</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen font-sans text-slate-100 selection:bg-red-600 selection:text-white relative flex items-center justify-center p-4 bg-cover bg-center bg-no-repeat bg-fixed" style="background-image: url('{{ asset('images/carousel/slide_baru_1.png') }}');">

    {{-- OVERLAY GELAP & VIGNETTE --}}
    <div class="fixed inset-0 bg-black/70 backdrop-blur-[6px] z-0 pointer-events-none"></div>
    <div class="fixed inset-0 shadow-[inset_0_0_200px_rgba(0,0,0,0.9)] z-0 pointer-events-none"></div>
    
    {{-- GLOW DECORATION MERAH (Tengah) --}}
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-red-900/40 rounded-full blur-[150px] pointer-events-none z-0 mix-blend-screen"></div>

    {{-- KOTAK LOGIN GLASSMORPHISM --}}
    <div class="w-full max-w-md bg-black/60 backdrop-blur-2xl border border-red-900/50 rounded-[2.5rem] p-8 md:p-10 shadow-[0_30px_60px_rgba(0,0,0,0.8)] relative z-10 ring-1 ring-white/10">
        
        {{-- HEADER LOGO --}}
        <div class="text-center mb-10">
            <img src="{{ asset('images/logo-gi.png') }}" alt="Logo GI" class="w-20 mx-auto mb-5 drop-shadow-[0_0_20px_rgba(255,255,255,0.2)]">
            <h2 class="text-3xl font-black text-white tracking-tighter uppercase drop-shadow-md">SIPKL <span class="text-red-600">CORE</span></h2>
            <p class="text-[10px] font-bold text-zinc-400 mt-2 uppercase tracking-[0.3em]">Authentication System</p>
        </div>

        {{-- STATUS SESSION (Jika ada pesan sukses reset password dsb) --}}
        @if (session('status'))
            <div class="mb-6 bg-green-900/30 border border-green-500/50 p-4 rounded-xl text-center">
                <p class="text-xs font-bold text-green-400">{{ session('status') }}</p>
            </div>
        @endif

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

        {{-- FORM LOGIN --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            {{-- INPUT EMAIL --}}
            <div>
                <label for="email" class="block text-[10px] font-black text-red-500 uppercase tracking-widest mb-2 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                    Email Access
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                       class="w-full bg-black/50 border border-zinc-700/80 rounded-2xl p-4 text-white focus:bg-black/80 focus:ring-2 focus:ring-red-600/50 focus:border-red-500 transition-all outline-none font-bold backdrop-blur-sm placeholder-zinc-600" 
                       placeholder="Masukkan email terdaftar">
            </div>

            {{-- INPUT PASSWORD --}}
            <div>
                <label for="password" class="block text-[10px] font-black text-red-500 uppercase tracking-widest mb-2 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Security Key
                </label>
                <input id="password" type="password" name="password" required autocomplete="current-password" 
                       class="w-full bg-black/50 border border-zinc-700/80 rounded-2xl p-4 text-white focus:bg-black/80 focus:ring-2 focus:ring-red-600/50 focus:border-red-500 transition-all outline-none font-bold backdrop-blur-sm placeholder-zinc-600" 
                       placeholder="••••••••">
            </div>

            {{-- REMEMBER ME & FORGOT PASSWORD --}}
            <div class="flex items-center justify-between pt-2">
                <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded bg-black border-zinc-700 text-red-600 shadow-sm focus:ring-red-500 focus:ring-offset-black">
                    <span class="ms-2 text-[10px] font-bold text-zinc-400 uppercase tracking-widest group-hover:text-white transition-colors">Ingat Saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-[10px] font-bold text-red-500 hover:text-white uppercase tracking-widest transition-colors border-b border-dashed border-red-500 hover:border-white pb-0.5">
                        Lupa Password?
                    </a>
                @endif
            </div>

            {{-- TOMBOL SUBMIT --}}
            <div class="pt-6">
                <button type="submit" class="w-full bg-gradient-to-r from-red-700 to-red-600 hover:from-red-600 hover:to-red-500 text-white font-black py-4 rounded-2xl shadow-[0_10px_30px_rgba(220,38,38,0.4)] transition-all transform hover:-translate-y-1 active:scale-[0.98] flex items-center justify-center gap-3 tracking-[0.2em] text-xs border border-red-500/50">
                    <span>LOGIN SISTEM</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </form>
    </div>
    
</body>
</html>