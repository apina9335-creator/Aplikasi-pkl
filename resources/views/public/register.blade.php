<x-guest-layout>
    <div class="max-w-2xl mx-auto py-10 px-4">
        <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-xl border border-gray-100 dark:border-gray-700">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-black text-slate-900 dark:text-white mb-2">Formulir Pendaftaran PKL</h2>
                <p class="text-slate-500 dark:text-gray-400 font-medium">Lengkapi data diri Anda untuk mendapatkan Token PKL.</p>
            </div>

            <form action="{{ route('public.register.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-gray-300 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" class="w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-gray-300 mb-2">Email Aktif</label>
                        <input type="email" name="email" class="w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-blue-500" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-gray-300 mb-2">Asal Sekolah / Kampus</label>
                    <input type="text" name="school" class="w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-blue-500" required placeholder="Contoh: SMK Negeri 1 Jakarta">
                </div>

                <div x-data="{ type: 'individu' }">
                    <label class="block text-sm font-bold text-slate-700 dark:text-gray-300 mb-2">Tipe Pendaftaran</label>
                    <select name="registration_type" x-model="type" class="w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-blue-500">
                        <option value="individu">Individu (Sendiri)</option>
                        <option value="kelompok">Kelompok (Rombongan)</option>
                    </select>

                    <div x-show="type === 'kelompok'" class="mt-4 transition-all">
                        <label class="block text-sm font-bold text-slate-700 dark:text-gray-300 mb-2">Daftar Anggota Kelompok</label>
                        <textarea name="group_members" rows="3" placeholder="Sebutkan nama anggota lainnya dipisahkan koma..." class="w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-blue-500"></textarea>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-gray-300 mb-2">Alasan / Motivasi Magang</label>
                    <textarea name="motivation" rows="4" class="w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-blue-500" required></textarea>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-blue-500/30 transition-all text-lg">
                    Kirim Pendaftaran
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>