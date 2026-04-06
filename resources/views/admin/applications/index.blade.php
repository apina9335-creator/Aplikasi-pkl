<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Data Lamaran PKL Masuk') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 dark:bg-green-900/40 border border-green-400 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-6" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between mb-4 border-b border-gray-200 dark:border-gray-700 pb-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Daftar Lamaran</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola persetujuan lamaran PKL siswa.</p>
                        </div>
                        
                        <a href="{{ route('admin.applications.export') }}" class="inline-flex items-center bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded shadow transition duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Download Excel
                        </a>
                    </div>
                    
                    @if(empty($recentApplications) || $recentApplications->isEmpty())
                        <p class="text-sm text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg text-center border border-dashed border-gray-300 dark:border-gray-600">Belum ada lamaran masuk terbaru.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($recentApplications as $app)
                                <div class="flex flex-col md:flex-row md:items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow-sm hover:shadow transition duration-150">
                                    <div class="mb-3 md:mb-0">
                                        <div class="font-bold text-lg text-gray-800 dark:text-gray-100">
                                            {{ $app->user->name ?? '—' }} 
                                            <span class="text-sm font-normal text-gray-600 dark:text-gray-300 bg-gray-200 dark:bg-gray-600 px-2 py-0.5 rounded ml-2">{{ strtoupper($app->registration_type ?? 'INDIVIDU') }}</span>
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
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" onclick="return confirm('Yakin menerima lamaran ini?')" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded shadow transition">Terima</button>
                                            </form>
                                            <form action="{{ route('admin.applications.update', $app->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" onclick="return confirm('Yakin menolak lamaran ini?')" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded shadow transition">Tolak</button>
                                            </form>
                                        @elseif($app->status === 'approved' || $app->status === 'diterima')
                                            <span class="text-sm font-bold bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300 px-4 py-2 rounded-full border border-green-200 dark:border-green-800/50">Diterima</span>
                                        @else
                                            <span class="text-sm font-bold bg-red-100 dark:bg-red-900/40 text-red-800 dark:text-red-300 px-4 py-2 rounded-full border border-red-200 dark:border-red-800/50">Ditolak</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>