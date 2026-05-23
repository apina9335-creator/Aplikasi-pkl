<x-app-layout>
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
                <p class="text-zinc-500 font-bold text-[10px] uppercase tracking-[0.2em] mt-2 ml-16">Manajemen Siswa PKL & Mahasiswa Magang</p>
            </div>
            
            <a href="{{ route('admin.students.create') }}" class="inline-flex items-center justify-center bg-red-600 hover:bg-red-700 text-white font-black py-3 px-6 rounded-xl shadow-[0_0_20px_rgba(220,38,38,0.3)] transition-all transform active:scale-95 text-sm tracking-widest gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                TAMBAH AKUN
            </a>
        </div>

        <div class="max-w-7xl mx-auto space-y-6" x-data="{ activeTab: 'pkl' }">
            
            {{-- ALERT SUCCESS --}}
            @if(session('success'))
                <div class="bg-green-500/10 border border-green-500/30 text-green-500 px-6 py-4 rounded-2xl font-bold flex items-center gap-3 animate-pulse shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- TAB NAVIGATION --}}
            <div class="flex space-x-2 bg-zinc-900 p-2 rounded-[1.5rem] border border-zinc-800 shadow-2xl overflow-x-auto">
                <button @click="activeTab = 'pkl'" 
                        :class="activeTab === 'pkl' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'text-zinc-500 hover:text-white hover:bg-zinc-800'"
                        class="flex-1 py-3 px-6 rounded-xl font-black text-sm uppercase tracking-widest transition-all whitespace-nowrap flex items-center justify-center gap-2">
                    Anak PKL (SMK) <span class="bg-black/30 px-2 py-0.5 rounded-md text-[10px]">{{ $pklStudents->count() }}</span>
                </button>
                <button @click="activeTab = 'magang'" 
                        :class="activeTab === 'magang' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'text-zinc-500 hover:text-white hover:bg-zinc-800'"
                        class="flex-1 py-3 px-6 rounded-xl font-black text-sm uppercase tracking-widest transition-all whitespace-nowrap flex items-center justify-center gap-2">
                    Mahasiswa Magang <span class="bg-black/30 px-2 py-0.5 rounded-md text-[10px]">{{ $magangStudents->count() }}</span>
                </button>
                <button @click="activeTab = 'other'" 
                        :class="activeTab === 'other' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'text-zinc-500 hover:text-white hover:bg-zinc-800'"
                        class="flex-1 py-3 px-6 rounded-xl font-black text-sm uppercase tracking-widest transition-all whitespace-nowrap flex items-center justify-center gap-2">
                    Lainnya <span class="bg-black/30 px-2 py-0.5 rounded-md text-[10px]">{{ $otherStudents->count() }}</span>
                </button>
            </div>

            {{-- TAB CONTENT: PKL (SMK) --}}
            <div x-show="activeTab === 'pkl'" x-cloak>
                @include('admin.students.partials.student_list', ['students' => $pklStudents, 'typeLabel' => 'Siswa PKL (SMK/Sederajat)'])
            </div>

            {{-- TAB CONTENT: MAGANG (MAHASISWA) --}}
            <div x-show="activeTab === 'magang'" x-cloak>
                @include('admin.students.partials.student_list', ['students' => $magangStudents, 'typeLabel' => 'Mahasiswa Magang (Kampus)'])
            </div>

            {{-- TAB CONTENT: LAINNYA --}}
            <div x-show="activeTab === 'other'" x-cloak>
                @include('admin.students.partials.student_list', ['students' => $otherStudents, 'typeLabel' => 'Peserta Lainnya (Sekolah Belum Ditetapkan)'])
            </div>

        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</x-app-layout>