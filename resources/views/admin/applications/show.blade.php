<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Review Lamaran Mahasiswa
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block font-medium">
                &larr; Kembali ke Dashboard
            </a>

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-8 border-b border-gray-200">
                    
                    {{-- HEADER: NAMA & STATUS --}}
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ $application->user->name }}</h1>
                            <p class="text-gray-500 text-lg">{{ $application->user->email }}</p>
                        </div>
                        
                        @if($application->status == 'pending')
                            <span class="bg-yellow-100 text-yellow-800 px-6 py-2 rounded-full font-bold text-sm uppercase tracking-wide border border-yellow-200">
                                ⏳ Menunggu Review
                            </span>
                        @elseif($application->status == 'approved')
                            <span class="bg-green-100 text-green-800 px-6 py-2 rounded-full font-bold text-sm uppercase tracking-wide border border-green-200">
                                ✅ Diterima
                            </span>
                        @else
                            <span class="bg-red-100 text-red-800 px-6 py-2 rounded-full font-bold text-sm uppercase tracking-wide border border-red-200">
                                ❌ Ditolak
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        {{-- KOLOM KIRI: BIODATA --}}
                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-100">
                            <h3 class="font-bold text-xl mb-6 text-gray-800 flex items-center">
                                👤 Biodata & Sekolah
                            </h3>
                            
                            <div class="space-y-5">
                                <div>
                                    <label class="text-xs text-gray-400 uppercase font-bold tracking-wider">Asal Sekolah / Kampus</label>
                                    {{-- PERBAIKAN: Pakai $application->school --}}
                                    <p class="text-gray-800 font-bold text-lg">{{ $application->school ?? '-' }}</p>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-xs text-gray-400 uppercase font-bold tracking-wider">NIM / NIS</label>
                                        <p class="text-gray-800 font-medium">{{ $application->user->nim ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-400 uppercase font-bold tracking-wider">No. WhatsApp</label>
                                        <p class="text-gray-800 font-medium">{{ $application->user->phone ?? '-' }}</p>
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-gray-200">
                                    <label class="text-xs text-gray-400 uppercase font-bold tracking-wider">Rencana Periode Magang</label>
                                    <p class="text-indigo-600 font-bold text-lg mt-1">
                                        @if($application->start_date && $application->end_date)
                                            {{ \Carbon\Carbon::parse($application->start_date)->format('d M Y') }} 
                                            <span class="text-gray-400 mx-1">-</span> 
                                            {{ \Carbon\Carbon::parse($application->end_date)->format('d M Y') }}
                                        @else
                                            <span class="text-gray-400 italic">Belum ditentukan</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- KOLOM KANAN: DETAIL LAMARAN --}}
                        <div>
                            <h3 class="font-bold text-xl mb-6 text-gray-800 flex items-center">
                                📄 Detail Lamaran
                            </h3>
                            
                            <div class="mb-6">
                                <label class="text-xs text-gray-400 uppercase font-bold tracking-wider">Tanggal Melamar</label>
                                <p class="text-gray-800 font-medium">{{ $application->created_at->format('d F Y, H:i') }} WIB</p>
                            </div>

                            <div class="mb-6">
                                <label class="text-xs text-gray-400 uppercase font-bold tracking-wider">Motivasi Magang</label>
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 text-gray-700 italic mt-2 leading-relaxed">
                                    "{{ $application->motivation }}"
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="text-xs text-gray-400 uppercase font-bold tracking-wider">File Lampiran (CV)</label>
                                <div class="mt-3">
                                    <a href="{{ Storage::url($application->cv_path) }}" target="_blank" 
                                       class="flex items-center justify-center w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-lg font-semibold text-blue-700 hover:bg-blue-100 transition gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Download / Lihat CV
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TOMBOL AKSI (Hanya muncul jika Pending) --}}
                    @if($application->status == 'pending')
                    <div class="mt-10 border-t pt-8 flex gap-4 justify-end bg-gray-50 -mx-8 -mb-8 p-8 rounded-b-lg">
                        
                        <form action="{{ route('admin.applications.update', $application->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak lamaran ini?');">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="bg-white border border-red-300 text-red-600 hover:bg-red-50 font-bold py-3 px-6 rounded-lg transition shadow-sm">
                                &times; Tolak Lamaran
                            </button>
                        </form>

                        <form action="{{ route('admin.applications.update', $application->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menerima mahasiswa ini?');">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                &check; Terima Mahasiswa
                            </button>
                        </form>

                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>