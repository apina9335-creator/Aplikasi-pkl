<x-guest-layout>
    <div class="flex justify-center mb-6">
    </div>

    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Selamat Datang di SIPKL</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
            Sistem Informasi Praktik Kerja Lapangan.<br>
            Silakan pilih menu di bawah ini untuk melanjutkan.
        </p>
    </div>

    <div class="space-y-4">
        
        @auth
            <a href="{{ url('/dashboard') }}" class="flex w-full justify-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-md shadow focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                MASUK KE DASHBOARD
            </a>
            
        @else
            <a href="{{ route('login') }}" class="flex w-full justify-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-md shadow focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                MASUK (LOGIN)

            <a href="{{ route('register') }}" class="flex w-full justify-center bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-blue-600 dark:text-blue-400 border-2 border-blue-600 dark:border-blue-400 font-bold py-3 px-4 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                DAFTAR AKUN BARU
            </a>
        @endauth

    </div>

    <div class="mt-8 text-center border-t border-gray-200 dark:border-gray-700 pt-4">
        <a href="https://www.gi.co.id/" target="_blank" class="text-sm text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 underline transition duration-150">
            Lihat Profil Global Intermedia &rarr;
        </a>
    </div>

    <div class="mt-6 text-center text-xs text-gray-400 dark:text-gray-500">
        &copy; {{ date('Y') }} SIPKL Project
    </div>
</x-guest-layout>