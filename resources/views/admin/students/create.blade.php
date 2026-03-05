<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Tambah Siswa') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.students.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 gap-4">
                            <input type="text" name="name" placeholder="Nama" class="border px-3 py-2">
                            <input type="email" name="email" placeholder="Email" class="border px-3 py-2">
                            <input type="text" name="nim" placeholder="NIM" class="border px-3 py-2">
                            <input type="text" name="school" placeholder="Asal Sekolah" class="border px-3 py-2">
                            <input type="text" name="phone" placeholder="Telepon" class="border px-3 py-2">
                            <input type="password" name="password" placeholder="Password" class="border px-3 py-2">
                            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" class="border px-3 py-2">

                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('admin.students.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded">Batal</a>
                                <button class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>