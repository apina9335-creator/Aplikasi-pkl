<div class="bg-zinc-900 border border-zinc-800 rounded-[2rem] overflow-hidden shadow-2xl">
    <div class="p-6 border-b border-zinc-800 bg-zinc-900/50">
        <h3 class="font-black text-white tracking-widest uppercase text-sm">{{ $typeLabel }}</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-zinc-950/80 border-b border-zinc-800">
                    <th class="p-4 text-[10px] font-black text-zinc-500 uppercase tracking-widest w-16 text-center">No</th>
                    <th class="p-4 text-[10px] font-black text-zinc-500 uppercase tracking-widest">Informasi Peserta & Akses</th>
                    <th class="p-4 text-[10px] font-black text-zinc-500 uppercase tracking-widest hidden md:table-cell">Asal Instansi</th>
                    <th class="p-4 text-[10px] font-black text-zinc-500 uppercase tracking-widest hidden md:table-cell">Periode Magang</th>
                    <th class="p-4 text-[10px] font-black text-zinc-500 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800">
                @forelse($students as $student)
                    <tr class="hover:bg-zinc-800/50 transition-colors group">
                        
                        {{-- 1. NOMOR URUT --}}
                        <td class="p-4 text-center text-sm font-bold text-zinc-400">
                            {{ $loop->iteration }}
                        </td>
                        
                        {{-- 2. INFORMASI PESERTA, EMAIL, TOKEN, & NOMOR WA --}}
                        <td class="p-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 shrink-0 bg-zinc-800 rounded-xl flex items-center justify-center font-black text-red-600 group-hover:bg-red-600/20 group-hover:text-red-500 transition-colors">
                                    {{ substr($student->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-white">{{ $student->name }}</p>
                                    
                                    {{-- Email & Tombol Chat WA --}}
                                    <div class="flex items-center gap-2 mt-1 mb-1">
                                        <p class="text-[10px] text-zinc-500 font-medium">{{ $student->email }}</p>
                                        <span class="text-zinc-700">|</span>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $student->phone ?? '') }}" target="_blank" class="flex items-center gap-1 text-[10px] font-black text-green-500 hover:text-green-400 transition-colors bg-green-500/10 px-2 py-0.5 rounded border border-green-500/20">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824z"/></svg>
                                            {{ $student->phone ?? 'WA Kosong' }}
                                        </a>
                                    </div>

                                    <p class="text-[10px] text-zinc-500 font-bold uppercase tracking-widest">
                                        Token Akses: <span class="text-red-500 font-black tracking-widest bg-red-500/10 px-1 rounded border border-red-500/20">{{ $student->token }}</span>
                                    </p>
                                </div>
                            </div>
                        </td>
                        
                        {{-- 3. ASAL SEKOLAH & TIM --}}
                        <td class="p-4 hidden md:table-cell">
                            <div class="inline-flex items-center px-3 py-1 rounded-full bg-black/40 border border-zinc-800 text-[10px] font-bold text-zinc-300">
                                {{ $student->school ?? 'Belum Diketahui' }}
                            </div>
                            @if($student->registration_type === 'kelompok')
                                <div class="mt-2 text-[9px] text-zinc-500 font-bold uppercase tracking-widest whitespace-normal max-w-[200px]">
                                    Tim: {{ \Illuminate\Support\Str::limit($student->group_members, 40) }}
                                </div>
                            @endif
                        </td>

                        {{-- 4. TANGGAL MULAI & SELESAI --}}
                        <td class="p-4 hidden md:table-cell">
                            <div class="flex flex-col gap-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="text-[9px] font-black text-zinc-500 uppercase tracking-widest w-12">Mulai</span>
                                    <span class="px-2 py-0.5 bg-zinc-800 rounded text-[10px] font-bold text-zinc-300">
                                        {{ $student->start_date ? \Carbon\Carbon::parse($student->start_date)->translatedFormat('d M Y') : '-' }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[9px] font-black text-zinc-500 uppercase tracking-widest w-12">Selesai</span>
                                    <span class="px-2 py-0.5 bg-zinc-800 rounded text-[10px] font-bold text-zinc-300">
                                        {{ $student->end_date ? \Carbon\Carbon::parse($student->end_date)->translatedFormat('d M Y') : '-' }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        {{-- 5. AKSI HAPUS --}}
                        <td class="p-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data peserta ini secara permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-zinc-800 text-zinc-400 rounded-lg hover:bg-red-600 hover:text-white transition-colors" title="Hapus Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-16 text-center">
                            <div class="w-16 h-16 bg-zinc-800 rounded-full flex items-center justify-center mx-auto mb-4 text-zinc-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            </div>
                            <p class="text-sm font-bold text-zinc-500 uppercase tracking-widest">Belum ada peserta di kategori ini.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>