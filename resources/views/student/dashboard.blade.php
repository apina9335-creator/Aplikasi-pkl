<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- STATUS LAMARAN --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Status PKL Anda</h3>

                    @if(!$application)
                        {{-- KONDISI 1: BELUM DAFTAR --}}
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                            <p class="text-blue-700">Anda belum mendaftar PKL.</p>
                            <a href="{{ route('student.internship-applications.index') }}" class="mt-2 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Daftar Sekarang
                            </a>
                        </div>

                    @elseif($application->status == 'pending')
                        {{-- KONDISI 2: SUDAH DAFTAR, TAPI MASIH PENDING --}}
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 flex items-center">
                            <div class="mr-3">
                                <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="font-bold text-yellow-700">Menunggu Persetujuan Admin</p>
                                <p class="text-sm text-yellow-600">Lamaran Anda sedang direview. Fitur laporan harian akan terbuka setelah Anda diterima.</p>
                            </div>
                        </div>

                    @elseif($application->status == 'rejected')
                        {{-- KONDISI 3: DITOLAK --}}
                        <div class="bg-red-50 border-l-4 border-red-500 p-4">
                            <p class="font-bold text-red-700">Mohon Maaf, Lamaran Ditolak</p>
                            <p class="text-sm text-red-600">Silakan hubungi admin atau ajukan ulang.</p>
                        </div>

                    @elseif($application->status == 'approved')
                        {{-- KONDISI 4: DITERIMA (FITUR BARU MUNCUL DISINI!) --}}
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 flex justify-between items-center">
                            <div>
                                <p class="font-bold text-green-700">Selamat! Anda Diterima PKL 🎉</p>
                                <p class="text-sm text-green-600">Silakan isi laporan kegiatan harian Anda di bawah ini.</p>
                            </div>
                        </div>

                        {{-- === FITUR LAPORAN HARIAN (HANYA MUNCUL JIKA APPROVED) === --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="bg-white border rounded-lg p-6 shadow-md">
                                <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                                    📝 Input Kegiatan Hari Ini
                                </h4>
                                
                                {{-- PERUBAHAN 1: Tambah enctype="multipart/form-data" --}}
                                <form action="{{ route('student.reports.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <div class="mb-4">
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal</label>
                                        <input type="date" name="activity_date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Kegiatan</label>
                                        <textarea name="description" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: Memperbaiki bug pada fitur login..." required></textarea>
                                    </div>

                                    {{-- PERUBAHAN 2: Input Foto Baru --}}
                                    <div class="mb-6">
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Bukti Foto (Opsional)</label>
                                        <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-gray-500
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-full file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-blue-50 file:text-blue-700
                                            hover:file:bg-blue-100
                                        "/>
                                        <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG. Maks: 2MB.</p>
                                    </div>

                                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition">
                                        Simpan Laporan
                                    </button>
                                </form>
                            </div>

                            <div class="bg-blue-600 border rounded-lg p-6 shadow-md text-white flex flex-col justify-center items-center text-center">
                                <svg class="w-16 h-16 mb-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                <h4 class="text-xl font-bold mb-2">Riwayat Laporan</h4>
                                <p class="mb-6 text-blue-100">Lihat semua catatan kegiatan yang sudah Anda kumpulkan selama PKL.</p>
                                <a href="{{ route('student.reports.index') }}" class="bg-white text-blue-600 font-bold py-2 px-6 rounded-full hover:bg-gray-100 transition">
                                    Lihat Semua Laporan
                                </a>
                            </div>

                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>