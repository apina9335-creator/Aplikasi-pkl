<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPKL - Sistem Informasi PKL</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="antialiased bg-slate-50 dark:bg-gray-900 min-h-screen flex flex-col transition-colors duration-300">
    
    {{-- Alert Pesan Error --}}
    @if(session('error'))
        <div class="fixed top-5 left-1/2 -translate-x-1/2 z-[100] bg-red-600 text-white px-6 py-3 rounded-full shadow-lg font-bold">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    {{-- Navbar --}}
    <nav class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                    <span class="text-white font-bold text-xl">S</span>
                </div>
                <span class="font-black text-xl tracking-tighter text-slate-800 dark:text-white">SIPKL</span>
            </div>
            <a href="{{ route('login') }}" class="text-sm font-bold text-gray-500 hover:text-blue-600 dark:text-gray-400 transition-colors">Login Admin</a>
        </div>
    </nav>

    {{-- Content --}}
    <main class="flex-grow flex items-center justify-center py-12 px-4 relative overflow-hidden">
        {{-- Animated Background Ornaments --}}
        <div class="absolute top-0 left-0 w-full h-full pointer-events-none">
            <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-400/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-indigo-400/20 rounded-full blur-3xl animate-pulse delay-1000"></div>
        </div>

        <div class="max-w-6xl mx-auto w-full relative z-10">
            <div class="text-center mb-16">
                <h1 class="text-5xl md:text-6xl font-black text-slate-900 dark:text-white mb-6 tracking-tight">
                    Magang Lebih <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-500">Mudah & Terpantau</span>
                </h1>
                <p class="text-lg text-slate-500 dark:text-gray-400 max-w-2xl mx-auto leading-relaxed font-medium">
                    Platform pendaftaran PKL otomatis tanpa ribet login. Dapatkan Token akses Anda dan mulai petualangan magang hari ini!
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                {{-- 1. Tombol Daftar PKL --}}
                <a href="{{ route('public.register') }}" class="group bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-2xl hover:shadow-blue-500/10 hover:-translate-y-2 transition-all duration-300 text-center">
                    <div class="w-16 h-16 mx-auto bg-blue-50 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-blue-600 transition-all duration-300">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Daftar PKL</h3>
                    <p class="text-sm text-slate-500 dark:text-gray-400 leading-relaxed">Mulai perjalanan PKL Anda dengan mengisi formulir singkat di sini.</p>
                </a>

                {{-- 2. Logbook Harian --}}
                <div onclick="document.getElementById('modal-token-laporan').classList.remove('hidden')" class="group bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-2xl hover:shadow-emerald-500/10 hover:-translate-y-2 transition-all duration-300 text-center cursor-pointer">
                    <div class="w-16 h-16 mx-auto bg-emerald-50 dark:bg-emerald-900/30 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-emerald-600 transition-all duration-300">
                        <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Isi Laporan</h3>
                    <p class="text-sm text-slate-500 dark:text-gray-400 leading-relaxed">Input kegiatan harian menggunakan Token rahasia yang Anda miliki.</p>
                </div>

                {{-- 3. Monitoring --}}
                <div onclick="document.getElementById('modal-token-monitor').classList.remove('hidden')" class="group bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-2xl hover:shadow-purple-500/10 hover:-translate-y-2 transition-all duration-300 text-center cursor-pointer">
                    <div class="w-16 h-16 mx-auto bg-purple-50 dark:bg-purple-900/30 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-purple-600 transition-all duration-300">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Monitoring</h3>
                    <p class="text-sm text-slate-500 dark:text-gray-400 leading-relaxed">Guru/Pembimbing memantau kegiatan siswa melalui Token unik.</p>
                </div>

                {{-- 4. Admin --}}
                <a href="{{ route('login') }}" class="group bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-2xl hover:shadow-slate-500/10 hover:-translate-y-2 transition-all duration-300 text-center">
                    <div class="w-16 h-16 mx-auto bg-slate-100 dark:bg-gray-700 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-slate-900 dark:group-hover:bg-white transition-all duration-300">
                        <svg class="w-8 h-8 text-slate-600 dark:text-slate-400 group-hover:text-white dark:group-hover:text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Admin Panel</h3>
                    <p class="text-sm text-slate-500 dark:text-gray-400 leading-relaxed">Pengelolaan data, akun, dan validasi pendaftaran sistem.</p>
                </a>

            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="py-8 text-center text-sm text-slate-400 dark:text-gray-600 font-medium">
        &copy; {{ date('Y') }} SIPKL Application. All rights reserved.
    </footer>

    {{-- MODAL TOKEN LAPORAN (Sudah Diarahkan ke Route yang Benar) --}}
    <div id="modal-token-laporan" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="this.parentElement.classList.add('hidden')"></div>
        <div class="relative flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 max-w-sm w-full shadow-2xl border border-gray-100 dark:border-gray-700">
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Akses Logbook</h3>
                <p class="text-sm text-slate-500 dark:text-gray-400 mb-6">Masukkan Token yang Anda dapatkan setelah pendaftaran.</p>
                
                {{-- Form action diubah ke route('token.logbook') --}}
                <form action="{{ route('token.logbook') }}" method="GET">
                    <input type="text" name="token" placeholder="CONTOH: PKL-XXXXXX" class="w-full px-4 py-4 rounded-2xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-center font-black tracking-widest text-xl mb-4 focus:ring-4 focus:ring-emerald-500/20 outline-none uppercase dark:text-white transition-all" required>
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-emerald-500/30 transition-all">Masuk Sekarang</button>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL TOKEN MONITORING (Sudah Diarahkan ke Route yang Benar) --}}
    <div id="modal-token-monitor" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="this.parentElement.classList.add('hidden')"></div>
        <div class="relative flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 max-w-sm w-full shadow-2xl border border-gray-100 dark:border-gray-700">
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Monitoring Siswa</h3>
                <p class="text-sm text-slate-500 dark:text-gray-400 mb-6">Gunakan Token siswa untuk memantau laporan.</p>
                
                {{-- Form action diubah ke route('token.monitor') --}}
                <form action="{{ route('token.monitor') }}" method="GET">
                    <input type="text" name="token" placeholder="CONTOH: PKL-XXXXXX" class="w-full px-4 py-4 rounded-2xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-center font-black tracking-widest text-xl mb-4 focus:ring-4 focus:ring-purple-500/20 outline-none uppercase dark:text-white transition-all" required>
                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-purple-500/30 transition-all">Pantau Siswa</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>