<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">{{ __('Daftar Siswa') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <form method="GET" action="{{ route('admin.students.index') }}" class="flex items-center space-x-2">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, email, sekolah..." class="border rounded px-3 py-2 text-sm">
                            <button class="px-3 py-2 bg-blue-600 text-white rounded text-sm">Cari</button>
                        </form>
                        <div>
                            @if(Route::has('admin.students.create'))
                                <a href="{{ route('admin.students.create') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-md text-sm font-medium">+ Tambah Siswa</a>
                            @endif
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 text-sm text-green-600">{{ session('success') }}</div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-600 dark:text-gray-200">
                            <thead class="text-xs text-gray-700 dark:text-gray-200 uppercase bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3">No</th>
                                    <th class="px-4 py-3">Nama</th>
                                    <th class="px-4 py-3">NIS</th>
                                    <th class="px-4 py-3">Asal Sekolah</th>
                                    <th class="px-4 py-3">Email</th>
                                    <th class="px-4 py-3">Telepon</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $index => $student)
                                <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-4 py-4">{{ $students->firstItem() + $index }}</td>
                                    <td class="px-4 py-4 flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center">
                                            <img src="{{ $student->profile_photo_path ? asset('storage/'.$student->profile_photo_path) : 'https://ui-avatars.com/api/?name='.urlencode($student->name).'&background=ddd&color=444' }}" alt="avatar" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-800 dark:text-gray-100">{{ $student->name }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $student->school ?? '-' }}</div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">{{ $student->nim ?? '-' }}</td>
                                    <td class="px-4 py-4">{{ $student->school ?? '-' }}</td>
                                    <td class="px-4 py-4">{{ $student->email }}</td>
                                    <td class="px-4 py-4">{{ $student->phone ?? '-' }}</td>
                                    <td class="px-4 py-4 text-center">
                                        @php
                                            $app = $student->latestInternshipApplication ?? null;
                                            $st = $app ? ($app->status ?? 'pending') : 'no_application';
                                        @endphp

                                        @if($st === 'no_application')
                                            <span class="text-xs text-gray-500 dark:text-gray-400">-</span>
                                        @elseif($st == 'pending' || $st == 'menunggu')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full border border-yellow-200">Menunggu</span>
                                        @elseif(in_array($st, ['approved','diterima']))
                                            <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full border border-green-200">Diterima</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full border border-red-200">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <div class="inline-flex items-center space-x-2 justify-center">
                                            <a href="{{ route('admin.students.edit', $student->id) }}" class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-xs font-medium rounded">Edit</a>
                                            <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Hapus data siswa ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">Tidak ada data siswa.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $students->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>