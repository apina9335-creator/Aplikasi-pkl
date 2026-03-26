@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        
        <div class="mb-6">
            <a href="{{ route('advisor.student-activity.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                &larr; Kembali ke Daftar Siswa
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6 border-l-4 border-blue-600">
            <h1 class="text-3xl font-bold text-gray-900">{{ $student->name }}</h1>
            <p class="text-gray-600 mt-1">{{ $student->email }}</p>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-md p-4 text-center border-b-4 border-green-500">
                <p class="text-sm text-gray-500 font-semibold uppercase tracking-wider">Status PKL</p>
                <p class="text-2xl font-bold text-gray-900 mt-2">
                    @if ($activityStats['in_internship'])
                        <span class="text-green-600 flex items-center justify-center gap-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Aktif
                        </span>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4 text-center border-b-4 border-blue-500">
                <p class="text-sm text-gray-500 font-semibold uppercase tracking-wider">Sesi Bimbingan</p>
                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $activityStats['total_guidance'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4 text-center border-b-4 border-purple-500">
                <p class="text-sm text-gray-500 font-semibold uppercase tracking-wider">Laporan Dibuat</p>
                <p class="text-3xl font-bold text-purple-600 mt-2">{{ $activityStats['total_reports'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4 text-center border-b-4 border-gray-500">
                <p class="text-sm text-gray-500 font-semibold uppercase tracking-wider">Terakhir Aktif</p>
                <p class="text-sm font-bold text-gray-800 mt-3">
                    @php
                        $lastActive = $activityStats['last_report'] ?? $activityStats['last_guidance'];
                        echo $lastActive ? $lastActive->diffForHumans() : 'Belum ada aktivitas';
                    @endphp
                </p>
            </div>
        </div>

        @if ($internship)
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Detail Informasi PKL</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Perusahaan Tempat PKL</p>
                        <p class="font-semibold text-gray-900 text-lg">{{ $internship->company->name ?? 'Belum ditentukan' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Posisi / Bagian</p>
                        <p class="font-semibold text-gray-900 text-lg">{{ $internship->position ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Tanggal Mulai</p>
                        <p class="font-medium text-gray-900">{{ $internship->start_date?->format('d F Y') ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Tanggal Selesai</p>
                        <p class="font-medium text-gray-900">{{ $internship->end_date?->format('d F Y') ?? '-' }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Sesi Bimbingan Terbaru</h2>
            @if ($guidanceSessions && $guidanceSessions->count() > 0)
                <div class="space-y-4 mt-4">
                    @foreach ($guidanceSessions as $session)
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-bold text-gray-900">{{ $session->topic ?? 'Topik tidak tersedia' }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $session->created_at->format('d F Y • H:i') }} WIB</p>
                                </div>
                            </div>
                            @if ($session->notes)
                                <p class="text-sm text-gray-700 mt-2 bg-white p-3 rounded border border-blue-100">{{ $session->notes }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                    <p class="text-gray-500 italic">Belum ada catatan sesi bimbingan untuk siswa ini.</p>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <h2 class="text-xl font-bold text-gray-900">Laporan Aktivitas Harian</h2>
                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded font-bold">{{ $reports ? $reports->count() : 0 }} Total Laporan</span>
            </div>

            @if ($reports && $reports->count() > 0)
                <div class="space-y-4 mt-4">
                    @foreach ($reports as $report)
                        <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg hover:shadow-md transition">
                            
                            <div class="mb-3">
                                <p class="font-bold text-gray-900 text-lg">
                                    {{ \Carbon\Carbon::parse($report->activity_date)->translatedFormat('l, d F Y') }}
                                </p>
                                <p class="text-gray-700 mt-2 text-sm">{{ $report->description }}</p>
                            </div>
                            
                            @if($report->image_path)
                                <div class="mb-4">
                                    <a href="{{ asset('storage/' . $report->image_path) }}" target="_blank" class="text-blue-600 text-sm hover:underline flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                        Lihat Foto Lampiran
                                    </a>
                                </div>
                            @endif

                            <hr class="border-gray-200 my-3">

                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-full
                                        @if (in_array($report->status, ['pending', null]))
                                            bg-yellow-100 text-yellow-700 border border-yellow-200
                                        @elseif ($report->status === 'submitted')
                                            bg-blue-100 text-blue-700 border border-blue-200
                                        @elseif ($report->status === 'approved')
                                            bg-green-100 text-green-700 border border-green-200
                                        @elseif ($report->status === 'rejected')
                                            bg-red-100 text-red-700 border border-red-200
                                        @endif
                                    ">
                                        {{ strtoupper($report->status ?? 'PENDING') }}
                                    </span>
                                </div>

                                @if(in_array($report->status, ['pending', 'submitted', null]))
                                    <div class="flex space-x-2">
                                        <form action="{{ route('advisor.reports.update-status', $report->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" onclick="return confirm('Yakin ingin MENYETUJUI laporan ini?')" class="bg-green-500 hover:bg-green-600 text-white font-bold text-xs px-4 py-2 rounded shadow transition flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Setujui
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('advisor.reports.update-status', $report->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" onclick="return confirm('Yakin ingin MENOLAK laporan ini?')" class="bg-red-500 hover:bg-red-600 text-white font-bold text-xs px-4 py-2 rounded shadow transition flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 bg-gray-50 rounded-lg border border-dashed border-gray-300 mt-4">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                    <p class="mt-2 text-sm font-medium text-gray-900">Belum ada laporan harian</p>
                    <p class="mt-1 text-sm text-gray-500">Mahasiswa ini belum mengirimkan laporan apapun.</p>
                </div>
            @endif
        </div>
        
    </div>
</div>
@endsection