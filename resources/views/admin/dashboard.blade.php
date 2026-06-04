<x-app-layout>
    
    {{-- EFEK BARU: GRADASI MERAH DI PINGGIR LAYAR (VIGNETTE) --}}
    <div class="fixed inset-0 pointer-events-none shadow-[inset_0_0_150px_rgba(220,38,38,0.15)] z-50"></div>

    <div class="min-h-screen bg-slate-50 text-slate-800 antialiased relative">
        <x-slot name="header">
            <h2 class="font-black text-2xl text-slate-900 leading-tight flex items-center gap-3 relative z-10">
                <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center shadow-[0_0_15px_rgba(220,38,38,0.4)]">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                ADMIN <span class="text-red-600 uppercase tracking-tighter">Command Center</span>
            </h2>
        </x-slot>

        <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8 relative z-10">
            
            {{-- 1. GRAFIK UTAMA --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                {{-- Grafik Batang (Tren) --}}
                <div class="lg:col-span-8 bg-white border border-red-100 rounded-[2rem] p-8 shadow-[0_0_30px_rgba(220,38,38,0.03)] hover:shadow-[0_0_30px_rgba(220,38,38,0.08)] transition-shadow">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-lg font-black uppercase tracking-[0.2em] text-gray-500">Analitik Pendaftar</h3>
                        <span class="bg-red-50 text-red-600 px-3 py-1 rounded-full text-[10px] font-black border border-red-100">6 BULAN TERAKHIR</span>
                    </div>
                    <div class="h-72 w-full">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>

                {{-- Grafik Donat (Tipe) --}}
                <div class="lg:col-span-4 bg-white border border-red-100 rounded-[2rem] p-8 shadow-[0_0_30px_rgba(220,38,38,0.03)] hover:shadow-[0_0_30px_rgba(220,38,38,0.08)] transition-shadow flex flex-col justify-between">
                    <h3 class="text-lg font-black uppercase tracking-[0.2em] text-gray-500 mb-6 text-center">Rasio Pendaftaran</h3>
                    <div class="h-56 w-full relative">
                        <canvas id="typeChart"></canvas>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-6">
                        <div class="bg-red-50/50 p-3 rounded-2xl text-center border border-red-100">
                            <p class="text-2xl font-black text-red-600">{{ $individuCount }}</p>
                            <p class="text-[9px] text-red-500 font-bold uppercase tracking-widest">Individu</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-2xl text-center border border-gray-100">
                            <p class="text-2xl font-black text-slate-800">{{ $kelompokCount }}</p>
                            <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest">Kelompok</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. DESKTOP SECTION --}}
            <div class="grid grid-cols-1 lg:grid-cols-1 gap-8">
                
                {{-- Panel Data Lamaran --}}
                <div class="bg-white border border-red-100 rounded-[2rem] overflow-hidden shadow-[0_0_30px_rgba(220,38,38,0.03)] hover:shadow-[0_0_30px_rgba(220,38,38,0.08)] transition-shadow">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-red-50/30">
                        <h3 class="font-black text-slate-800 tracking-widest uppercase text-sm">Lamaran Terbaru</h3>
                        <a href="{{ route('admin.internship-applications.index') }}" class="text-[10px] font-black text-red-600 hover:text-red-800 transition-colors">LIHAT SEMUA &rarr;</a>
                    </div>
                    <div class="p-4 space-y-3">
                        @forelse($latestApplications as $app)
                            <div class="flex items-center gap-4 bg-white p-4 rounded-2xl border border-gray-100 hover:border-red-300 transition-colors shadow-sm hover:shadow-[0_0_15px_rgba(220,38,38,0.05)]">
                                <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center font-black text-red-600 border border-red-100">
                                    {{ substr($app->name, 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-slate-800 truncate capitalize">{{ $app->name }}</p>
                                    <p class="text-[10px] text-gray-500 font-medium truncate">{{ $app->school }}</p>
                                </div>
                                <span class="px-3 py-1 bg-gray-50 text-[9px] font-black uppercase tracking-widest text-gray-500 rounded-lg border border-gray-200">{{ $app->status }}</span>
                            </div>
                        @empty
                            <p class="text-center py-10 text-gray-500 text-sm italic">Belum ada lamaran masuk.</p>
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
            Chart.defaults.color = '#6b7280'; 
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
                        y: { beginAtZero: true, grid: { color: '#f3f4f6' }, ticks: { font: { weight: 'bold' }, stepSize: 1 } },
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
                        backgroundColor: ['#dc2626', '#1e293b'], 
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