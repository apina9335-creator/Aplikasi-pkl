<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran PKL - SIPKL</title>
    
    {{-- Tailwind & Alpine JS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    {{-- Memanggil Flatpickr (Kalender Praktis) Tema Gelap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">

    <style>
        [x-cloak] { display: none !important; }
        
        /* Gaya Scrollbar */
        .scroll-area::-webkit-scrollbar { width: 5px; }
        .scroll-area::-webkit-scrollbar-track { background: transparent; }
        .scroll-area::-webkit-scrollbar-thumb { background: #3f3f46; border-radius: 10px; }
        .scroll-area::-webkit-scrollbar-thumb:hover { background: #dc2626; }

        @media (min-width: 1024px) {
            .main-container { height: 90vh; }
        }

        /* Kustomisasi Kalender Flatpickr */
        .flatpickr-calendar { font-family: 'Inter', sans-serif; border: 1px solid #27272a; box-shadow: 0 25px 50px -12px rgba(220, 38, 38, 0.3); }
        .flatpickr-day.selected { background: #dc2626 !important; border-color: #dc2626 !important; }
        
        /* Sembunyikan ikon kalender bawaan browser agar tidak double */
        input[type="date"]::-webkit-calendar-picker-indicator { display: none; -webkit-appearance: none; }
    </style>
</head>
<body class="bg-black min-h-screen font-sans text-slate-100 selection:bg-red-600 selection:text-white relative flex items-center justify-center py-6 px-4 md:px-8">

    {{-- DEKORASI BACKGROUND --}}
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
        <div class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] bg-red-900/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[400px] h-[400px] bg-red-900/10 rounded-full blur-[100px]"></div>
    </div>

    {{-- KOTAK UTAMA --}}
    <div class="w-full max-w-6xl bg-zinc-900 rounded-[2.5rem] shadow-2xl shadow-red-900/20 border border-zinc-800 relative z-10 flex flex-col lg:flex-row overflow-hidden main-container">

        {{-- KIRI: AREA GAMBAR --}}
        <div class="hidden lg:flex lg:w-5/12 bg-zinc-950 flex-col items-center justify-between p-10 border-r border-zinc-800 relative">
            <div class="absolute inset-0 bg-gradient-to-b from-red-900/20 to-transparent z-0 pointer-events-none"></div>
            
            <div class="relative z-10 w-full">
                <div class="w-14 h-14 bg-red-600 rounded-2xl flex items-center justify-center mb-8 shadow-[0_0_30px_rgba(220,38,38,0.4)]">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h2 class="text-5xl font-black text-white mb-4 tracking-tighter leading-[0.9]">DAFTAR<br><span class="text-red-600 uppercase">Magang</span></h2>
                <p class="text-zinc-500 font-bold text-xs tracking-[0.3em] uppercase">Global Intermedia Nusantara</p>
            </div>

            <div class="relative z-10 w-full px-4">
                <img src="//gi.co.id/dist/images/intro-carousel/slide_1.jpg" class="w-full h-auto object-cover rounded-3xl border border-zinc-800 shadow-2xl transform -rotate-2 hover:rotate-0 transition-transform duration-500" alt="GI Office">
            </div>

            <div class="relative z-10 w-full text-zinc-600 text-[10px] font-bold tracking-widest uppercase">
                &copy; {{ date('Y') }} SIPKL Core System
            </div>
        </div>

        {{-- KANAN: AREA FORMULIR --}}
        <div class="w-full lg:w-7/12 flex flex-col h-full bg-zinc-900 relative">
            
            {{-- HEADER FORM --}}
            <div class="shrink-0 p-8 md:px-12 md:py-10 border-b border-zinc-800 flex items-center justify-between bg-zinc-900/50 backdrop-blur-xl z-30">
                <div>
                    <h2 class="text-3xl font-black text-white tracking-tight">Formulir Siswa</h2>
                    <p class="text-zinc-500 font-bold text-[10px] uppercase tracking-[0.2em] mt-1">Lengkapi data untuk mendapatkan Token</p>
                </div>
                <a href="{{ url('/') }}" class="w-12 h-12 shrink-0 bg-zinc-800 border border-zinc-700 rounded-2xl flex items-center justify-center text-zinc-400 hover:text-white hover:bg-red-600 hover:border-red-600 transition-all shadow-lg group">
                    <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
            </div>

            {{-- FORM AREA --}}
            <div class="flex-1 overflow-y-auto scroll-area p-8 md:p-12 pt-6">
                
                @if ($errors->any())
                    <div class="mb-8 p-5 bg-red-900/20 border border-red-600/30 rounded-2xl text-sm text-red-400 font-bold">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-center gap-2">
                                    <span class="w-1 h-1 bg-red-500 rounded-full"></span> {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('public.register.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8 pb-10">
                    @csrf
                    
                    {{-- Baris 1: Identitas --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-3">Nama Lengkap</label>
                            <input type="text" name="name" class="w-full bg-zinc-950 border border-zinc-800 rounded-2xl p-4 text-white focus:ring-4 focus:ring-red-600/10 focus:border-red-600 transition-all outline-none font-bold" required placeholder="Contoh: Alfian Mustofa">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-3">Email Gmail</label>
                            <input type="email" name="email" class="w-full bg-zinc-950 border border-zinc-800 rounded-2xl p-4 text-white focus:ring-4 focus:ring-red-600/10 focus:border-red-600 transition-all outline-none font-bold" required placeholder="alamat@gmail.com">
                        </div>
                    </div>

                    {{-- Baris 2: Kontak WA & Institusi --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-3">No. WhatsApp</label>
                            <input type="number" name="phone" class="w-full bg-zinc-950 border border-zinc-800 rounded-2xl p-4 text-white focus:ring-4 focus:ring-red-600/10 focus:border-red-600 transition-all outline-none font-bold" required placeholder="Contoh: 081234567890">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-3">Asal Sekolah / Kampus</label>
                            <input type="text" name="school" class="w-full bg-zinc-950 border border-zinc-800 rounded-2xl p-4 text-white focus:ring-4 focus:ring-red-600/10 focus:border-red-600 transition-all outline-none font-bold" required placeholder="SMKN 1 Bantul / UGM">
                        </div>
                    </div>

                    {{-- Baris 3: Tanggal PKL --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-zinc-950/50 p-6 rounded-[2rem] border border-zinc-800">
                        <div class="relative cursor-pointer">
                            <label class="block text-[10px] font-black text-zinc-400 uppercase tracking-widest mb-3">Mulai Magang</label>
                            <input type="date" name="start_date" class="datepicker w-full bg-zinc-900 border border-zinc-700 rounded-xl p-3 pl-10 text-white focus:ring-2 focus:ring-red-600/30 focus:border-red-600 outline-none font-bold cursor-pointer" placeholder="Pilih Tanggal &rarr;" required>
                            <div class="absolute bottom-3.5 left-3 text-zinc-500 pointer-events-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        </div>
                        <div class="relative cursor-pointer">
                            <label class="block text-[10px] font-black text-zinc-400 uppercase tracking-widest mb-3">Selesai Magang</label>
                            <input type="date" name="end_date" class="datepicker w-full bg-zinc-900 border border-zinc-700 rounded-xl p-3 pl-10 text-white focus:ring-2 focus:ring-red-600/30 focus:border-red-600 outline-none font-bold cursor-pointer" placeholder="Pilih Tanggal &rarr;" required>
                            <div class="absolute bottom-3.5 left-3 text-zinc-500 pointer-events-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Baris 4: Upload File --}}
                    <div>
                        <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-3">Surat Pengantar / Proposal (PDF/Gambar)</label>
                        <div class="bg-zinc-950 border-2 border-dashed border-zinc-800 rounded-[2rem] p-8 text-center hover:border-red-600/50 transition-colors group">
                            <input type="file" name="document_file" accept=".pdf,image/*" class="w-full text-xs text-zinc-600 file:mr-4 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-zinc-800 file:text-zinc-400 hover:file:bg-red-600 hover:file:text-white file:transition-all cursor-pointer" required>
                            <p class="mt-4 text-[10px] text-zinc-600 font-bold uppercase tracking-widest">Maksimal Ukuran File: 5MB</p>
                        </div>
                    </div>

                    {{-- Baris 5: Tipe Pendaftaran --}}
                    <div x-data="{ type: 'individu' }" class="bg-zinc-950/50 p-6 rounded-[2rem] border border-zinc-800">
                        <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-3">Tipe Pendaftaran</label>
                        <select name="registration_type" x-model="type" class="w-full bg-zinc-900 border border-zinc-700 rounded-xl p-4 text-white focus:ring-4 focus:ring-red-600/10 focus:border-red-600 outline-none cursor-pointer font-bold">
                            <option value="individu">Individu (Sendiri)</option>
                            <option value="kelompok">Kelompok (Rombongan)</option>
                        </select>

                        <div x-show="type === 'kelompok'" x-cloak x-transition class="mt-6 pt-6 border-t border-zinc-800">
                            <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-3">Daftar Anggota Tim</label>
                            <textarea name="group_members" rows="2" placeholder="Sebutkan nama anggota lainnya dipisahkan koma..." class="w-full bg-zinc-900 border border-zinc-700 rounded-xl p-4 text-white focus:border-red-600 outline-none text-sm font-medium"></textarea>
                        </div>
                    </div>

                    {{-- Baris 6: Motivasi --}}
                    <div>
                        <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-3">Apa Motivasi Kamu?</label>
                        <textarea name="motivation" rows="4" class="w-full bg-zinc-950 border border-zinc-800 rounded-2xl p-5 text-white focus:ring-4 focus:ring-red-600/10 focus:border-red-600 outline-none text-sm leading-relaxed" placeholder="Jelaskan alasan singkat mengapa ingin PKL di sini..." required></textarea>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="pt-4">
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-5 rounded-2xl shadow-[0_15px_40px_rgba(220,38,38,0.3)] transition-all transform active:scale-[0.97] flex items-center justify-center gap-4 tracking-[0.2em] text-sm">
                            <span>KIRIM DATA</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    {{-- Script Flatpickr --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr(".datepicker", {
                locale: "id",
                altInput: true, 
                altFormat: "d F Y", // Hasil: 12 Mei 2026
                dateFormat: "Y-m-d", // Hasil ke DB
                disableMobile: true, // Pastikan pop-up kalender tetap bagus di HP
                allowInput: false // KUNCI MANUAL TYPING (Tidak bisa diketik manual)
            });
        });
    </script>
</body>
</html>