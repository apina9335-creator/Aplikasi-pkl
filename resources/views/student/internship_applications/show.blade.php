<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Lamaran PKL') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Tombol Kembali --}}
            <a href="{{ route('student.internship-applications.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-flex items-center font-medium transition">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar
            </a>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-blue-500">
                <div class="p-8">
                    
                    {{-- Header Lamaran --}}
                    <div class="flex justify-between items-start mb-8 border-b pb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $application->company->name ?? 'PT Global Intermedia' }}</h3>
                            <p class="text-gray-500 mt-1">Diajukan pada: {{ $application->created_at->format('d F Y') }}</p>
                        </div>
                        
                        {{-- Badge Status --}}
                        <div class="flex flex-col items-end">
                            <span class="px-4 py-2 rounded-full text-sm font-bold uppercase tracking-wider
                                @if($application->status == 'approved') bg-green-100 text-green-800 border border-green-200
                                @elseif($application->status == 'rejected') bg-red-100 text-red-800 border border-red-200
                                @else bg-yellow-100 text-yellow-800 border border-yellow-200 @endif">
                                {{ ucfirst($application->status) }}
                            </span>
                        </div>
                    </div>

                    {{-- Isi Detail --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        
                        {{-- Kolom Kiri: Detail Waktu & Sekolah --}}
                        <div class="col-span-1 space-y-6">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wide">Asal Sekolah</label>
                                <p class="text-gray-800 font-medium text-lg">{{ $application->school ?? '-' }}</p>
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wide">Periode Magang</label>
                                @if($application->start_date && $application->end_date)
                                    <p class="text-gray-800 font-medium">
                                        {{ \Carbon\Carbon::parse($application->start_date)->format('d M Y') }} 
                                        <br><span class="text-gray-400 text-sm">sampai</span><br>
                                        {{ \Carbon\Carbon::parse($application->end_date)->format('d M Y') }}
                                    </p>
                                @else
                                    <p class="text-gray-400 italic">-</p>
                                @endif
                            </div>
                        </div>

                        {{-- Kolom Kanan: Motivasi & File --}}
                        <div class="col-span-1 md:col-span-2 space-y-6">
                            
                            {{-- Motivasi --}}
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wide">Motivasi Magang</label>
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 mt-2 text-gray-700 leading-relaxed italic">
                                    "{{ $application->motivation }}"
                                </div>
                            </div>

                            {{-- FILE PDF (INI YANG PENTING) --}}
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wide">Lampiran (CV/Proposal)</label>
                                <div class="mt-2">
                                    {{-- Cek apakah file ada (Support nama kolom cv_path atau attachment_path) --}}
                                    @php
                                        $filePath = $application->cv_path ?? $application->attachment_path;
                                    @endphp

                                    @if($filePath)
                                        <a href="{{ Storage::url($filePath) }}" target="_blank" 
                                           class="inline-flex items-center px-5 py-3 bg-indigo-50 text-indigo-700 rounded-lg border border-indigo-200 hover:bg-indigo-100 transition font-semibold group">
                                            <svg class="w-6 h-6 mr-3 text-indigo-500 group-hover:text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            <div>
                                                <span class="block text-sm">Download / Lihat File</span>
                                                <span class="block text-xs text-indigo-400 font-normal">Klik untuk membuka PDF</span>
                                            </div>
                                        </a>
                                    @else
                                        <div class="flex items-center text-red-500 bg-red-50 p-3 rounded border border-red-100">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span class="text-sm">Tidak ada lampiran file.</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                    
                    {{-- Footer Tombol Edit (Hanya jika Pending) --}}
                    @if($application->status == 'pending')
                    <div class="mt-8 border-t pt-6 flex justify-end">
                        <a href="{{ route('student.internship-applications.edit', $application->id) }}" 
                           class="bg-gray-800 text-white px-6 py-2 rounded hover:bg-gray-900 transition font-bold shadow-lg">
                            Edit Lamaran
                        </a>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>