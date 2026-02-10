<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Monitoring Siswa: ') }} {{ $internship->user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Tombol Kembali --}}
            <div class="mb-6">
                <a href="{{ route('advisor.dashboard') }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Dashboard
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- KARTU PROFIL SISWA --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 h-fit">
                    <div class="text-center mb-4">
                        <div class="h-20 w-20 bg-gray-200 rounded-full flex items-center justify-center mx-auto text-2xl font-bold text-gray-500 mb-2">
                            {{ substr($internship->user->name, 0, 1) }}
                        </div>
                        <h3 class="font-bold text-lg">{{ $internship->user->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $internship->user->email }}</p>
                    </div>
                    <div class="border-t pt-4 space-y-2 text-sm">
                        <div>
                            <span class="text-gray-500 block">Asal Sekolah:</span>
                            <span class="font-semibold">{{ $internship->school }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block">Tanggal Mulai:</span>
                            <span class="font-semibold">{{ \Carbon\Carbon::parse($internship->start_date)->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- DAFTAR LAPORAN HARIAN --}}
                <div class="md:col-span-2 space-y-4">
                    <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Logbook / Laporan Harian
                    </h3>

                    @forelse($reports as $report)
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-bold text-gray-800 text-lg">
                                    {{ \Carbon\Carbon::parse($report->activity_date)->format('d F Y') }}
                                </h4>
                                <span class="text-xs text-gray-400">
                                    Diinput: {{ $report->created_at->diffForHumans() }}
                                </span>
                            </div>
                            
                            <p class="text-gray-600 leading-relaxed mb-4 whitespace-pre-wrap">{{ $report->description }}</p>

                            {{-- INI BAGIAN PENTING: MENAMPILKAN FOTO --}}
                            @if($report->image_path)
                                <div class="mt-3">
                                    <p class="text-xs text-gray-400 mb-1 font-bold">Dokumentasi:</p>
                                    <a href="{{ Storage::url($report->image_path) }}" target="_blank">
                                        <img src="{{ Storage::url($report->image_path) }}" 
                                             alt="Bukti Kegiatan" 
                                             class="h-32 w-auto rounded-lg border border-gray-200 hover:opacity-90 transition cursor-zoom-in">
                                    </a>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="bg-white p-8 rounded-lg shadow-sm text-center text-gray-500">
                            <p>Belum ada laporan kegiatan yang diisi.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>