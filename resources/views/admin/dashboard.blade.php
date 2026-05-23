<x-app-layout>
    <div class="min-h-screen bg-zinc-950 text-slate-100 antialiased">
        <x-slot name="header">
            <h2 class="font-black text-2xl text-white leading-tight flex items-center gap-3">
                <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center shadow-[0_0_15px_rgba(220,38,38,0.4)]">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                ADMIN <span class="text-red-600 uppercase tracking-tighter">Command Center</span>
            </h2>
        </x-slot>

        <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">
            
            {{-- 1. GRAFIK UTAMA --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                {{-- Grafik Batang (Tren) --}}
                <div class="lg:col-span-8 bg-zinc-900 border border-zinc-800 rounded-[2rem] p-8 shadow-2xl">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-lg font-black uppercase tracking-[0.2em] text-zinc-400">Analitik Pendaftar</h3>
                        <span class="bg-red-600/10 text-red-500 px-3 py-1 rounded-full text-[10px] font-black border border-red-600/20">6 BULAN TERAKHIR</span>
                    </div>
                    <div class="h-72 w-full">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>

                {{-- Grafik Donat (Tipe) --}}
                <div class="lg:col-span-4 bg-zinc-900 border border-zinc-800 rounded-[2rem] p-8 shadow-2xl flex flex-col justify-between">
                    <h3 class="text-lg font-black uppercase tracking-[0.2em] text-zinc-400 mb-6 text-center">Rasio Pendaftaran</h3>
                    <div class="h-56 w-full relative">
                        <canvas id="typeChart"></canvas>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-6">
                        <div class="bg-black/40 p-3 rounded-2xl text-center border border-zinc-800">
                            <p class="text-2xl font-black text-red-500">{{ $individuCount }}</p>
                            <p class="text-[9px] text-zinc-500 font-bold uppercase tracking-widest">Individu</p>
                        </div>
                        <div class="bg-black/40 p-3 rounded-2xl text-center border border-zinc-800">
                            <p class="text-2xl font-black text-white">{{ $kelompokCount }}</p>
                            <p class="text-[9px] text-zinc-500 font-bold uppercase tracking-widest">Kelompok</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. DESKTOP SECTION --}}
            <div class="grid grid-cols-1 lg:grid-cols-1 gap-8">
                
                {{-- Panel Data Lamaran --}}
                <div class="bg-zinc-900 border border-zinc-800 rounded-[2rem] overflow-hidden shadow-2xl">
                    <div class="p-6 border-b border-zinc-800 flex justify-between items-center bg-zinc-900/50">
                        <h3 class="font-black text-white tracking-widest uppercase text-sm">Lamaran Terbaru</h3>
                        <a href="{{ route('admin.internship-applications.index') }}" class="text-[10px] font-black text-red-500 hover:text-red-400">LIHAT SEMUA &rarr;</a>
                    </div>
                    <div class="p-4 space-y-3">
                        @forelse($latestApplications as $app)
                            <div class="flex items-center gap-4 bg-black/30 p-4 rounded-2xl border border-zinc-800/50 hover:border-red-600/30 transition-colors">
                                <div class="w-10 h-10 bg-zinc-800 rounded-xl flex items-center justify-center font-black text-red-600">
                                    {{ substr($app->name, 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-white truncate">{{ $app->name }}</p>
                                    <p class="text-[10px] text-zinc-500 font-medium truncate">{{ $app->school }}</p>
                                </div>
                                <span class="px-2 py-1 bg-zinc-800 text-[9px] font-black uppercase tracking-tighter text-zinc-400 rounded-md">{{ $app->status }}</span>
                            </div>
                        @empty
                            <p class="text-center py-10 text-zinc-600 text-sm italic">Belum ada lamaran masuk.</p>
                        @endforelse
                    </div>
                </div>


            </div>
        </div>
    </div>

    {{-- CHART.JS SCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Chart.defaults.color = '#71717a';
            Chart.defaults.font.family = "'Inter', 'Segoe UI', sans-serif";

            // 1. Grafik Batang Tren
            new Chart(document.getElementById('trendChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($trendLabels) !!},
                    datasets: [{
                        label: 'Jumlah Pendaftar',
                        data: {!! json_encode($trendValues) !!},
                        backgroundColor: '#dc2626',
                        borderRadius: 10,
                        barThickness: 25,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#27272a' }, ticks: { font: { weight: 'bold' }, stepSize: 1 } },
                        x: { grid: { display: false }, ticks: { font: { weight: 'bold' } } }
                    },
                    plugins: { legend: { display: false } }
                }
            });

            // 2. Grafik Donat
            new Chart(document.getElementById('typeChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Individu', 'Kelompok'],
                    datasets: [{
                        data: [{{ $individuCount }}, {{ $kelompokCount }}],
                        backgroundColor: ['#dc2626', '#ffffff'],
                        borderWidth: 0,
                        hoverOffset: 15,
                        cutout: '80%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });
        });
    </script>
</x-app-layout>