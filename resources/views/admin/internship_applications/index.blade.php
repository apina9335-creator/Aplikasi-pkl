<x-app-layout>
    <div class="min-h-screen bg-zinc-950 text-slate-100 antialiased py-8 px-4 sm:px-6 lg:px-8" x-data="{ activeTab: 'all' }">
        
        {{-- HEADER UTAMA --}}
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="font-black text-3xl text-white leading-tight flex items-center gap-3">
                    <div class="w-12 h-12 bg-red-600 rounded-2xl flex items-center justify-center shadow-[0_0_15px_rgba(220,38,38,0.4)]">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    DATA <span class="text-red-600 uppercase tracking-tighter">LAMARAN</span>
                </h2>
                <p class="text-zinc-500 font-bold text-[10px] uppercase tracking-[0.2em] mt-2 ml-16">Validasi dan Review Dokumen Pengajuan PKL / Magang</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto space-y-6">
            
            {{-- ALERT SUCCESS --}}
            @if(session('success'))
                <div class="bg-green-500/10 border border-green-500/30 text-green-500 px-6 py-4 rounded-2xl font-bold flex items-center gap-3 animate-pulse shadow-lg mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- SELEKSI FILTER TAB MODERN --}}
            <div class="flex space-x-2 bg-zinc-900 p-2 rounded-[1.5rem] border border-zinc-800 shadow-2xl overflow-x-auto">
                <button @click="activeTab = 'all'" 
                        :class="activeTab === 'all' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'text-zinc-500 hover:text-white hover:bg-zinc-800'"
                        class="flex-1 py-3 px-6 rounded-xl font-black text-sm uppercase tracking-widest transition-all whitespace-nowrap flex items-center justify-center gap-2">
                    Semua Lamaran <span class="bg-black/30 px-2 py-0.5 rounded-md text-[10px]">{{ $applications->count() }}</span>
                </button>
                <button @click="activeTab = 'pending'" 
                        :class="activeTab === 'pending' ? 'bg-amber-500 text-black shadow-lg shadow-amber-500/20' : 'text-zinc-500 hover:text-white hover:bg-zinc-800'"
                        class="flex-1 py-3 px-6 rounded-xl font-black text-sm uppercase tracking-widest transition-all whitespace-nowrap flex items-center justify-center gap-2">
                    🔄 Menunggu <span class="bg-black/20 px-2 py-0.5 rounded-md text-[10px]">{{ $applications->where('status', 'pending')->count() }}</span>
                </button>
                <button @click="activeTab = 'approved'" 
                        :class="activeTab === 'approved' ? 'bg-green-600 text-white shadow-lg shadow-green-600/30' : 'text-zinc-500 hover:text-white hover:bg-zinc-800'"
                        class="flex-1 py-3 px-6 rounded-xl font-black text-sm uppercase tracking-widest transition-all whitespace-nowrap flex items-center justify-center gap-2">
                    ✅ Disetujui <span class="bg-black/30 px-2 py-0.5 rounded-md text-[10px]">{{ $applications->where('status', 'approved')->count() }}</span>
                </button>
                <button @click="activeTab = 'rejected'" 
                        :class="activeTab === 'rejected' ? 'bg-zinc-700 text-zinc-300' : 'text-zinc-500 hover:text-white hover:bg-zinc-800'"
                        class="flex-1 py-3 px-6 rounded-xl font-black text-sm uppercase tracking-widest transition-all whitespace-nowrap flex items-center justify-center gap-2">
                    ❌ Ditolak <span class="bg-black/30 px-2 py-0.5 rounded-md text-[10px]">{{ $applications->where('status', 'rejected')->count() }}</span>
                </button>
            </div>

            {{-- KOTAK MEJA TABEL --}}
            <div class="bg-zinc-900 border border-zinc-800 rounded-[2rem] overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-zinc-950/80 border-b border-zinc-800">
                                <th class="p-4 text-[10px] font-black text-zinc-500 uppercase tracking-widest w-12 text-center">No</th>
                                <th class="p-4 text-[10px] font-black text-zinc-500 uppercase tracking-widest">Informasi Pendaftar</th>
                                <th class="p-4 text-[10px] font-black text-zinc-500 uppercase tracking-widest">Asal Sekolah/Kampus</th>
                                <th class="p-4 text-[10px] font-black text-zinc-500 uppercase tracking-widest">Periode Rencana</th>
                                <th class="p-4 text-[10px] font-black text-zinc-500 uppercase tracking-widest text-center">Status</th>
                                <th class="p-4 text-[10px] font-black text-zinc-500 uppercase tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-800">
                            @forelse($applications as $app)
                                <tr class="hover:bg-zinc-800/50 transition-colors group" 
                                    x-show="activeTab === 'all' || activeTab === '{{ $app->status }}'" x-transition>
                                    
                                    {{-- 1. NOMOR URUT --}}
                                    <td class="p-4 text-center text-sm font-bold text-zinc-400">
                                        {{ $loop->iteration }}
                                    </td>
                                    
                                    {{-- 2. INFORMASI NAMA & KONTAK --}}
                                    <td class="p-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 shrink-0 bg-zinc-800 rounded-xl flex items-center justify-center font-black text-red-600 group-hover:bg-red-600/20 group-hover:text-red-500 transition-colors">
                                                {{ substr($app->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-white">{{ $app->name }}</p>
                                                <div class="flex items-center gap-2 mt-0.5">
                                                    <p class="text-[10px] text-zinc-500 font-medium">{{ $app->email }}</p>
                                                    @if($app->phone)
                                                        <span class="text-zinc-700">|</span>
                                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $app->phone) }}" target="_blank" class="inline-flex items-center gap-0.5 text-[9px] font-black text-green-500 hover:underline">
                                                            🟢 {{ $app->phone }}
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    {{-- 3. ASAL SEKOLAH --}}
                                    <td class="p-4">
                                        <div class="inline-flex items-center px-3 py-1 rounded-full bg-black/40 border border-zinc-800 text-[10px] font-bold text-zinc-300">
                                            {{ $app->school ?? 'Tidak Diketahui' }}
                                        </div>
                                        @if($app->registration_type === 'kelompok')
                                            <span class="ml-2 px-1.5 py-0.5 bg-red-600/10 text-red-500 border border-red-600/20 rounded text-[8px] font-black uppercase tracking-wider">Grup</span>
                                        @endif
                                    </td>

                                    {{-- 4. PERIODE MAGANG --}}
                                    <td class="p-4">
                                        <div class="text-xs font-bold text-zinc-300">
                                            {{ $app->start_date ? \Carbon\Carbon::parse($app->start_date)->translatedFormat('d M Y') : '-' }}
                                        </div>
                                        <div class="text-[9px] text-zinc-500 font-bold uppercase tracking-wider mt-0.5">
                                            s/d {{ $app->end_date ? \Carbon\Carbon::parse($app->end_date)->translatedFormat('d M Y') : '-' }}
                                        </div>
                                    </td>

                                    {{-- 5. STATUS BADGE --}}
                                    <td class="p-4 text-center">
                                        @if($app->status === 'pending')
                                            <span class="bg-amber-500/10 text-amber-500 border border-amber-500/20 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest">Review</span>
                                        @elseif($app->status === 'approved')
                                            <span class="bg-green-500/10 text-green-500 border border-green-500/20 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest">Lolos</span>
                                        @else
                                            <span class="bg-zinc-800 text-zinc-500 border border-zinc-700/50 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest">Gagal</span>
                                        @endif
                                    </td>

                                    {{-- 6. AKSI DETAIL & HAPUS --}}
                                    <td class="p-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            {{-- Tombol Detail --}}
                                            <a href="{{ route('admin.internship-applications.show', $app->id) }}" class="p-2 bg-zinc-800 text-zinc-400 rounded-lg hover:bg-blue-600 hover:text-white transition-colors" title="Buka Detail & Validasi">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            
                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('admin.internship-applications.destroy', $app->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus lamaran ini secara permanen? File dokumen juga akan terhapus.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 bg-zinc-800 text-zinc-400 rounded-lg hover:bg-red-600 hover:text-white transition-colors" title="Hapus Lamaran">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-16 text-center">
                                        <div class="w-16 h-16 bg-zinc-800 rounded-full flex items-center justify-center mx-auto mb-4 text-zinc-600">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        </div>
                                        <p class="text-sm font-bold text-zinc-500 uppercase tracking-widest">Belum ada berkas lamaran masuk.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>