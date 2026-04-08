<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="bg-green-100 dark:bg-green-900/40 border border-green-400 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            {{-- KOTAK STATISTIK (Hanya ini yang tersisa di Dashboard) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                    <div class="p-3 bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pelamar</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_pelamar'] ?? 0 }}</h3>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                    <div class="p-3 bg-yellow-100 dark:bg-yellow-900/40 text-yellow-600 dark:text-yellow-400 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Menunggu Review</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['pending'] ?? 0 }}</h3>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                    <div class="p-3 bg-green-100 dark:bg-green-900/40 text-green-600 dark:text-green-400 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">PKL Diterima</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['diterima'] ?? 0 }}</h3>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                    <div class="p-3 bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-400 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">PKL Ditolak</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['ditolak'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            {{-- Pintasan Navigasi Cepat --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <a href="{{ route('admin.internship-applications.index') }}" class="group bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-200">
                    <h3 class="text-xl font-bold text-white mb-2 group-hover:underline">Kelola Data Lamaran ➔</h3>
                    <p class="text-blue-100">Review, terima, atau tolak aplikasi PKL mahasiswa terbaru.</p>
                </a>
                
                <a href="{{ route('admin.students.index') }}" class="group bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-200">
                    <h3 class="text-xl font-bold text-white mb-2 group-hover:underline">Kelola Data Siswa ➔</h3>
                    <p class="text-indigo-100">Tambah, edit, atau hapus data siswa yang terdaftar di sistem.</p>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>