@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8 transition-colors duration-300">
    <div class="max-w-6xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Persetujuan Aplikasi PKL</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Kelola pendaftaran PKL dari mahasiswa</p>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/40 border border-green-400 dark:border-green-800 text-green-700 dark:text-green-300 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 flex gap-2">
            <a href="{{ route('admin.internship-applications.index') }}" 
               class="px-4 py-2 bg-blue-500 dark:bg-blue-600 text-white rounded hover:bg-blue-600 dark:hover:bg-blue-700 transition">
                Semua
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden border border-gray-200 dark:border-gray-700 transition-colors duration-300">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 dark:bg-gray-700/50 border-b dark:border-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">Mahasiswa</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">Perusahaan</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">Diajukan</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($applications as $app)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $app->user->name }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $app->user->email }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-300">{{ $app->company->name }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 text-sm font-medium rounded-full border
                                        @if ($app->status === 'pending')
                                            bg-yellow-100 dark:bg-yellow-900/40 text-yellow-800 dark:text-yellow-300 border-yellow-200 dark:border-yellow-800/50
                                        @elseif ($app->status === 'approved')
                                            bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300 border-green-200 dark:border-green-800/50
                                        @else
                                            bg-red-100 dark:bg-red-900/40 text-red-800 dark:text-red-300 border-red-200 dark:border-red-800/50
                                        @endif
                                    ">
                                        {{ ucfirst($app->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $app->applied_at?->format('d M Y') ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.internship-applications.show', $app) }}" 
                                       class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium transition-colors">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-600 dark:text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Tidak ada aplikasi PKL
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8">
            {{ $applications->links() }}
        </div>
    </div>
</div>
@endsection