<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Tulis Laporan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl p-8 border border-gray-100 dark:border-gray-700">
                
                {{-- Header --}}
                <div class="flex justify-between items-center mb-6 border-b border-gray-100 dark:border-gray-700 pb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Formulir Kegiatan Harian</h3>
                    <a href="{{ route('student.reports.index') }}" class="text-sm font-semibold text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Batal
                    </a>
                </div>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/30 text-red-600 dark:text-red-400 text-sm rounded-xl">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('student.reports.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Tanggal Kegiatan <span class="text-red-500">*</span></label>
                        <input type="date" name="activity_date" value="{{ old('activity_date', date('Y-m-d')) }}" 
                               class="w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors" required>
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Deskripsi Kegiatan <span class="text-red-500">*</span></label>
                        <textarea name="description" rows="5" 
                                  class="w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors" 
                                  placeholder="Ceritakan detail pekerjaan atau kegiatan yang Anda lakukan hari ini..." required>{{ old('description') }}</textarea>
                    </div>

                    {{-- KOTAK UPLOAD FOTO CANGGIH --}}
                    <div class="mb-8">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Foto Dokumentasi (Opsional)</label>
                        
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all relative group">
                            <div class="space-y-2 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                                    <label for="photo" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-bold text-blue-600 dark:text-blue-400 hover:text-blue-500 focus-within:outline-none transition-colors">
                                        <span>Pilih File Foto</span>
                                        {{-- Input File Disembunyikan, tapi fungsinya tetap jalan lewat Javascript --}}
                                        <input id="photo" name="photo" type="file" accept="image/*" class="sr-only" onchange="previewImage(event, 'preview-create', 'filename-create')">
                                    </label>
                                </div>
                                {{-- Tempat Nama File Muncul --}}
                                <p id="filename-create" class="text-xs text-gray-500 dark:text-gray-400 font-medium">PNG, JPG, JPEG maksimal 2MB</p>
                            </div>
                        </div>

                        {{-- Tempat Live Preview Foto Muncul --}}
                        <div class="mt-4 flex justify-center">
                            <img id="preview-create" src="#" alt="Preview" class="hidden max-h-56 w-auto object-cover rounded-xl shadow-md border border-gray-200 dark:border-gray-700">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl hover:bg-blue-700 font-bold shadow-md hover:-translate-y-0.5 transition-all">
                        Simpan Laporan Harian
                    </button>
                </form>

            </div>
        </div>
    </div>

    {{-- SCRIPT UNTUK MEMUNCULKAN NAMA & GAMBAR --}}
    <script>
        function previewImage(event, previewId, nameId) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Ubah teks menjadi nama file
                const nameLabel = document.getElementById(nameId);
                nameLabel.textContent = '✅ File Terpilih: ' + file.name;
                nameLabel.classList.add('text-green-600', 'dark:text-green-400');
                
                // Proses Live Preview Gambar
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById(previewId);
                    img.src = e.target.result;
                    img.classList.remove('hidden'); // Munculkan gambarnya
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-app-layout>