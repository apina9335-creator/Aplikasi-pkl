<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pembimbing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h3 class="font-bold text-lg mb-6">Daftar Siswa Bimbingan</h3>

                    {{-- === FITUR FILTER SEKOLAH === --}}
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <form method="GET" action="{{ route('advisor.dashboard') }}" class="flex flex-col md:flex-row gap-4 items-end">
                            
                            <div class="w-full md:w-1/3">
                                <label for="school" class="block text-sm font-medium text-gray-700 mb-1">Filter Asal Sekolah/Kampus</label>
                                <select name="school" id="school" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">-- Tampilkan Semua --</option>
                                    @foreach($schools as $schoolName)
                                        <option value="{{ $schoolName }}" {{ request('school') == $schoolName ? 'selected' : '' }}>
                                            {{ $schoolName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex gap-2">
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition font-bold">
                                    Filter
                                </button>
                                @if(request('school'))
                                    <a href="{{ route('advisor.dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                    {{-- === END FITUR FILTER === --}}

                    {{-- TABEL SISWA --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 uppercase text-xs leading-normal">
                                    <th class="py-3 px-6 text-left">Nama Siswa</th>
                                    <th class="py-3 px-6 text-left">Asal Sekolah</th>
                                    <th class="py-3 px-6 text-center">Durasi Magang</th>
                                    <th class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @forelse($students as $student)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-6 text-left font-bold">
                                        {{ $student->user->name }}
                                        <div class="text-xs text-gray-400 font-normal">{{ $student->user->email }}</div>
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs font-bold">
                                            {{ $student->school }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        {{ \Carbon\Carbon::parse($student->start_date)->format('d M') }} - 
                                        {{ \Carbon\Carbon::parse($student->end_date)->format('d M Y') }}
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <a href="{{ route('advisor.monitor', $student->id) }}" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-xs font-bold transition">
                                            Monitor Logbook
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-6 text-gray-500">
                                        Tidak ada data siswa yang ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $students->withQueryString()->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>