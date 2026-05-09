<x-guest-layout>
    <div class="max-w-xl mx-auto py-20 px-4 text-center">
        <div class="w-24 h-24 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center mx-auto mb-8 shadow-xl shadow-emerald-500/20">
            <svg class="w-12 h-12 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
        </div>
        
        <h1 class="text-4xl font-black text-slate-900 dark:text-white mb-4 tracking-tight">Pendaftaran Berhasil!</h1>
        <p class="text-lg text-slate-500 dark:text-gray-400 mb-10 font-medium">Simpan Token Anda baik-baik. Token ini digunakan untuk mengakses Logbook Harian.</p>

        <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl border-2 border-dashed border-blue-200 dark:border-gray-600 mb-10 relative group">
            <span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-blue-600 text-white text-xs font-black px-4 py-1 rounded-full tracking-widest uppercase">Token Anda</span>
            <div class="text-5xl font-black text-blue-600 dark:text-blue-400 tracking-[0.2em]">{{ $token }}</div>
        </div>

        <div class="flex flex-col gap-4">
            <a href="{{ url('/') }}" class="w-full bg-slate-900 dark:bg-white dark:text-slate-900 text-white font-bold py-4 rounded-2xl transition-all">Kembali ke Beranda</a>
            <p class="text-sm text-slate-400 dark:text-gray-500">*Token ini juga akan dicek oleh Admin sebelum magang disetujui.</p>
        </div>
    </div>
</x-guest-layout>