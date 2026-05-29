<x-app-layout>
    <div class="min-h-screen bg-zinc-950 text-slate-100 antialiased py-8 px-4 sm:px-6 lg:px-8">
        
        {{-- HEADER --}}
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="font-black text-3xl text-white leading-tight flex items-center gap-3">
                    <div class="w-12 h-12 bg-red-600 rounded-2xl flex items-center justify-center shadow-[0_0_15px_rgba(220,38,38,0.4)]">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    MONITORING <span class="text-red-600 uppercase tracking-tighter">LAPORAN</span>
                </h2>
                <p class="text-zinc-500 font-bold text-[10px] uppercase tracking-[0.2em] mt-2 ml-16">Pengecekan Logbook Harian Siswa & Mahasiswa</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto space-y-6">
            
            {{-- ALERT SUCCESS --}}
            @if(session('success'))
                <div class="bg-green-500/10 border border-green-500/30 text-green-500 px-6 py-4 rounded-2xl font-bold flex items-center gap-3 animate-pulse shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- DAFTAR LAPORAN HARIAN (MODEL KOTAK/CARD) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                
                {{-- KITA ANGGAP VARIABEL DARI CONTROLLER NAMANYA $reports --}}
                @forelse($reports as $report)
                    <div class="bg-zinc-900 border border-zinc-800 p-6 rounded-[1.5rem] shadow-2xl flex flex-col justify-between transition-all hover:border-zinc-700">
                        
                        <div>
                            {{-- HEADER CARD: NAMA & TANGGAL --}}
                            <div class="flex justify-between items-start border-b border-zinc-800 pb-4 mb-4">
                                <div>
                                    <h3 class="text-white font-black text-lg capitalize">
                                        {{-- Menyesuaikan dengan relasi tabel Kakak, misal: $report->student->name --}}
                                        {{ $report->student->name ?? 'Nama Peserta' }}
                                    </h3>
                                    <p class="text-zinc-500 font-bold text-[10px] uppercase tracking-widest mt-1">
                                        🗓️ {{ \Carbon\Carbon::parse($report->date ?? now())->translatedFormat('l, d F Y') }}
                                    </p>
                                </div>
                                
                                {{-- STATUS BADGE --}}
                                @if(strtolower($report->status ?? 'pending') == 'approved')
                                    <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-md text-[10px] font-black uppercase tracking-widest border border-green-500/30">Disetujui</span>
                                @elseif(strtolower($report->status ?? 'pending') == 'rejected')
                                    <span class="bg-red-500/20 text-red-400 px-3 py-1 rounded-md text-[10px] font-black uppercase tracking-widest border border-red-500/30">Ditolak</span>
                                @else
                                    <span class="bg-yellow-500/20 text-yellow-400 px-3 py-1 rounded-md text-[10px] font-black uppercase tracking-widest border border-yellow-500/30 animate-pulse">Pending</span>
                                @endif
                            </div>

                            {{-- ISI LAPORAN --}}
                            <div class="space-y-5">
                                
                                {{-- 1. PROGRES HARI INI --}}
                                <div>
                                    <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Progres Hari Ini:
                                    </p>
                                    <div class="text-zinc-300 text-sm bg-black/50 p-4 rounded-xl border border-zinc-800 leading-relaxed font-medium">
                                        {{-- Ganti 'activity' menjadi 'description' atau 'kegiatan' sesuai database Kakak --}}
                                        {{ $report->activity ?? $report->description ?? 'Tidak ada deskripsi.' }} 
                                    </div>
                                </div>

                                {{-- 2. FOTO BUKTI --}}
                                <div>
                                    <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Foto Bukti:
                                    </p>
                                    
                                    {{-- Ganti 'image' atau 'photo' sesuai kolom foto di database Kakak --}}
                                    @if(!empty($report->image) || !empty($report->photo)) 
                                        <div class="rounded-xl overflow-hidden border border-zinc-800 bg-black/50 inline-block group relative cursor-pointer">
                                            @php $imgSrc = $report->image ?? $report->photo; @endphp
                                            <img src="{{ asset('storage/' . $imgSrc) }}" alt="Bukti Laporan" 
                                                 class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500"
                                                 onclick="window.open(this.src, '_blank')">
                                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center pointer-events-none">
                                                <span class="text-white text-xs font-bold uppercase tracking-widest bg-black/60 px-3 py-1 rounded-md backdrop-blur-sm">Lihat Penuh</span>
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-[10px] text-red-500 font-bold uppercase tracking-widest bg-red-900/20 px-4 py-3 rounded-lg border border-red-900/50 inline-flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            Tidak ada foto bukti diunggah
                                        </p>
                                    @endif
                                </div>

                            </div>
                        </div>

                        {{-- TOMBOL AKSI --}}
                        <div class="mt-6 pt-5 border-t border-zinc-800 flex items-center justify-end gap-3">
                            
                            {{-- Jika status masih pending, tampilkan tombol setujui/tolak --}}
                            @if(strtolower($report->status ?? 'pending') == 'pending')
                                
                                {{-- Tombol Tolak (Opsional) --}}
                                <form action="{{ route('admin.reports.reject', $report->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Tolak laporan hari ini?')" class="bg-zinc-800 hover:bg-zinc-700 text-zinc-300 font-black py-3 px-5 rounded-xl text-[10px] uppercase tracking-widest transition-all">
                                        Tolak
                                    </button>
                                </form>

                                {{-- Tombol Setujui Utama --}}
                                <form action="{{ route('admin.reports.approve', $report->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-black py-3 px-6 rounded-xl text-xs uppercase tracking-widest transition-all shadow-lg shadow-red-600/30 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Simpan & Setujui
                                    </button>
                                </form>
                                
                            @else
                                <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest italic">Laporan telah diproses</p>
                            @endif
                            
                        </div>

                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-zinc-900 border border-zinc-800 p-12 rounded-[1.5rem] shadow-2xl flex flex-col items-center justify-center text-center">
                            <div class="w-20 h-20 bg-zinc-800 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h3 class="text-white font-black text-xl mb-1">Belum Ada Laporan</h3>
                            <p class="text-zinc-500 text-sm font-medium">Siswa belum mengirimkan laporan harian terbaru.</p>
                        </div>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>