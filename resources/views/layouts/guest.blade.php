<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SIPKL - Login</title>

        <link rel="shortcut icon" href="//www.gi.co.id/dist/images/favicon.ico">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            /* Mengambil gambar background persis seperti halaman awal */
            .bg-login-gi {
                background-image: url('//www.gi.co.id/dist/images/intro-carousel/slide_1.jpg');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
            }
            
            /* Efek gelap dan blur agar kotak form lebih menonjol */
            .overlay-gi {
                background: rgba(0, 0, 0, 0.75); 
                backdrop-filter: blur(6px); 
                min-height: 100vh;
                width: 100%;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-login-gi">
        
        <div class="overlay-gi flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            
            {{-- Logo Perusahaan (Bisa diklik untuk kembali ke awal) --}}
            <div class="mb-6 mt-10 sm:mt-0">
                <a href="/">
                    <img src="//www.gi.co.id/dist/images/logo_gi.png" alt="Logo GI" class="w-64 mx-auto drop-shadow-md">
                </a>
            </div>

            {{-- Kotak Form Login / Register --}}
            <div class="w-full sm:max-w-md px-8 py-8 bg-white shadow-2xl overflow-hidden sm:rounded-2xl border-t-4 border-blue-600">
                
                {{-- Judul Sambutan --}}
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800"></h2>
                    <p class="text-sm text-gray-500 mt-1"></p>
                </div>

                {{-- Di sinilah form input email & password Laravel akan otomatis muncul --}}
                {{ $slot }}
                
            </div>

            {{-- Copyright bawah --}}
            <div class="mt-8 text-gray-300 text-sm tracking-wide">
                &copy; {{ date('Y') }} SIPKL Project - Global Intermedia
            </div>

        </div>
    </body>
</html>