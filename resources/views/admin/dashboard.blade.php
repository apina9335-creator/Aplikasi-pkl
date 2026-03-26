<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Notifikasi Sukses --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            {{-- ========================================== --}}
            {{-- KOTAK 1: LAMARAN TERBARU (DIPISAH DI ATAS) --}}
            {{-- ========================================== --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{-- Header KOTAK 1 (Judul & Tombol Export) --}}
                    <div class="flex items-center justify-between mb-4 border-b pb-4">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Lamaran Terbaru</h2>
                        
                        {{-- TOMBOL EXPORT EXCEL --}}
                        <a href="{{ route('admin.applications.export') }}" class="inline-flex items-center bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded shadow transition duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Download Excel (CSV)
                        </a>
                    </div>
                    
                    {{-- Isi Daftar Lamaran --}}
                    @if($recentApplications->isEmpty())
                        <p class="text-sm text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg text-center border border-dashed">Belum ada lamaran masuk terbaru.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($recentApplications as $app)
                                <div class="flex flex-col md:flex-row md:items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow-sm hover:shadow transition duration-150">
                                    <div class="mb-3 md:mb-0">
                                        <div class="font-bold text-lg text-gray-800 dark:text-gray-100">
                                            {{ $app->user->name ?? '—' }} 
                                            <span class="text-sm font-normal text-gray-500 bg-gray-200 px-2 py-0.5 rounded ml-2">{{ strtoupper($app->registration_type ?? 'INDIVIDU') }}</span>
                                        </div>
                                        <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                            Sekolah: <span class="font-medium">{{ $app->school ?? '—' }}</span>
                                        </div>
                                        @if($app->registration_type === 'kelompok' && !empty($app->group_members))
                                            <div class="text-sm text-blue-600 dark:text-blue-400 mt-1">
                                                Anggota: {{ $app->group_members }}
                                            </div>
                                        @endif
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                            <span class="font-semibold">{{ $app->company->name ?? 'PT Global Intermedia' }}</span> — Diajukan: {{ $app->applied_at ? $app->applied_at->format('d M Y') : '' }}
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        @if($app->status === 'pending' || $app->status === 'menunggu')
                                            <form action="{{ route('admin.applications.update', $app->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" onclick="return confirm('Yakin ingin menerima lamaran ini?')" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded shadow transition duration-150">Terima</button>
                                            </form>
                                            
                                            <form action="{{ route('admin.applications.update', $app->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" onclick="return confirm('Yakin ingin menolak lamaran ini?')" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded shadow transition duration-150">Tolak</button>
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