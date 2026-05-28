<x-app-layout>
    @php
        $pklSchools = $pklStudents->pluck('school')->map(fn($s) => trim($s))->filter(fn($s) => strtolower($s) !== 'lainnya' && !empty($s))->unique()->values();
        $magangSchools = $magangStudents->pluck('school')->map(fn($s) => trim($s))->filter(fn($s) => strtolower($s) !== 'lainnya' && !empty($s))->unique()->values();
    @endphp

    <div class="min-h-screen bg-zinc-950 text-slate-100 antialiased py-8 px-4 sm:px-6 lg:px-8">
        
        {{-- HEADER --}}
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="font-black text-3xl text-white leading-tight flex items-center gap-3">
                    <div class="w-12 h-12 bg-red-600 rounded-2xl flex items-center justify-center shadow-[0_0_15px_rgba(220,38,38,0.4)]">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    DATA <span class="text-red-600 uppercase tracking-tighter">PESERTA</span>
                </h2>
                <p class="text-zinc-500 font-bold text-[10px] uppercase tracking-[0.2em] mt-2 ml-16">Manajemen Peserta Aktif (PKL & Magang)</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto space-y-6" x-data="{ activeTab: 'pkl' }">
            
            {{-- ALERT SUCCESS --}}
            @if(session('success'))
                <div class="bg-green-500/10 border border-green-500/30 text-green-500 px-6 py-4 rounded-2xl font-bold flex items-center gap-3 animate-pulse shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- TAB SELECTION NAVIGATION --}}
            <div class="flex space-x-2 bg-zinc-900 p-2 rounded-[1.5rem] border border-zinc-800 shadow-2xl overflow-x-auto">
                <button @click="activeTab = 'pkl'" :class="activeTab === 'pkl' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'text-zinc-500 hover:text-white hover:bg-zinc-800'" class="flex-1 py-3 px-6 rounded-xl font-black text-sm uppercase tracking-widest transition-all whitespace-nowrap flex items-center justify-center gap-2">
                    Anak PKL (SMK) <span class="bg-black/30 px-2 py-0.5 rounded-md text-[10px]">{{ $pklStudents->count() }}</span>
                </button>
                <button @click="activeTab = 'magang'" :class="activeTab === 'magang' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'text-zinc-500 hover:text-white hover:bg-zinc-800'" class="flex-1 py-3 px-6 rounded-xl font-black text-sm uppercase tracking-widest transition-all whitespace-nowrap flex items-center justify-center gap-2">
                    Mahasiswa Magang <span class="bg-black/30 px-2 py-0.5 rounded-md text-[10px]">{{ $magangStudents->count() }}</span>
                </button>
            </div>

            {{-- ================== BAGIAN PKL (SMK) ================== --}}
            <div x-show="activeTab === 'pkl'" x-cloak class="space-y-6">
                {{-- FILTER KHUSUS PKL --}}
                <div class="bg-zinc-900 p-6 rounded-[1.5rem] border border-zinc-800 shadow-2xl flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2">Filter SMK/SMA</label>
                        <select id="filter-sekolah-pkl" class="w-full bg-black border border-zinc-800 rounded-xl p-3 text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-all text-sm outline-none">
                            <option value="all">Semua Sekolah (SMK/SMA)</option>
                            @foreach($pklSchools as $sekolah) <option value="{{ strtolower($sekolah) }}">{{ $sekolah }}</option> @endforeach
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2">Tipe Pendaftaran</label>
                        <select id="filter-tipe-pkl" class="w-full bg-black border border-zinc-800 rounded-xl p-3 text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-all text-sm outline-none">
                            <option value="all">Semua Tipe</option>
                            <option value="individu">Hanya Individu</option>
                            <option value="kelompok">Hanya Kelompok</option>
                        </select>
                    </div>
                </div>

                {{-- TABEL PKL --}}
                <div class="bg-zinc-900 rounded-[1.5rem] border border-zinc-800 overflow-hidden shadow-2xl">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm whitespace-nowrap">
                            <thead class="bg-black/50 text-zinc-500 border-b border-zinc-800">
                                <tr>
                                    <th class="p-5 font-black uppercase text-[10px] tracking-widest">Nama Peserta</th>
                                    <th class="p-5 font-black uppercase text-[10px] tracking-widest">Sekolah</th>
                                    <th class="p-5 font-black uppercase text-[10px] tracking-widest">Tipe & Token Akses</th>
                                    <th class="p-5 font-black uppercase text-[10px] tracking-widest text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-800">
                                @forelse($pklStudents as $siswa)
                                    @php
                                        // PENGHITUNGAN HARI (SUDAH DIBULATKAN)
                                        $start = \Carbon\Carbon::parse($siswa->start_date)->startOfDay();
                                        $end = \Carbon\Carbon::parse($siswa->end_date)->endOfDay();
                                        $now = \Carbon\Carbon::now();
                                        
                                        $totalDays = (int) $start->diffInDays($end);
                                        $daysRunning = $now->between($start, $end) ? (int) $start->diffInDays($now) : ($now->greaterThan($end) ? $totalDays : 0);
                                    @endphp
                                    <tr class="hover:bg-zinc-800/50 transition-colors row-pkl" data-sekolah="{{ strtolower($siswa->school) }}" data-tipe="{{ strtolower($siswa->registration_type ?? 'individu') }}">
                                        <td class="p-5">
                                            <p class="font-bold text-white capitalize">{{ $siswa->name }}</p>
                                            <p class="text-green-500 mt-1 flex items-center gap-1 text-xs">🟢 {{ $siswa->phone ?? '-' }}</p>
                                        </td>
                                        <td class="p-5 font-medium text-zinc-300">{{ $siswa->school }}</td>
                                        <td class="p-5">
                                            @if(strtolower($siswa->registration_type ?? '') == 'kelompok') <span class="bg-purple-500/20 text-purple-400 px-3 py-1 rounded-md text-[10px] font-black uppercase tracking-widest border border-purple-500/30">Kelompok</span>
                                            @else <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-md text-[10px] font-black uppercase tracking-widest border border-blue-500/30">Individu</span> @endif
                                            <p class="mt-2 font-mono text-xs font-black text-red-500 tracking-widest bg-red-900/20 inline-block px-2 py-1 rounded border border-red-900/50">{{ $siswa->token }}</p>
                                        </td>
                                        <td class="p-5 text-center" x-data="{ openDetail: false }">
                                            <div class="flex items-center justify-center gap-2">
                                                <button @click="openDetail = true" class="bg-zinc-800 hover:bg-white text-zinc-400 hover:text-black p-2.5 rounded-lg transition-all" title="Lihat Detail">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </button>
                                                <form action="{{ route('admin.students.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Hapus permanen peserta ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="bg-red-900/30 text-red-500 hover:bg-red-600 hover:text-white p-2.5 rounded-lg transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                                </form>
                                            </div>

                                            {{-- MODAL POP-UP DETAIL DARK MODE --}}
                                            <div x-show="openDetail" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm">
                                                <div @click.away="openDetail = false" class="bg-zinc-900 p-6 rounded-[1.5rem] shadow-2xl w-96 text-left border border-zinc-800 relative text-white">
                                                    <button @click="openDetail = false" class="absolute top-4 right-4 text-zinc-500 hover:text-red-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                                    <h3 class="text-lg font-black text-white mb-4 border-b border-zinc-800 pb-2">Informasi Peserta</h3>
                                                    <div class="space-y-3 text-sm">
                                                        <p><span class="font-bold text-zinc-500 block text-[10px] uppercase tracking-widest">Nama:</span> <span class="font-bold">{{ $siswa->name }}</span></p>
                                                        <p><span class="font-bold text-zinc-500 block text-[10px] uppercase tracking-widest">Token Harian:</span> <span class="font-mono text-red-500 font-black bg-red-900/30 px-2 py-0.5 rounded">{{ $siswa->token }}</span></p>
                                                        <p><span class="font-bold text-zinc-500 block text-[10px] uppercase tracking-widest">Periode Magang:</span> <span class="text-zinc-300">{{ $start->format('d M Y') }} - {{ $end->format('d M Y') }}</span></p>
                                                        <p><span class="font-bold text-zinc-500 block text-[10px] uppercase tracking-widest">Total Durasi:</span> <span class="text-zinc-300">{{ $totalDays }} Hari</span></p>
                                                        <div class="bg-black/50 border border-zinc-800 p-4 rounded-xl mt-2">
                                                            <p class="text-zinc-400 font-bold text-xs uppercase tracking-widest">🚀 Sudah Berjalan:</p>
                                                            <p class="text-3xl font-black text-white mt-1">{{ $daysRunning }} <span class="text-sm font-bold text-zinc-500">Hari</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="p-10 text-center text-zinc-500 font-bold uppercase tracking-widest">Tidak ada data Anak PKL</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ================== BAGIAN MAGANG (KAMPUS) ================== --}}
            <div x-show="activeTab === 'magang'" x-cloak class="space-y-6">
                {{-- FILTER KHUSUS MAGANG --}}
                <div class="bg-zinc-900 p-6 rounded-[1.5rem] border border-zinc-800 shadow-2xl flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2">Filter Universitas</label>
                        <select id="filter-sekolah-magang" class="w-full bg-black border border-zinc-800 rounded-xl p-3 text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-all text-sm outline-none">
                            <option value="all">Semua Universitas</option>
                            @foreach($magangSchools as $sekolah) <option value="{{ strtolower($sekolah) }}">{{ $sekolah }}</option> @endforeach
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2">Tipe Pendaftaran</label>
                        <select id="filter-tipe-magang" class="w-full bg-black border border-zinc-800 rounded-xl p-3 text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-all text-sm outline-none">
                            <option value="all">Semua Tipe</option>
                            <option value="individu">Hanya Individu</option>
                            <option value="kelompok">Hanya Kelompok</option>
                        </select>
                    </div>
                </div>

                {{-- TABEL MAGANG --}}
                <div class="bg-zinc-900 rounded-[1.5rem] border border-zinc-800 overflow-hidden shadow-2xl">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm whitespace-nowrap">
                            <thead class="bg-black/50 text-zinc-500 border-b border-zinc-800">
                                <tr>
                                    <th class="p-5 font-black uppercase text-[10px] tracking-widest">Nama Mahasiswa</th>
                                    <th class="p-5 font-black uppercase text-[10px] tracking-widest">Kampus</th>
                                    <th class="p-5 font-black uppercase text-[10px] tracking-widest">Tipe & Token Akses</th>
                                    <th class="p-5 font-black uppercase text-[10px] tracking-widest text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-800">
                                @forelse($magangStudents as $siswa)
                                    @php
                                        // PENGHITUNGAN HARI (SUDAH DIBULATKAN)
                                        $start = \Carbon\Carbon::parse($siswa->start_date)->startOfDay();
                                        $end = \Carbon\Carbon::parse($siswa->end_date)->endOfDay();
                                        $now = \Carbon\Carbon::now();
                                        
                                        $totalDays = (int) $start->diffInDays($end);
                                        $daysRunning = $now->between($start, $end) ? (int) $start->diffInDays($now) : ($now->greaterThan($end) ? $totalDays : 0);
                                    @endphp
                                    <tr class="hover:bg-zinc-800/50 transition-colors row-magang" data-sekolah="{{ strtolower($siswa->school) }}" data-tipe="{{ strtolower($siswa->registration_type ?? 'individu') }}">
                                        <td class="p-5">
                                            <p class="font-bold text-white capitalize">{{ $siswa->name }}</p>
                                            <p class="text-green-500 mt-1 flex items-center gap-1 text-xs">🟢 {{ $siswa->phone ?? '-' }}</p>
                                        </td>
                                        <td class="p-5 font-medium text-zinc-300">{{ $siswa->school }}</td>
                                        <td class="p-5">
                                            @if(strtolower($siswa->registration_type ?? '') == 'kelompok') <span class="bg-purple-500/20 text-purple-400 px-3 py-1 rounded-md text-[10px] font-black uppercase tracking-widest border border-purple-500/30">Kelompok</span>
                                            @else <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-md text-[10px] font-black uppercase tracking-widest border border-blue-500/30">Individu</span> @endif
                                            <p class="mt-2 font-mono text-xs font-black text-red-500 tracking-widest bg-red-900/20 inline-block px-2 py-1 rounded border border-red-900/50">{{ $siswa->token }}</p>
                                        </td>
                                        <td class="p-5 text-center" x-data="{ openDetail: false }">
                                            <div class="flex items-center justify-center gap-2">
                                                <button @click="openDetail = true" class="bg-zinc-800 hover:bg-white text-zinc-400 hover:text-black p-2.5 rounded-lg transition-all" title="Lihat Detail">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </button>
                                                <form action="{{ route('admin.students.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Hapus permanen peserta ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="bg-red-900/30 text-red-500 hover:bg-red-600 hover:text-white p-2.5 rounded-lg transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                                </form>
                                            </div>

                                            {{-- MODAL POP-UP DETAIL DARK MODE --}}
                                            <div x-show="openDetail" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm">
                                                <div @click.away="openDetail = false" class="bg-zinc-900 p-6 rounded-[1.5rem] shadow-2xl w-96 text-left border border-zinc-800 relative text-white">
                                                    <button @click="openDetail = false" class="absolute top-4 right-4 text-zinc-500 hover:text-red-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                                    <h3 class="text-lg font-black text-white mb-4 border-b border-zinc-800 pb-2">Informasi Peserta</h3>
                                                    <div class="space-y-3 text-sm">
                                                        <p><span class="font-bold text-zinc-500 block text-[10px] uppercase tracking-widest">Nama:</span> <span class="font-bold">{{ $siswa->name }}</span></p>
                                                        <p><span class="font-bold text-zinc-500 block text-[10px] uppercase tracking-widest">Token Harian:</span> <span class="font-mono text-red-500 font-black bg-red-900/30 px-2 py-0.5 rounded">{{ $siswa->token }}</span></p>
                                                        <p><span class="font-bold text-zinc-500 block text-[10px] uppercase tracking-widest">Periode Magang:</span> <span class="text-zinc-300">{{ $start->format('d M Y') }} - {{ $end->format('d M Y') }}</span></p>
                                                        <p><span class="font-bold text-zinc-500 block text-[10px] uppercase tracking-widest">Total Durasi:</span> <span class="text-zinc-300">{{ $totalDays }} Hari</span></p>
                                                        <div class="bg-black/50 border border-zinc-800 p-4 rounded-xl mt-2">
                                                            <p class="text-zinc-400 font-bold text-xs uppercase tracking-widest">🚀 Sudah Berjalan:</p>
                                                            <p class="text-3xl font-black text-white mt-1">{{ $daysRunning }} <span class="text-sm font-bold text-zinc-500">Hari</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="p-10 text-center text-zinc-500 font-bold uppercase tracking-widest">Tidak ada data Mahasiswa Magang</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>[x-cloak] { display: none !important; }</style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fSekolahPkl = document.getElementById('filter-sekolah-pkl');
            const fTipePkl = document.getElementById('filter-tipe-pkl');
            const rowsPkl = document.querySelectorAll('.row-pkl');
            function applyPkl() {
                const s = fSekolahPkl.value.toLowerCase(), t = fTipePkl.value.toLowerCase();
                rowsPkl.forEach(r => {
                    r.style.display = ((s === 'all' || r.getAttribute('data-sekolah') === s) && (t === 'all' || r.getAttribute('data-tipe') === t)) ? '' : 'none';
                });
            }
            if(fSekolahPkl) fSekolahPkl.addEventListener('change', applyPkl);
            if(fTipePkl) fTipePkl.addEventListener('change', applyPkl);

            const fSekolahMagang = document.getElementById('filter-sekolah-magang');
            const fTipeMagang = document.getElementById('filter-tipe-magang');
            const rowsMagang = document.querySelectorAll('.row-magang');
            function applyMagang() {
                const s = fSekolahMagang.value.toLowerCase(), t = fTipeMagang.value.toLowerCase();
                rowsMagang.forEach(r => {
                    r.style.display = ((s === 'all' || r.getAttribute('data-sekolah') === s) && (t === 'all' || r.getAttribute('data-tipe') === t)) ? '' : 'none';
                });
            }
            if(fSekolahMagang) fSekolahMagang.addEventListener('change', applyMagang);
            if(fTipeMagang) fTipeMagang.addEventListener('change', applyMagang);
        });
    </script>
</x-app-layout>