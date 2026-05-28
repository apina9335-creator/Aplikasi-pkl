<x-app-layout>
    @php
        $pklSchools = $pklApplications->pluck('school')->map(fn($s) => trim($s))->filter(fn($s) => strtolower($s) !== 'lainnya' && !empty($s))->unique()->values();
        $magangSchools = $magangApplications->pluck('school')->map(fn($s) => trim($s))->filter(fn($s) => strtolower($s) !== 'lainnya' && !empty($s))->unique()->values();
    @endphp

    <div class="min-h-screen bg-zinc-950 text-slate-100 antialiased py-8 px-4 sm:px-6 lg:px-8">
        
        {{-- HEADER --}}
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="font-black text-3xl text-white leading-tight flex items-center gap-3">
                    <div class="w-12 h-12 bg-red-600 rounded-2xl flex items-center justify-center shadow-[0_0_15px_rgba(220,38,38,0.4)]">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    DATA <span class="text-red-600 uppercase tracking-tighter">PENDAFTARAN</span>
                </h2>
                <p class="text-zinc-500 font-bold text-[10px] uppercase tracking-[0.2em] mt-2 ml-16">Seleksi Masuk PKL & Magang</p>
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
                    Lamaran PKL (SMK) <span class="bg-black/30 px-2 py-0.5 rounded-md text-[10px]">{{ $pklApplications->count() }}</span>
                </button>
                <button @click="activeTab = 'magang'" :class="activeTab === 'magang' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'text-zinc-500 hover:text-white hover:bg-zinc-800'" class="flex-1 py-3 px-6 rounded-xl font-black text-sm uppercase tracking-widest transition-all whitespace-nowrap flex items-center justify-center gap-2">
                    Lamaran Magang (Kampus) <span class="bg-black/30 px-2 py-0.5 rounded-md text-[10px]">{{ $magangApplications->count() }}</span>
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
                                    <th class="p-5 font-black uppercase text-[10px] tracking-widest">Pendaftar</th>
                                    <th class="p-5 font-black uppercase text-[10px] tracking-widest">Sekolah</th>
                                    <th class="p-5 font-black uppercase text-[10px] tracking-widest">Tipe & Status</th>
                                    <th class="p-5 font-black uppercase text-[10px] tracking-widest text-center">Aksi (Lihat Detail)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-800">
                                @forelse($pklApplications as $app)
                                    <tr class="hover:bg-zinc-800/50 transition-colors row-pkl" data-sekolah="{{ strtolower($app->school) }}" data-tipe="{{ strtolower($app->registration_type) }}">
                                        <td class="p-5">
                                            <p class="font-bold text-white capitalize">{{ $app->name }}</p>
                                            <p class="text-green-500 mt-1 flex items-center gap-1 text-xs">🟢 {{ $app->phone ?? '-' }}</p>
                                        </td>
                                        <td class="p-5 font-medium text-zinc-300">{{ $app->school }}</td>
                                        <td class="p-5 space-y-2">
                                            <div>
                                                @if(strtolower($app->registration_type) == 'kelompok') <span class="bg-purple-500/20 text-purple-400 px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest border border-purple-500/30">Kelompok</span>
                                                @else <span class="bg-blue-500/20 text-blue-400 px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest border border-blue-500/30">Individu</span> @endif
                                            </div>
                                            <div>
                                                @if($app->status == 'approved') <span class="bg-green-500/20 text-green-400 px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest border border-green-500/30">Lolos</span>
                                                @elseif($app->status == 'rejected') <span class="bg-red-500/20 text-red-400 px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest border border-red-500/30">Tolak</span>
                                                @else <span class="bg-yellow-500/20 text-yellow-400 px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest border border-yellow-500/30 animate-pulse">Pending</span> @endif
                                            </div>
                                        </td>
                                        <td class="p-5 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                {{-- ICON MATA BIRU (SELEKSI) --}}
                                                <a href="{{ route('admin.internship-applications.show', $app->id) }}" class="bg-zinc-800 hover:bg-white text-blue-400 hover:text-blue-600 p-2.5 rounded-lg transition-all" title="Lihat/Seleksi Data">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </a>
                                                <form action="{{ route('admin.internship-applications.destroy', $app->id) }}" method="POST" onsubmit="return confirm('Hapus permanen lamaran ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="bg-red-900/30 text-red-500 hover:bg-red-600 hover:text-white p-2.5 rounded-lg transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="p-10 text-center text-zinc-500 font-bold uppercase tracking-widest">Tidak ada pendaftar PKL (SMK)</td></tr>
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
                                    <th class="p-5 font-black uppercase text-[10px] tracking-widest">Pendaftar</th>
                                    <th class="p-5 font-black uppercase text-[10px] tracking-widest">Kampus</th>
                                    <th class="p-5 font-black uppercase text-[10px] tracking-widest">Tipe & Status</th>
                                    <th class="p-5 font-black uppercase text-[10px] tracking-widest text-center">Aksi (Lihat Detail)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-800">
                                @forelse($magangApplications as $app)
                                    <tr class="hover:bg-zinc-800/50 transition-colors row-magang" data-sekolah="{{ strtolower($app->school) }}" data-tipe="{{ strtolower($app->registration_type) }}">
                                        <td class="p-5">
                                            <p class="font-bold text-white capitalize">{{ $app->name }}</p>
                                            <p class="text-green-500 mt-1 flex items-center gap-1 text-xs">🟢 {{ $app->phone ?? '-' }}</p>
                                        </td>
                                        <td class="p-5 font-medium text-zinc-300">{{ $app->school }}</td>
                                        <td class="p-5 space-y-2">
                                            <div>
                                                @if(strtolower($app->registration_type) == 'kelompok') <span class="bg-purple-500/20 text-purple-400 px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest border border-purple-500/30">Kelompok</span>
                                                @else <span class="bg-blue-500/20 text-blue-400 px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest border border-blue-500/30">Individu</span> @endif
                                            </div>
                                            <div>
                                                @if($app->status == 'approved') <span class="bg-green-500/20 text-green-400 px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest border border-green-500/30">Lolos</span>
                                                @elseif($app->status == 'rejected') <span class="bg-red-500/20 text-red-400 px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest border border-red-500/30">Tolak</span>
                                                @else <span class="bg-yellow-500/20 text-yellow-400 px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest border border-yellow-500/30 animate-pulse">Pending</span> @endif
                                            </div>
                                        </td>
                                        <td class="p-5 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                {{-- ICON MATA BIRU (SELEKSI) --}}
                                                <a href="{{ route('admin.internship-applications.show', $app->id) }}" class="bg-zinc-800 hover:bg-white text-blue-400 hover:text-blue-600 p-2.5 rounded-lg transition-all" title="Lihat/Seleksi Data">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </a>
                                                <form action="{{ route('admin.internship-applications.destroy', $app->id) }}" method="POST" onsubmit="return confirm('Hapus permanen lamaran ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="bg-red-900/30 text-red-500 hover:bg-red-600 hover:text-white p-2.5 rounded-lg transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="p-10 text-center text-zinc-500 font-bold uppercase tracking-widest">Tidak ada pendaftar Magang (Kampus)</td></tr>
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