@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Persetujuan Aplikasi PKL</h1>
            <p class="text-gray-600 mt-2">Kelola pendaftaran PKL dari mahasiswa</p>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filter Status -->
        <div class="mb-6 flex gap-2">
            <a href="{{ route('admin.internship-applications.index') }}" 
               class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Semua
            </a>
        </div>

        <!-- Applications Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Mahasiswa</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Perusahaan</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Diajukan</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($applications as $app)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $app->user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $app->user->email }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-900">{{ $app->company->name }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-3 py-1 text-sm font-medium rounded-full
                                    @if ($app->status === 'pending')
                                        bg-yellow-100 text-yellow-800
                                    @elseif ($app->status === 'approved')
                                        bg-green-100 text-green-800
                                    @else
                                        bg-red-100 text-red-800
                                    @endif
                                ">
                                    {{ ucfirst($app->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $app->applied_at?->format('d M Y') ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.internship-applications.show', $app) }}" 
                                   class="text-blue-600 hover:text-blue-800 font-medium">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-600">
                                Tidak ada aplikasi PKL
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $applications->links() }}
        </div>
    </div>
</div>
@endsection
