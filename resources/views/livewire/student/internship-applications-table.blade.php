<div>
    <div class="flex items-center justify-between mb-4">
        <input wire:model.debounce.500ms="search" type="text" placeholder="Cari sekolah, perusahaan, motivasi..." class="border rounded px-3 py-2 text-sm w-2/3 dark:bg-gray-700 dark:text-gray-200">
        <div class="flex items-center space-x-2">
            <select wire:model="perPage" class="border rounded px-2 py-1 text-sm dark:bg-gray-700 dark:text-gray-200">
                <option value="5">5 / halaman</option>
                <option value="10">10 / halaman</option>
                <option value="25">25 / halaman</option>
            </select>
        </div>
    </div>

    <div class="space-y-4">
        @forelse($applications as $app)
            <div class="bg-white dark:bg-gray-800 dark:text-gray-200 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <div class="p-6 flex flex-col md:flex-row justify-between items-start">
                    <div class="flex-1 mb-4 md:mb-0">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                {{ $app->company->name ?? 'PT Global Intermedia' }}
                            </h3>
                            <span class="inline-block px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wide
                                @if ($app->status === 'pending')
                                    bg-yellow-100 text-yellow-800
                                @elseif ($app->status === 'approved')
                                    bg-green-100 text-green-800
                                @else
                                    bg-red-100 text-red-800
                                @endif
                            ">
                                {{ ucfirst($app->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Diajukan: {{ $app->created_at->format('d M Y') }}</p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        @if($app->cv_path)
                            <a href="{{ Storage::url($app->cv_path) }}" target="_blank" class="px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600 transition text-sm">📄 File</a>
                        @endif

                        <a href="{{ route('student.internship-applications.show', $app->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition text-sm">Detail</a>

                        @if ($app->status === 'pending')
                            <a href="{{ route('student.internship-applications.edit', $app->id) }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition text-sm">Edit</a>
                            <form action="{{ route('student.internship-applications.destroy', $app->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition text-sm" onclick="return confirm('Yakin ingin membatalkan aplikasi ini?')">Batal</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 text-center text-gray-500 dark:text-gray-300">Belum ada lamaran PKL yang diajukan.</div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $applications->links() }}
    </div>
</div>