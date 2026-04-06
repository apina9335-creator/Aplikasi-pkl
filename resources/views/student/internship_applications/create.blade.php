@extends('layouts.app')

@section('content')
<div class="min-h-[calc(100vh-5rem)] bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/40 dark:from-gray-950 dark:via-gray-900 dark:to-gray-950 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">

        {{-- Header --}}
        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 shadow-lg shadow-blue-500/25 mb-4">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                </svg>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Pendaftaran PKL Baru</h1>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Lengkapi formulir berikut untuk mengajukan permohonan magang</p>
        </div>

        {{-- Tampilkan Error Validasi --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/50 rounded-xl">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-red-100 dark:bg-red-800/40 flex items-center justify-center mt-0.5">
                        <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-red-800 dark:text-red-300 mb-1">Terjadi kesalahan pada formulir</p>
                        <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-400 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Form Card --}}
        <form action="{{ route('student.internship-applications.store') }}" 
              method="POST" 
              enctype="multipart/form-data"
              class="bg-white dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-xl shadow-gray-900/5 dark:shadow-black/20 border border-gray-100 dark:border-gray-700/50 overflow-hidden">

            @csrf

            {{-- Section 1: Perusahaan --}}
            <div class="px-6 sm:px-8 pt-8 pb-6 border-b border-gray-100 dark:border-gray-700/50">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                        </svg>
                    </div>
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Perusahaan Tujuan</h2>
                </div>
                <div class="flex items-center gap-4 p-4 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-100 dark:border-blue-800/30">
                    <div class="flex-shrink-0 w-11 h-11 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow-md shadow-blue-500/20">
                        <span class="text-white font-extrabold text-sm">GI</span>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-white">PT Global Intermedia</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Lokasi magang sudah ditentukan</p>
                    </div>
                    <div class="ml-auto flex-shrink-0">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-xs font-medium">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Tetap
                        </span>
                    </div>
                </div>
            </div>

            {{-- Section 2: Data Diri --}}
            <div class="px-6 sm:px-8 py-6 border-b border-gray-100 dark:border-gray-700/50">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 rounded-lg bg-violet-50 dark:bg-violet-900/30 flex items-center justify-center">
                        <svg class="w-4 h-4 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm-1.875 3.75a3.375 3.375 0 00-3.375 3.375h6.75a3.375 3.375 0 00-3.375-3.375z"/>
                        </svg>
                    </div>
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Data Pendaftar</h2>
                </div>

                <div class="space-y-5">
                    {{-- Asal Sekolah --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Asal Sekolah / Kampus <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342"/>
                                </svg>
                            </div>
                            <input type="text" name="school" 
                                   value="{{ old('school', Auth::user()->school) }}"
                                   class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 text-sm transition-all duration-200 focus:bg-white dark:focus:bg-gray-700 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none" 
                                   placeholder="Contoh: SMK Negeri 1 Yogyakarta" required>
                        </div>
                    </div>

                    {{-- Tipe Pendaftaran --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tipe Pendaftaran <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            
                            {{-- TOMBOL INDIVIDU --}}
                            <button type="button" id="btn_individu" class="group relative cursor-pointer focus:outline-none text-left w-full">
                                <div class="wrapper-box flex items-center gap-3 p-3.5 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 transition-all duration-200 hover:border-blue-300 dark:hover:border-blue-500">
                                    <div class="outer-circle w-5 h-5 rounded-full border-2 border-gray-300 dark:border-gray-500 flex items-center justify-center transition-all">
                                        <div class="inner-circle w-2.5 h-2.5 rounded-full bg-blue-600 transition-all duration-200 scale-0"></div>
                                    </div>
                                    <svg class="icon-svg w-5 h-5 text-gray-400 dark:text-gray-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                    </svg>
                                    <span class="text-span text-sm font-medium text-gray-700 dark:text-gray-300 transition-colors">Individu</span>
                                </div>
                                <input type="radio" name="registration_type" id="radio_individu" value="individu" class="hidden" {{ old('registration_type', 'individu') == 'individu' ? 'checked' : '' }}>
                            </button>
                            
                            {{-- TOMBOL KELOMPOK --}}
                            <button type="button" id="btn_kelompok" class="group relative cursor-pointer focus:outline-none text-left w-full">
                                <div class="wrapper-box flex items-center gap-3 p-3.5 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 transition-all duration-200 hover:border-blue-300 dark:hover:border-blue-500">
                                    <div class="outer-circle w-5 h-5 rounded-full border-2 border-gray-300 dark:border-gray-500 flex items-center justify-center transition-all">
                                        <div class="inner-circle w-2.5 h-2.5 rounded-full bg-blue-600 transition-all duration-200 scale-0"></div>
                                    </div>
                                    <svg class="icon-svg w-5 h-5 text-gray-400 dark:text-gray-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                                    </svg>
                                    <span class="text-span text-sm font-medium text-gray-700 dark:text-gray-300 transition-colors">Kelompok</span>
                                </div>
                                <input type="radio" name="registration_type" id="radio_kelompok" value="kelompok" class="hidden" {{ old('registration_type') == 'kelompok' ? 'checked' : '' }}>
                            </button>

                        </div>
                    </div>

                    {{-- Anggota Kelompok --}}
                    <div id="group_members_div" style="display: none;">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nama Anggota Kelompok Lainnya
                        </label>
                        <textarea name="group_members" rows="3" 
                                  placeholder="Contoh:&#10;1. Budi Santoso&#10;2. Siti Aminah"
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 text-sm transition-all duration-200 focus:bg-white dark:focus:bg-gray-700 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none resize-none">{{ old('group_members') }}</textarea>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5 pl-1">Biarkan kosong jika Anda mendaftar individu.</p>
                    </div>
                </div>
            </div>

            {{-- Section 3: Jadwal Magang --}}
            <div class="px-6 sm:px-8 py-6 border-b border-gray-100 dark:border-gray-700/50">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center">
                        <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                        </svg>
                    </div>
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Jadwal Magang</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tanggal Mulai <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                                </svg>
                            </div>
                            <input type="date" name="start_date" value="{{ old('start_date') }}" 
                                   class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white text-sm transition-all duration-200 focus:bg-white dark:focus:bg-gray-700 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tanggal Selesai <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <input type="date" name="end_date" value="{{ old('end_date') }}" 
                                   class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white text-sm transition-all duration-200 focus:bg-white dark:focus:bg-gray-700 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none" required>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 4: Motivasi --}}
            <div class="px-6 sm:px-8 py-6 border-b border-gray-100 dark:border-gray-700/50">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 rounded-lg bg-rose-50 dark:bg-rose-900/30 flex items-center justify-center">
                        <svg class="w-4 h-4 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                        </svg>
                    </div>
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Motivasi & Alasan</h2>
                </div>

                <div>
                    <textarea name="motivation" id="motivation" rows="5" required 
                              placeholder="Jelaskan motivasi Anda magang di perusahaan ini..."
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 text-sm transition-all duration-200 focus:bg-white dark:focus:bg-gray-700 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none resize-none">{{ old('motivation') }}</textarea>
                    <div class="flex items-center justify-between mt-1.5 pl-1">
                        <p class="text-xs text-gray-400 dark:text-gray-500">Minimal 50 karakter</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500" id="char_count">0 / 50</p>
                    </div>
                </div>
            </div>

            {{-- Section 5: Upload --}}
            <div class="px-6 sm:px-8 py-6 border-b border-gray-100 dark:border-gray-700/50">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13"/>
                        </svg>
                    </div>
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Dokumen Lampiran</h2>
                </div>

                <div>
                    <input type="file" name="attachment" id="attachment" required accept=".pdf,.doc,.docx" class="hidden">
                    <label for="attachment" id="drop_zone" 
                           class="flex flex-col items-center justify-center gap-3 p-8 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 bg-gray-50/50 dark:bg-gray-700/30 cursor-pointer transition-all duration-200 hover:border-blue-400 hover:bg-blue-50/50 dark:hover:border-blue-500 dark:hover:bg-blue-900/10 group">
                        <div class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center transition-all duration-200 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/40 group-hover:scale-105">
                            <svg class="w-6 h-6 text-gray-400 dark:text-gray-500 transition-colors group-hover:text-blue-500 dark:group-hover:text-blue-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                            </svg>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300" id="file_label">Klik atau seret file ke sini</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">PDF atau DOC, maksimal 2MB</p>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="px-6 sm:px-8 py-6 bg-gray-50/50 dark:bg-gray-800/50">
                <div class="flex flex-col-reverse sm:flex-row gap-3">
                    <a href="{{ route('student.internship-applications.index') }}" 
                       class="flex-1 px-6 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400 font-semibold text-sm text-center hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200">
                        Batal
                    </a>
                    <button type="submit"
                            class="flex-1 flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold text-sm shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/30 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                        </svg>
                        Kirim Lamaran
                    </button>
                </div>
            </div>
        </form>

        <p class="text-center text-xs text-gray-400 dark:text-gray-600 mt-6">Data yang Anda kirim akan ditinjau oleh admin perusahaan</p>
    </div>
</div>

<style>
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        20% { transform: translateX(-6px); }
        40% { transform: translateX(6px); }
        60% { transform: translateX(-4px); }
        80% { transform: translateX(4px); }
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: grayscale(100%);
        opacity: 0.5;
        cursor: pointer;
        transition: all 0.2s;
    }

    input[type="date"]::-webkit-calendar-picker-indicator:hover {
        filter: grayscale(0%);
        opacity: 1;
    }

    .dark input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(100%) grayscale(100%);
        opacity: 0.4;
    }

    .dark input[type="date"]::-webkit-calendar-picker-indicator:hover {
        filter: invert(100%) grayscale(0%);
        opacity: 0.8;
    }
    
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnIndividu = document.getElementById('btn_individu');
        const btnKelompok = document.getElementById('btn_kelompok');
        const radioIndividu = document.getElementById('radio_individu');
        const radioKelompok = document.getElementById('radio_kelompok');
        const groupMembersDiv = document.getElementById('group_members_div');
        
        // JURUS HARDCODE: Suntik class warna biru langsung pakai JS!
        function updateRadioUI(btn, isActive) {
            if (!btn) return;
            
            const wrapper = btn.querySelector('.wrapper-box');
            const outerCircle = btn.querySelector('.outer-circle');
            const innerCircle = btn.querySelector('.inner-circle');
            const iconSvg = btn.querySelector('.icon-svg');
            const textSpan = btn.querySelector('.text-span');

            if (isActive) {
                // Beri warna BIRU (Aktif)
                wrapper.classList.remove('border-gray-200', 'dark:border-gray-600', 'bg-gray-50', 'dark:bg-gray-700/50');
                wrapper.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
                
                outerCircle.classList.remove('border-gray-300', 'dark:border-gray-500');
                outerCircle.classList.add('border-blue-500');
                
                innerCircle.classList.remove('scale-0');
                innerCircle.classList.add('scale-100');
                
                iconSvg.classList.remove('text-gray-400', 'dark:text-gray-500');
                iconSvg.classList.add('text-blue-600', 'dark:text-blue-400');
                
                textSpan.classList.remove('text-gray-700', 'dark:text-gray-300');
                textSpan.classList.add('text-blue-700', 'dark:text-blue-300');
            } else {
                // Kembalikan ke warna ABU-ABU (Tidak Aktif)
                wrapper.classList.add('border-gray-200', 'dark:border-gray-600', 'bg-gray-50', 'dark:bg-gray-700/50');
                wrapper.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
                
                outerCircle.classList.add('border-gray-300', 'dark:border-gray-500');
                outerCircle.classList.remove('border-blue-500');
                
                innerCircle.classList.add('scale-0');
                innerCircle.classList.remove('scale-100');
                
                iconSvg.classList.add('text-gray-400', 'dark:text-gray-500');
                iconSvg.classList.remove('text-blue-600', 'dark:text-blue-400');
                
                textSpan.classList.add('text-gray-700', 'dark:text-gray-300');
                textSpan.classList.remove('text-blue-700', 'dark:text-blue-300');
            }
        }
        
        function toggleGroupMembers(isKelompok) {
            if (isKelompok) {
                groupMembersDiv.style.display = 'block';
                groupMembersDiv.style.animation = 'fadeIn 0.3s ease-in-out';
            } else {
                groupMembersDiv.style.display = 'none';
            }
        }
        
        // Event saat tombol diklik
        if (btnIndividu && radioIndividu) {
            btnIndividu.addEventListener('click', function(e) {
                e.preventDefault();
                radioIndividu.checked = true;
                if (radioKelompok) radioKelompok.checked = false;
                
                updateRadioUI(btnIndividu, true);
                updateRadioUI(btnKelompok, false);
                toggleGroupMembers(false);
            });
        }
        
        if (btnKelompok && radioKelompok) {
            btnKelompok.addEventListener('click', function(e) {
                e.preventDefault();
                radioKelompok.checked = true;
                if (radioIndividu) radioIndividu.checked = false;
                
                updateRadioUI(btnKelompok, true);
                updateRadioUI(btnIndividu, false);
                toggleGroupMembers(true);
            });
        }
        
        // Cek Pilihan Awal
        if (radioKelompok && radioKelompok.checked) {
            updateRadioUI(btnKelompok, true);
            updateRadioUI(btnIndividu, false);
            toggleGroupMembers(true);
        } else {
            if (radioIndividu) radioIndividu.checked = true;
            updateRadioUI(btnIndividu, true);
            updateRadioUI(btnKelompok, false);
            toggleGroupMembers(false);
        }
        
        // Karakter Motivasi
        const motivationEl = document.getElementById('motivation');
        const charCountEl = document.getElementById('char_count');
        if (motivationEl && charCountEl) {
            const updateCharCount = () => {
                const len = motivationEl.value.length;
                charCountEl.textContent = len + ' / 50';
                if (len >= 50) {
                    charCountEl.classList.remove('text-gray-400', 'dark:text-gray-500');
                    charCountEl.classList.add('text-emerald-500', 'dark:text-emerald-400');
                } else {
                    charCountEl.classList.remove('text-emerald-500', 'dark:text-emerald-400');
                    charCountEl.classList.add('text-gray-400', 'dark:text-gray-500');
                }
            };
            motivationEl.addEventListener('input', updateCharCount);
            updateCharCount();
        }
        
        // Upload Drag & Drop
        function handleFileSelect(input) {
            const label = document.getElementById('file_label');
            const dropZone = document.getElementById('drop_zone');
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                label.innerHTML = '<span class="font-semibold text-blue-600 dark:text-blue-400">' + file.name + '</span><br><span class="text-xs text-gray-400">' + sizeMB + ' MB</span>';
                dropZone.classList.remove('border-gray-300', 'dark:border-gray-600');
                dropZone.classList.add('border-blue-400', 'dark:border-blue-500', 'bg-blue-50/50', 'dark:bg-blue-900/10');
            } else {
                label.innerHTML = 'Klik atau seret file ke sini';
                dropZone.classList.remove('border-blue-400', 'dark:border-blue-500', 'bg-blue-50/50', 'dark:bg-blue-900/10');
                dropZone.classList.add('border-gray-300', 'dark:border-gray-600');
            }
        }
        
        const fileInput = document.getElementById('attachment');
        if (fileInput) {
            fileInput.addEventListener('change', function() { handleFileSelect(this); });
        }
        
        const dropZone = document.getElementById('drop_zone');
        if (dropZone) {
            ['dragenter', 'dragover'].forEach(evt => {
                dropZone.addEventListener(evt, function(e) {
                    e.preventDefault();
                    this.classList.add('border-blue-400', 'dark:border-blue-500', 'bg-blue-50/50', 'dark:bg-blue-900/10', 'scale-[1.01]');
                });
            });
            ['dragleave', 'drop'].forEach(evt => {
                dropZone.addEventListener(evt, function(e) {
                    e.preventDefault();
                    this.classList.remove('scale-[1.01]');
                });
            });
            dropZone.addEventListener('drop', function(e) {
                e.preventDefault();
                const input = document.getElementById('attachment');
                if (e.dataTransfer.files.length) {
                    input.files = e.dataTransfer.files;
                    handleFileSelect(input);
                }
                this.classList.remove('border-blue-400', 'dark:border-blue-500', 'bg-blue-50/50', 'dark:bg-blue-900/10');
            });
        }
        
        // Animasi
        const style = document.createElement('style');
        style.textContent = `@keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }`;
        document.head.appendChild(style);
    });
</script>
@endsection