@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Edit Lamaran PKL</h1>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('student.internship-applications.update', $application->id) }}" 
              method="POST" 
              enctype="multipart/form-data"
              class="bg-white rounded-lg shadow-md p-8">
            
            @csrf
            @method('PUT') <div class="mb-6">
                <label for="company_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Pilih Perusahaan PKL <span class="text-red-500">*</span>
                </label>
                <select name="company_id" id="company_id" required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">-- Pilih Perusahaan --</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" 
                            {{-- Cek apakah ID perusahaan sama dengan data lama atau input sebelumnya --}}
                            {{ (old('company_id', $application->company_id) == $company->id) ? 'selected' : '' }}>
                            {{ $company->name }} - {{ $company->city }}
                        </option>
                    @endforeach
                </select>
                @error('company_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="motivation" class="block text-sm font-medium text-gray-700 mb-2">
                    Motivasi & Alasan <span class="text-red-500">*</span>
                </label>
                {{-- Isi textarea dengan data lama ($application->motivation) --}}
                <textarea name="motivation" id="motivation" rows="6" required 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('motivation', $application->motivation) }}</textarea>
                @error('motivation')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="attachment" class="block text-sm font-medium text-gray-700 mb-2">
                    Update File Lampiran (Opsional)
                </label>
                
                @if($application->attachment_path)
                    <div class="mb-2 text-sm text-blue-600">
                        File saat ini: <a href="{{ Storage::url($application->attachment_path) }}" target="_blank" class="underline">Lihat File</a>
                    </div>
                @endif

                <input type="file" name="attachment" id="attachment" 
                       accept=".pdf,.doc,.docx"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah file.</p>
                @error('attachment')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Simpan Perubahan
                </button>
                <a href="{{ route('student.internship-applications.index') }}" 
                   class="flex-1 px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection