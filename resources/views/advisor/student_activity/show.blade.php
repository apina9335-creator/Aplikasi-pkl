@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('advisor.student-activity.index') }}" class="text-blue-600 hover:text-blue-800">
                ← Kembali ke Daftar
            </a>
        </div>

        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-900">{{ $student->name }}</h1>
            <p class="text-gray-600 mt-2">{{ $student->email }}</p>
        </div>

        <!-- Activity Stats -->
        <div class="grid grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-sm text-gray-600">Status PKL</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">
                    @if ($activityStats['in_internship'])
                        <span class="text-green-600">✓ Aktif</span>
                    @else
                        <span class="text-gray-600">-</span>
                    @endif
                </p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-sm text-gray-600">Sesi Bimbingan</p>
                <p class="text-2xl font-bold text-blue-600 mt-1">{{ $activityStats['total_guidance'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-sm text-gray-600">Laporan Dibuat</p>
                <p class="text-2xl font-bold text-purple-600 mt-1">{{ $activityStats['total_reports'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-sm text-gray-600">Terakhir Aktif</p>
                <p class="text-sm font-medium text-gray-900 mt-2">
                    @php
                        $lastActive = $activityStats['last_report'] ?? $activityStats['last_guidance'];
                        echo $lastActive ? $lastActive->diffForHumans() : '-';
                    @endphp
                </p>
            </div>
        </div>

        <!-- Internship Information -->
        @if ($internship)
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi PKL</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Perusahaan</p>
                        <p class="font-medium text-gray-900">{{ $internship->company->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Posisi</p>
                        <p class="font-medium text-gray-900">{{ $internship->position ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tanggal Mulai</p>
                        <p class="font-medium text-gray-900">{{ $internship->start_date?->format('d F Y') ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tanggal Selesai</p>
                        <p class="font-medium text-gray-900">{{ $internship->end_date?->format('d F Y') ?? '-' }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Guidance Sessions -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Sesi Bimbingan Terbaru (5)</h2>
            @if ($guidanceSessions && $guidanceSessions->count() > 0)
                <div class="space-y-3">
                    @foreach ($guidanceSessions as $session)
                        <div class="border-l-4 border-blue-500 pl-4 py-2">
                            <p class="font-medium text-gray-900">{{ $session->topic ?? 'Topik tidak tersedia' }}</p>
                            <p class="text-sm text-gray-600">{{ $session->created_at->format('d F Y H:i') }}</p>
                            @if ($session->notes)
                                <p class="text-sm text-gray-700 mt-1">{{ Str::limit($session->notes, 100) }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">Belum ada sesi bimbingan</p>
            @endif
        </div>

        <!-- Reports -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Laporan Terbaru (5)</h2>
            @if ($reports && $reports->count() > 0)
                <div class="space-y-3">
                    @foreach ($reports as $report)
                        <div class="border-l-4 border-purple-500 pl-4 py-2">
                            <p class="font-medium text-gray-900">Laporan Minggu {{ $report->week ?? '-' }}</p>
                            <p class="text-sm text-gray-600">{{ $report->created_at->format('d F Y') }}</p>
                            <div class="mt-2">
                                <span class="inline-block px-2 py-1 text-xs font-medium rounded
                                    @if ($report->status === 'submitted')
                                        bg-blue-100 text-blue-800
                                    @elseif ($report->status === 'approved')
                                        bg-green-100 text-green-800
                                    @else
                                        bg-yellow-100 text-yellow-800
                                    @endif
                                ">
                                    {{ ucfirst($report->status ?? 'pending') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">Belum ada laporan</p>
            @endif
        </div>
    </div>
</div>
@endsection
