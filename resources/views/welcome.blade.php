<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SIPKL - Selamat Datang</title>

        <link rel="shortcut icon" href="//www.gi.co.id/dist/images/favicon.ico">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            /* Background gambar pabrik yang sama persis dengan halaman Login */
            .bg-welcome-gi {
                background-image: url('//www.gi.co.id/dist/images/intro-carousel/slide_1.jpg');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
            }
            
            /* Efek gelap dan blur yang persis sama */
            .overlay-gi {
                background: rgba(0, 0, 0, 0.75); 
                backdrop-filter: blur(6px); 
                min-height: 100vh;
                width: 100%;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-welcome-gi">
        
        <div class="overlay-gi flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            
            {{-- Kotak Card --}}
            <div class="w-full sm:max-w-md px-8 py-10 bg-white shadow-2xl overflow-hidden sm:rounded-2xl border-t-4 border-blue-600 text-center transition-all duration-300">
                
                {{-- Logo Perusahaan --}}
                <img src="//www.gi.co.id/dist/images/logo_gi.png" alt="Logo GI" class="w-48 mx-auto mb-6 drop-shadow-sm">
                
                {{-- Teks Sambutan --}}
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang di SIPKL</h2>
                <p class="text-sm text-gray-500 mb-8">Sistem Informasi Praktik Kerja Lapangan.<br>Silakan masuk atau daftar untuk melanjutkan.</p>
                
                {{-- Tombol Masuk (Login) --}}
                <a href="{{ route('login') }}" class="block w-full justify-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition ease-in-out duration-150 mb-3">
                    Masuk (Login)
                </a>

                {{-- Tombol Daftar (Register) --}}
                <a href="{{ route('register') }}" class="block w-full justify-center bg-white hover:bg-blue-50 text-blue-600 border-2 border-blue-600 font-bold py-3 px-4 rounded-lg shadow-sm transition ease-in-out duration-150 mb-4">
                    Daftar Akun Baru
                </a>
                
                {{-- Link Lihat Profil Perusahaan --}}
                <a href="https://www.gi.co.id/" target="_blank" class="inline-block mt-2 text-sm text-gray-400 hover:text-blue-600 underline transition duration-150">
                    Lihat profil perusahaan &rarr;
                </a>
                
            </div>

            {{-- Copyright bawah --}}
            <div class="mt-8 text-gray-300 text-sm tracking-wide">
                &copy; {{ date('Y') }} SIPKL Project - Global Intermedia
            </div>

        </div>
    </body>
</html>