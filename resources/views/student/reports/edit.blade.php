<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold">Edit Kegiatan</h3>
                    <a href="{{ route('student.reports.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Batal</a>
                </div>

                <form action="{{ route('student.reports.update', $report->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Kegiatan</label>
                        <input type="date" name="activity_date" value="{{ old('activity_date', $report->activity_date) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                        <textarea name="description" rows="5" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500" required>{{ old('description', $report->description) }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Foto Dokumentasi</label>
                        
                        @if($report->image_path)
                            <div class="mb-2">
                                <img src="{{ Storage::url($report->image_path) }}" class="h-24 w-auto rounded border">
                                <p class="text-xs text-gray-500">Foto saat ini</p>
                            </div>
                        @endif

                        <input type="file" name="photo" accept="image/*" class="w-full border p-2 rounded bg-gray-50">
                        <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah foto.</p>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 font-bold">Simpan Perubahan</button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>