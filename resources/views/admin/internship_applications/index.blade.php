<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Daftar Permohonan PKL') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if(session('success'))
                        <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mb-4 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700 border-b dark:border-gray-600">
                                <tr>
                                    <th class="px-4 py-3">Tgl Daftar</th>
                                    <th class="px-4 py-3">Nama & Email</th>
                                    <th class="px-4 py-3">Asal Sekolah</th>
                                    <th class="px-4 py-3">Tipe</th>
                                    <th class="px-4 py-3 text-center">Status</th>
                                    <th class="px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applications as $app)
                                <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-4 py-4">{{ $app->created_at->format('d M Y') }}</td>
                                    
                                    {{-- PERBAIKAN: Ambil nama & email langsung dari tabel aplikasi --}}
                                    <td class="px-4 py-4">
                                        <div class="font-bold text-gray-800 dark:text-gray-100">{{ $app->name ?? 'Tanpa Nama' }}</div>
                                        <div class="text-xs text-gray-500">{{ $app->email ?? '-' }}</div>
                                    </td>
                                    
                                    <td class="px-4 py-4">{{ $app->school ?? '-' }}</td>
                                    <td class="px-4 py-4 uppercase text-xs font-semibold">{{ $app->registration_type }}</td>
                                    
                                    <td class="px-4 py-4 text-center">
                                        @if($app->status === 'pending')
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-bold">Menunggu</span>
                                        @elseif($app->status === 'approved')
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">Disetujui</span>
                                        @else
                                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-bold">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('admin.internship-applications.show', $app->id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold shadow transition-all">Detail</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada permohonan PKL yang masuk.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $applications->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>