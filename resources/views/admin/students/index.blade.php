<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">{{ __('Daftar Siswa') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- KOTAK UTAMA (Sudah ditambah dark:bg-gray-800) --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6">
                    
                    {{-- HEADER & PENCARIAN --}}
                    <div class="flex flex-col sm:flex-row items-center justify-between mb-6 gap-4">
                        <form method="GET" action="{{ route('admin.students.index') }}" class="flex items-center space-x-2 w-full sm:w-auto">
                            {{-- Input pencarian diperbaiki untuk mode malam --}}
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, email, sekolah..." 
                                   class="border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-400 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 w-full sm:w-64 transition-colors">
                            <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors shadow-sm">Cari</button>
                        </form>
                        
                        {{-- TOMBOL AKSI (DOWNLOAD EXCEL & TAMBAH SISWA) --}}
                        <div class="flex items-center gap-2">
                            {{-- Tombol Download Excel (Baru Ditambahkan) --}}
                            @if(Route::has('admin.students.export'))
                                <a href="{{ route('admin.students.export') }}" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm font-medium shadow-sm transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Download Excel
                                </a>
                            @endif

                            {{-- Tombol Tambah Siswa --}}
                            @if(Route::has('admin.students.create'))
                                <a href="{{ route('admin.students.create') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-sm font-medium shadow-sm transition-colors">
                                    + Tambah Siswa
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- NOTIFIKASI --}}
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
                                    <th class="px-4 py-3 font-semibold">No</th>
                                    <th class="px-4 py-3 font-semibold">Nama</th>
                                    <th class="px-4 py-3 font-semibold">NIS</th>
                                    <th class="px-4 py-3 font-semibold">Asal Sekolah</th>
                                    <th class="px-4 py-3 font-semibold">Email</th>
                                    <th class="px-4 py-3 font-semibold">Telepon</th>
                                    <th class="px-4 py-3 font-semibold text-center">Status PKL</th>
                                    <th class="px-4 py-3 font-semibold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $index => $student)
                                <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-4 py-4">{{ $students->firstItem() + $index }}</td>
                                    <td class="px-4 py-4 flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700 flex items-center justify-center flex-shrink-0 border border-gray-200 dark:border-gray-600">
                                            <img src="{{ $student->profile_photo_path ? asset('storage/'.$student->profile_photo_path) : 'https://ui-avatars.com/api/?name='.urlencode($student->name).'&background=ddd&color=444' }}" alt="avatar" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-800 dark:text-gray-100">{{ $student->name }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $student->school ?? '-' }}</div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">{{ $student->nim ?? $student->nis ?? '-' }}</td>
                                    <td class="px-4 py-4">{{ $student->school ?? '-' }}</td>
                                    <td class="px-4 py-4">{{ $student->email }}</td>
                                    <td class="px-4 py-4">{{ $student->phone ?? '-' }}</td>
                                    <td class="px-4 py-4 text-center">
                                        @php
                                            $app = $student->latestInternshipApplication ?? null;
                                            $st = $app ? ($app->status ?? 'pending') : 'no_application';
                                        @endphp

                                        {{-- STATUS BADGES (Sudah diperbaiki warna mode malamnya) --}}
                                        @if($st === 'no_application')
                                            <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">-</span>
                                        @elseif($st == 'pending' || $st == 'menunggu')
                                            <span class="bg-yellow-100 dark:bg-yellow-900/40 text-yellow-800 dark:text-yellow-300 text-xs font-bold px-3 py-1 rounded-full border border-yellow-200 dark:border-yellow-800/50">Menunggu</span>
                                        @elseif(in_array($st, ['approved','diterima']))
                                            <span class="bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300 text-xs font-bold px-3 py-1 rounded-full border border-green-200 dark:border-green-800/50">Diterima</span>
                                        @else
                                            <span class="bg-red-100 dark:bg-red-900/40 text-red-800 dark:text-red-300 text-xs font-bold px-3 py-1 rounded-full border border-red-200 dark:border-red-800/50">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <div class="inline-flex items-center space-x-2 justify-center">
                                            <a href="{{ route('admin.students.edit', $student->id) }}" class="px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-medium rounded shadow-sm transition-colors">Edit</a>
                                            <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Hapus data siswa ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded shadow-sm transition-colors">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">
                                        Tidak ada data siswa yang ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINASI --}}
                    <div class="mt-6">
                        {{ $students->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>