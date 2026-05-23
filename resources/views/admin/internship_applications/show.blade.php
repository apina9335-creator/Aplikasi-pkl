<x-app-layout>
    <div class="min-h-screen bg-zinc-950 text-slate-100 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            
            {{-- Header & Tombol Kembali --}}
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <p class="text-zinc-500 text-xs font-bold uppercase tracking-widest mb-1">Dashboard &gt; Permohonan</p>
                    <h2 class="text-3xl font-black text-white tracking-tight">Detail Pendaftaran</h2>
                </div>
                <a href="{{ route('admin.internship-applications.index') }}" class="px-5 py-2.5 bg-zinc-900 border border-zinc-700 rounded-xl text-xs font-bold text-zinc-400 hover:text-white hover:bg-zinc-800 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    KEMBALI
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                {{-- KIRI: KARTU PROFIL & TOKEN --}}
                <div class="lg:col-span-4 space-y-6">
                    {{-- Profil Card --}}
                    <div class="bg-zinc-900 border border-zinc-800 rounded-[2rem] p-8 flex flex-col items-center text-center shadow-2xl">
                        <div class="w-24 h-24 bg-blue-600 rounded-3xl flex items-center justify-center text-4xl font-black text-white shadow-[0_0_20px_rgba(37,99,235,0.4)] mb-6">
                            {{ substr($internshipApplication->name, 0, 1) }}
                        </div>
                        <h3 class="text-xl font-black text-white">{{ $internshipApplication->name }}</h3>
                        <p class="text-sm text-zinc-400 font-medium mb-5">{{ $internshipApplication->email }}</p>
                        
                        @if($internshipApplication->status == 'pending')
                            <span class="bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest">Menunggu Review</span>
                        @elseif($internshipApplication->status == 'approved')
                            <span class="bg-green-500/10 text-green-500 border border-green-500/20 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest">Disetujui</span>
                        @else
                            <span class="bg-red-500/10 text-red-500 border border-red-500/20 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest">Ditolak</span>
                        @endif
                    </div>

                    {{-- Token Card --}}
                    <div class="bg-blue-600 rounded-[2rem] p-8 shadow-[0_0_30px_rgba(37,99,235,0.3)] relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                        <p class="text-blue-200 text-[10px] font-black uppercase tracking-widest mb-2 relative z-10">Token Akses Siswa</p>
                        <h3 class="text-3xl font-black text-white tracking-widest relative z-10">{{ $internshipApplication->token }}</h3>
                        <p class="text-[11px] text-blue-200 mt-4 leading-relaxed relative z-10">Gunakan token ini untuk pencarian data, akses logbook, dan monitoring siswa.</p>
                    </div>
                </div>

                {{-- KANAN: INFORMASI LENGKAP PENDAFTARAN --}}
                <div class="lg:col-span-8">
                    <div class="bg-zinc-900 border border-zinc-800 rounded-[2rem] p-8 shadow-2xl">
                        
                        <div class="flex items-center gap-3 mb-8 border-b border-zinc-800 pb-6">
                            <div class="w-10 h-10 bg-zinc-800 rounded-xl flex items-center justify-center text-zinc-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h3 class="text-lg font-black text-white tracking-widest uppercase">Informasi Pendaftaran Lengkap</h3>
                        </div>

                        {{-- Grid Data --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            {{-- Asal Sekolah --}}
                            <div class="bg-zinc-950 p-5 rounded-2xl border border-zinc-800/50">
                                <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2">Asal Sekolah / Kampus</p>
                                <p class="text-white font-bold text-sm">{{ $internshipApplication->school }}</p>
                            </div>

                            {{-- No WhatsApp --}}
                            <div class="bg-zinc-950 p-5 rounded-2xl border border-zinc-800/50">
                                <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2">No. WhatsApp</p>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824z"/></svg>
                                        <p class="text-white font-bold text-sm">{{ $internshipApplication->phone ?? '-' }}</p>
                                    </div>
                                    @if($internshipApplication->phone)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $internshipApplication->phone) }}" target="_blank" class="text-[10px] bg-green-500/10 text-green-500 px-3 py-1 rounded border border-green-500/20 font-black hover:bg-green-500 hover:text-white transition-colors">Chat &rarr;</a>
                                    @endif
                                </div>
                            </div>

                            {{-- Tanggal Mulai --}}
                            <div class="bg-zinc-950 p-5 rounded-2xl border border-zinc-800/50">
                                <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2">Tanggal Mulai Magang</p>
                                <p class="text-white font-bold text-sm">{{ $internshipApplication->start_date ? \Carbon\Carbon::parse($internshipApplication->start_date)->translatedFormat('d F Y') : '-' }}</p>
                            </div>

                            {{-- Tanggal Selesai --}}
                            <div class="bg-zinc-950 p-5 rounded-2xl border border-zinc-800/50">
                                <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2">Tanggal Selesai Magang</p>
                                <p class="text-white font-bold text-sm">{{ $internshipApplication->end_date ? \Carbon\Carbon::parse($internshipApplication->end_date)->translatedFormat('d F Y') : '-' }}</p>
                            </div>

                            {{-- Tipe Pendaftaran --}}
                            <div class="bg-zinc-950 p-5 rounded-2xl border border-zinc-800/50">
                                <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2">Tipe Pendaftaran</p>
                                <p class="text-white font-bold text-sm uppercase">{{ $internshipApplication->registration_type }}</p>
                            </div>

                            {{-- Dokumen Surat Pengantar / Proposal --}}
                            <div class="bg-zinc-950 p-5 rounded-2xl border border-zinc-800/50">
                                <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2">Surat Pengantar / Proposal</p>
                                @if($internshipApplication->attachment_path)
                                    <a href="{{ asset('storage/' . $internshipApplication->attachment_path) }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-black text-blue-500 hover:text-blue-400 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        Buka Dokumen &rarr;
                                    </a>
                                @else
                                    <p class="text-zinc-600 font-bold text-sm italic">Tidak melampirkan file.</p>
                                @endif
                            </div>
                        </div>

                        {{-- Daftar Anggota Tim (Muncul jika kelompok) --}}
                        @if($internshipApplication->registration_type === 'kelompok' && $internshipApplication->group_members)
                            <div class="mb-8">
                                <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2">Anggota Tim / Kelompok</p>
                                <div class="bg-zinc-950 p-5 rounded-2xl border border-zinc-800/50">
                                    <p class="text-white text-sm font-medium leading-relaxed">{{ $internshipApplication->group_members }}</p>
                                </div>
                            </div>
                        @endif

                        {{-- Motivasi Magang --}}
                        <div class="mb-10">
                            <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2">Alasan & Motivasi Magang</p>
                            <div class="bg-zinc-950 p-6 rounded-2xl border border-zinc-800/50">
                                <p class="text-zinc-300 text-sm italic leading-relaxed">"{{ $internshipApplication->motivation }}"</p>
                            </div>
                        </div>

                        {{-- TOMBOL AKSI (Hanya muncul jika status masih PENDING) --}}
                        @if($internshipApplication->status == 'pending')
                            <div class="flex flex-col sm:flex-row gap-4 border-t border-zinc-800 pt-8">
                                
                                {{-- Tombol Setujui --}}
                                <form action="{{ route('admin.internship-applications.approve', $internshipApplication->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-black py-4 rounded-xl shadow-[0_0_20px_rgba(22,163,74,0.2)] transition-all flex justify-center items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        SETUJUI & KIRIM TOKEN
                                    </button>
                                </form>

                                {{-- Tombol Tolak (Memicu Modal) --}}
                                <button type="button" onclick="document.getElementById('modal-reject').style.display='flex'" class="flex-1 bg-transparent border-2 border-red-600/30 hover:bg-red-600/10 text-red-500 font-black py-4 rounded-xl transition-all flex justify-center items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    TOLAK APLIKASI
                                </button>

                            </div>

                            {{-- MODAL PENOLAKAN (REJECT) --}}
                            <div id="modal-reject" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
                                <div class="bg-zinc-900 border border-zinc-800 rounded-[2rem] p-8 max-w-md w-full shadow-2xl">
                                    <h3 class="text-2xl font-black text-white mb-2">Tolak Pendaftaran?</h3>
                                    <p class="text-xs text-zinc-400 mb-6 leading-relaxed">Berikan alasan penolakan agar siswa mengerti. Alasan ini akan tercatat di sistem.</p>
                                    
                                    <form action="{{ route('admin.internship-applications.reject', $internshipApplication->id) }}" method="POST">
                                        @csrf
                                        <textarea name="rejection_reason" rows="4" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl p-4 text-white focus:border-red-600 outline-none mb-6 text-sm" placeholder="Contoh: Maaf, kuota magang untuk bulan tersebut sudah penuh..." required></textarea>
                                        
                                        <div class="flex gap-4">
                                            <button type="button" onclick="document.getElementById('modal-reject').style.display='none'" class="flex-1 py-3 bg-zinc-800 hover:bg-zinc-700 text-white font-bold rounded-xl transition-colors">Batal</button>
                                            <button type="submit" class="flex-1 py-3 bg-red-600 hover:bg-red-700 text-white font-black rounded-xl shadow-[0_0_15px_rgba(220,38,38,0.3)] transition-all">Konfirmasi Tolak</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>