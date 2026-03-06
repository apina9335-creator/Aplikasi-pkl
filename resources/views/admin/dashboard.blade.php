<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- ========================================== --}}
            {{-- KOTAK 1: LAMARAN TERBARU (DIPISAH DI ATAS) --}}
            {{-- ========================================== --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Lamaran Terbaru</h2>
                    
                    @if($recentApplications->isEmpty())
                        <p class="text-sm text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">Belum ada lamaran masuk terbaru.</p>
                    @else
                        <div class="space-y-3">
                            @foreach($recentApplications as $app)
                                <div class="flex flex-col md:flex-row md:items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 border dark:border-gray-600 rounded-lg shadow-sm">
                                    <div class="mb-3 md:mb-0">
                                        <div class="font-medium text-lg text-gray-800 dark:text-gray-100">
                                            {{ $app->user->name ?? '—' }} 
                                            <span class="text-sm font-normal text-gray-500">({{ $app->user->email ?? '—' }})</span>
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            <span class="font-semibold">{{ $app->company->name ?? 'PT Global Intermedia' }}</span> — {{ $app->applied_at ? $app->applied_at->format('d M Y') : '' }}
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        @if($app->status === 'pending' || $app->status === 'menunggu')
                                            <form action="{{ route('admin.applications.update', $app->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded shadow">Terima</button>
                                            </form>
                                            <button onclick="document.getElementById('reject-{{$app->id}}').classList.remove('hidden')" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded shadow">Tolak</button>
                                            <form id="reject-{{$app->id}}" action="{{ route('admin.applications.update', $app->id) }}" method="POST" class="hidden">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                            </form>
                                        @elseif($app->status === 'approved' || $app->status === 'diterima')
                                            <span class="text-sm font-bold bg-green-100 text-green-800 px-4 py-2 rounded-full border border-green-200">Diterima</span>
                                        @else
                                            <span class="text-sm font-bold bg-red-100 text-red-800 px-4 py-2 rounded-full border border-red-200">Ditolak</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- ========================================== --}}
            {{-- KOTAK 2: TABEL DATA SISWA (DI BAWAH)       --}}
            {{-- ========================================== --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Data Siswa</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">Kelola data siswa, edit atau hapus sesuai kebutuhan.</p>
                        </div>
                        <div>
                            @if(Route::has('admin.students.create'))
                                <a href="{{ route('admin.students.create') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-md text-sm font-medium shadow">+ Tambah Siswa</a>
                            @else
                                <a href="#" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-md text-sm font-medium cursor-not-allowed" aria-disabled="true">+ Tambah Siswa</a>
                            @endif
                        </div>
                    </div>

                    <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg">
                        <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-200">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th class="px-4 py-3 font-semibold">No</th>
                                    <th class="px-4 py-3 font-semibold">Nama</th>
                                    <th class="px-4 py-3 font-semibold">NIS</th>
                                    <th class="px-4 py-3 font-semibold">Asal Sekolah</th>
                                    <th class="px-4 py-3 font-semibold">Email</th>
                                    <th class="px-4 py-3 font-semibold">Telepon</th>
                                    <th class="px-4 py-3 font-semibold text-center">Status</th>
                                    <th class="px-4 py-3 font-semibold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students ?? $users ?? [] as $index => $student)
                                <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                    <td class="px-4 py-4 align-middle text-gray-800 dark:text-gray-100">{{ $index + 1 }}</td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-200 dark:bg-gray-700 flex-shrink-0">
                                                <img src="{{ $student->image_path ?? ($student->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($student->name).'&background=ddd&color=444') }}" alt="avatar" class="w-full h-full object-cover">
                                            </div>
                                            <div class="font-semibold text-gray-800 dark:text-gray-100 whitespace-nowrap">{{ $student->name }}</div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-gray-800 dark:text-gray-100 whitespace-nowrap">{{ $student->nis ?? $student->id_number ?? '-' }}</td>
                                    <td class="px-4 py-4 text-gray-800 dark:text-gray-100 whitespace-nowrap">{{ $student->school ?? ($student->detail->school ?? '-') }}</td>
                                    <td class="px-4 py-4 text-gray-800 dark:text-gray-100 whitespace-nowrap">{{ $student->email ?? '-' }}</td>
                                    <td class="px-4 py-4 text-gray-800 dark:text-gray-100 whitespace-nowrap">{{ $student->phone ?? $student->phone_number ?? '-' }}</td>
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
                                        <div class="inline-flex items-center space-x-2">
                                            @if(Route::has('admin.students.edit'))
                                                <a href="{{ route('admin.students.edit', $student->id) }}" class="inline-flex items-center px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-medium rounded shadow">Edit</a>
                                            @else
                                                <a href="#" class="inline-flex items-center px-3 py-1.5 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200 text-xs font-medium rounded cursor-not-allowed">Edit</a>
                                            @endif

                                            @if(Route::has('admin.students.destroy'))
                                                <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Hapus data siswa ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded shadow">Hapus</button>
                                                </form>
                                            @else
                                                <button type="button" class="inline-flex items-center px-3 py-1.5 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200 text-xs font-medium rounded cursor-not-allowed" disabled>Hapus</button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-12 text-center text-gray-500 dark:text-gray-300">
                                        Tidak ada data siswa.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>