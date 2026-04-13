<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">{{ __('Daftar Siswa') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6">
                    
                    {{-- HEADER & PENCARIAN --}}
                    <div class="flex flex-col sm:flex-row items-center justify-between mb-6 gap-4">
                        <form method="GET" action="{{ route('admin.students.index') }}" class="flex items-center space-x-2 w-full sm:w-auto">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, email, sekolah..." 
                                   class="border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-400 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 w-full sm:w-64 transition-colors">
                            <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors shadow-sm">Cari</button>
                        </form>
                        
                        <div class="flex items-center gap-2">
                            @if(Route::has('admin.students.export'))
                                <a href="{{ route('admin.students.export') }}" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm font-medium shadow-sm transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Download Excel
                                </a>
                            @endif

                            @if(Route::has('admin.students.create'))
                                <a href="{{ route('admin.students.create') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-sm font-medium shadow-sm transition-colors">
                                    + Tambah Siswa
                                </a>
                            @endif
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 px-4 py-3 bg-green-100 dark:bg-green-900/40 border border-green-400 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg text-sm font-medium">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- TABEL DATA --}}
                    <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg">
                        <table class="min-w-full text-sm text-left text-gray-600 dark:text-gray-300">
                            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700/80 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th class="px-4 py-3 font-semibold w-12">No</th>
                                    <th class="px-4 py-3 font-semibold">Nama & Tipe Daftar</th>
                                    <th class="px-4 py-3 font-semibold">NIS</th>
                                    <th class="px-4 py-3 font-semibold">Asal Sekolah</th>
                                    <th class="px-4 py-3 font-semibold">Kontak</th>
                                    <th class="px-4 py-3 font-semibold text-center w-32">Status PKL</th>
                                    <th class="px-4 py-3 font-semibold text-center w-32">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse($students as $index => $student)
                                    @php
                                        $app = $student->latestInternshipApplication ?? null;
                                        $st = $app ? ($app->status ?? 'pending') : 'no_application';
                                    @endphp
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-4 py-4">{{ $students->firstItem() + $index }}</td>
                                    
                                    {{-- KOLOM NAMA & TIPE DAFTAR --}}
                                    <td class="px-4 py-4">
                                        <div class="flex items-start space-x-3">
                                            <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700 flex items-center justify-center flex-shrink-0 border border-gray-200 dark:border-gray-600 mt-1">
                                                <img src="{{ $student->profile_photo_path ? asset('storage/'.$student->profile_photo_path) : 'https://ui-avatars.com/api/?name='.urlencode($student->name).'&background=ddd&color=444' }}" alt="avatar" class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-800 dark:text-gray-100 text-base">{{ $student->name }}</div>
                                                
                                                {{-- BADGE TIPE PENDAFTARAN --}}
                                                <div class="mt-1.5">
                                                    @if($app && $app->registration_type === 'kelompok')
                                                        {{-- Tombol Pop-up Kelompok --}}
                                                        <button x-data x-on:click.prevent="$dispatch('open-modal', 'modal-anggota-{{ $student->id }}')" class="inline-flex items-center text-[10px] font-bold bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 px-2 py-0.5 rounded cursor-pointer hover:bg-indigo-200 dark:hover:bg-indigo-800/50 transition-colors border border-indigo-200 dark:border-indigo-800/50 shadow-sm">
                                                            👥 KELOMPOK (Lihat)
                                                        </button>

                                                        {{-- MODAL POP-UP ANGGOTA KELOMPOK --}}
                                                        <x-modal name="modal-anggota-{{ $student->id }}" :show="false" focusable>
                                                            <div class="p-6 bg-white dark:bg-gray-800">
                                                                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2 flex items-center gap-2">
                                                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                                    Daftar Anggota Kelompok
                                                                </h2>
                                                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 border-b border-gray-100 dark:border-gray-700 pb-3">
                                                                    Ketua / Pendaftar: <span class="font-bold text-gray-700 dark:text-gray-300">{{ $student->name }}</span>
                                                                </p>
                                                                
                                                                <div class="bg-slate-50 dark:bg-gray-900/50 p-4 rounded-xl border border-slate-200 dark:border-gray-700 text-gray-800 dark:text-gray-200 text-sm whitespace-pre-line leading-relaxed font-medium">
                                                                    {{ $app->group_members ?? 'Tidak ada data anggota yang diisi.' }}
                                                                </div>

                                                                <div class="mt-6 flex justify-end">
                                                                    <button x-on:click="$dispatch('close')" class="px-5 py-2.5 bg-gray-600 hover:bg-gray-700 text-white rounded-lg text-sm font-bold transition-colors shadow-sm">
                                                                        Tutup Panel
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </x-modal>

                                                    @elseif($app && $app->registration_type === 'individu')
                                                        <span class="inline-block text-[10px] font-bold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-2 py-0.5 rounded border border-gray-200 dark:border-gray-600 uppercase">
                                                            👤 Individu
                                                        </span>
                                                    @else
                                                        <span class="inline-block text-[10px] font-bold bg-red-50 dark:bg-red-900/20 text-red-500 dark:text-red-400 px-2 py-0.5 rounded border border-red-100 dark:border-red-800/30 uppercase">
                                                            Belum Daftar
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-4 py-4">{{ $student->nim ?? $student->nis ?? '-' }}</td>
                                    <td class="px-4 py-4 font-medium">{{ $student->school ?? '-' }}</td>
                                    <td class="px-4 py-4 text-xs">
                                        <div class="mb-1 text-blue-600 dark:text-blue-400">{{ $student->email }}</div>
                                        <div class="text-gray-500 dark:text-gray-400">{{ $student->phone ?? '-' }}</div>
                                    </td>
                                    
                                    <td class="px-4 py-4 text-center">
                                        @if($st === 'no_application')
                                            <span class="text-xs text-gray-400 dark:text-gray-500 font-medium italic">Kosong</span>
                                        @elseif($st == 'pending' || $st == 'menunggu')
                                            <span class="bg-yellow-100 dark:bg-yellow-900/40 text-yellow-800 dark:text-yellow-300 text-xs font-bold px-3 py-1 rounded-full border border-yellow-200 dark:border-yellow-800/50 block w-full text-center">Menunggu</span>
                                        @elseif(in_array($st, ['approved','diterima']))
                                            <span class="bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300 text-xs font-bold px-3 py-1 rounded-full border border-green-200 dark:border-green-800/50 block w-full text-center">Diterima</span>
                                        @else
                                            <span class="bg-red-100 dark:bg-red-900/40 text-red-800 dark:text-red-300 text-xs font-bold px-3 py-1 rounded-full border border-red-200 dark:border-red-800/50 block w-full text-center">Ditolak</span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-4 py-4 text-center">
                                        <div class="inline-flex items-center space-x-2 justify-center">
                                            <a href="{{ route('admin.students.edit', $student->id) }}" class="p-2 bg-green-500 hover:bg-green-600 text-white rounded-lg shadow-sm transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </a>
                                            <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Hapus data siswa ini secara permanen?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 bg-red-500 hover:bg-red-600 text-white rounded-lg shadow-sm transition-colors" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">
                                        <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        Tidak ada data siswa yang ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $students->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>