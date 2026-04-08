<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Dashboard Pembimbing') }}
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen bg-slate-50 dark:bg-gray-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 dark:border-gray-700 transition-colors duration-300">
                <div class="p-6 sm:p-8 text-gray-900 dark:text-gray-100">
                    
                    <div class="mb-8">
                        <h3 class="font-bold text-2xl text-gray-800 dark:text-white flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            Daftar Siswa Bimbingan
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">Pilih siswa untuk memantau logbook dan aktivitas harian mereka.</p>
                    </div>

                    {{-- === FITUR FILTER SEKOLAH === --}}
                    <div class="mb-8 bg-slate-50 dark:bg-gray-700/50 p-5 rounded-xl border border-slate-100 dark:border-gray-600/50">
                        <form method="GET" action="{{ route('advisor.dashboard') }}" class="flex flex-col md:flex-row gap-4 items-end">
                            
                            <div class="w-full md:w-1/3">
                                <label for="school" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Filter Asal Sekolah / Kampus</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    <select name="school" id="school" class="pl-10 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-500/50 transition-colors">
                                        <option value="">-- Tampilkan Semua --</option>
                                        @foreach($schools as $schoolName)
                                            <option value="{{ $schoolName }}" {{ request('school') == $schoolName ? 'selected' : '' }}>
                                                {{ $schoolName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="flex gap-2 w-full md:w-auto">
                                <button type="submit" class="flex-1 md:flex-none inline-flex items-center justify-center bg-blue-600 dark:bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 dark:hover:bg-blue-500 transition-colors font-semibold shadow-sm">
                                    Terapkan Filter
                                </button>
                                @if(request('school'))
                                    <a href="{{ route('advisor.dashboard') }}" class="flex-1 md:flex-none inline-flex items-center justify-center bg-gray-500 dark:bg-gray-600 text-white px-5 py-2.5 rounded-lg hover:bg-gray-600 dark:hover:bg-gray-500 transition-colors font-semibold shadow-sm">
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                    {{-- === END FITUR FILTER === --}}

                    {{-- TABEL SISWA --}}
                    <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-xl">
                        <table class="min-w-full bg-white dark:bg-gray-800 text-left">
                            <thead class="bg-gray-50 dark:bg-gray-700/80 border-b border-gray-200 dark:border-gray-700">
                                <tr class="text-gray-600 dark:text-gray-300 uppercase text-xs font-bold tracking-wider">
                                    <th class="py-4 px-6">Profil Siswa</th>
                                    <th class="py-4 px-6">Asal Sekolah</th>
                                    <th class="py-4 px-6 text-center">Durasi PKL</th>
                                    <th class="py-4 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse($students as $student)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-lg border border-blue-200 dark:border-blue-800 flex-shrink-0">
                                                {{ substr($student->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-900 dark:text-gray-100">{{ $student->user->name }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $student->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="inline-flex items-center bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 py-1 px-3 rounded-md text-xs font-semibold border border-indigo-100 dark:border-indigo-800/50">
                                            {{ $student->school }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center text-gray-600 dark:text-gray-400 font-medium">
                                        {{ \Carbon\Carbon::parse($student->start_date)->format('d M') }} <span class="mx-1 text-gray-400">➔</span> 
                                        {{ \Carbon\Carbon::parse($student->end_date)->format('d M Y') }}
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <a href="{{ route('advisor.monitor', $student->id) }}" class="inline-flex items-center bg-blue-500 dark:bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-600 dark:hover:bg-blue-500 text-sm font-bold transition-all shadow-sm hover:shadow hover:-translate-y-0.5">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Pantau
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-12">
                                        <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                            </div>
                                            <p class="text-lg font-medium text-gray-900 dark:text-gray-200">Tidak ada siswa bimbingan</p>
                                            <p class="text-sm mt-1">Belum ada siswa yang mendaftar dari sekolah yang dicari.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $students->withQueryString()->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>