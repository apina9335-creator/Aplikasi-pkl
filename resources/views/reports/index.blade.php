<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Riwayat Laporan</h2></x-slot>
    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white p-6 rounded shadow">
        <ul class="list-disc pl-5">
            @forelse($reports as $report)
                <li class="mb-2"><b>{{ $report->activity_date }}:</b> {{ $report->description }}</li>
            @empty <p>Belum ada laporan.</p>
            @endforelse
        </ul>
    </div></div>
</x-app-layout>