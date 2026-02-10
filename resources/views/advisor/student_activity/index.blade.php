@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Keaktivan Mahasiswa</h1>
            <p class="text-gray-600 mt-2">Pantau keaktivan dan perkembangan mahasiswa selama PKL</p>
        </div>

        <!-- Students Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Nama Mahasiswa</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status PKL</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Bimbingan</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Laporan</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($students as $student)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $student->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $student->email }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($student->internships && $student->internships->count() > 0)
                                    <span class="inline-block px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                                        ✓ Sedang PKL
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-800">
                                        Belum PKL
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $student->guidanceSessions->count() ?? 0 }} sesi
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $student->reports->count() ?? 0 }} laporan
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('advisor.student-activity.show', $student) }}" 
                                   class="text-blue-600 hover:text-blue-800 font-medium">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-600">
                                Tidak ada mahasiswa untuk ditampilkan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $students->links() }}
        </div>
    </div>
</div>
@endsection
