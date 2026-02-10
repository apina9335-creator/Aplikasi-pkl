<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tulis Laporan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                {{-- Header --}}
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold">Formulir Kegiatan Harian</h3>
                    <a href="{{ route('student.reports.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Batal</a>
                </div>

                @if ($errors->any())
                    <div class="mb-4 text-red-600 text-sm">
                        <ul>@foreach ($errors->all() as $error) <li>• {{ $error }}</li> @endforeach</ul>
                    </div>
                @endif

                <form action="{{ route('student.reports.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Kegiatan</label>
                        <input type="date" name="activity_date" value="{{ old('activity_date', date('Y-m-d')) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                        <textarea name="description" rows="5" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500" placeholder="Apa yang Anda kerjakan hari ini?" required>{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Foto Dokumentasi (Opsional)</label>
                        <input type="file" name="photo" accept="image/*" class="w-full border p-2 rounded bg-gray-50">
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 font-bold">Simpan Laporan</button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>