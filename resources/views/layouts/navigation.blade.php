<nav x-data="{ open: false }" class="bg-black border-b-2 border-red-600 shadow-[0_4px_30px_rgba(220,38,38,0.3)] transition-colors duration-300 relative z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                
                {{-- LOGO BRANDING --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                        <img src="{{ asset('images/logo-gi.png') }}" alt="Logo GI" class="w-10 h-auto drop-shadow-[0_0_10px_rgba(255,255,255,0.2)] group-hover:drop-shadow-[0_0_15px_rgba(220,38,38,0.8)] transition-all duration-300">
                        <div class="hidden sm:block">
                            <span class="text-white font-black text-xl tracking-tighter leading-none block">SIPKL <span class="text-red-600">CORE</span></span>
                        </div>
                    </a>
                </div>

                {{-- MENU DESKTOP (PC/LAPTOP) --}}
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex items-center">
                    @auth
                        @if (auth()->user()->role === 'mahasiswa')
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 h-full border-b-4 {{ request()->routeIs('dashboard') ? 'border-red-600 text-white bg-gradient-to-t from-red-900/30 to-transparent' : 'border-transparent text-zinc-400 hover:text-white hover:border-red-600/50' }} font-bold text-sm tracking-widest uppercase transition-all duration-200">
                                📊 Dashboard
                            </a>
                            <a href="{{ route('student.internship-applications.index') }}" class="inline-flex items-center px-4 h-full border-b-4 {{ request()->routeIs('student.internship-applications*') ? 'border-red-600 text-white bg-gradient-to-t from-red-900/30 to-transparent' : 'border-transparent text-zinc-400 hover:text-white hover:border-red-600/50' }} font-bold text-sm tracking-widest uppercase transition-all duration-200">
                                📋 Daftar PKL
                            </a>
                        @elseif (auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 h-full border-b-4 {{ request()->routeIs('admin.dashboard') ? 'border-red-600 text-white bg-gradient-to-t from-red-900/30 to-transparent' : 'border-transparent text-zinc-400 hover:text-white hover:border-red-600/50' }} font-bold text-sm tracking-widest uppercase transition-all duration-200">
                                📊 Dashboard Admin
                            </a>
                            <a href="{{ route('admin.internship-applications.index') }}" class="inline-flex items-center px-4 h-full border-b-4 {{ request()->routeIs('admin.internship-applications*') ? 'border-red-600 text-white bg-gradient-to-t from-red-900/30 to-transparent' : 'border-transparent text-zinc-400 hover:text-white hover:border-red-600/50' }} font-bold text-sm tracking-widest uppercase transition-all duration-200">
                                📋 Data Lamaran
                            </a>
                            <a href="{{ route('admin.students.index') }}" class="inline-flex items-center px-4 h-full border-b-4 {{ request()->routeIs('admin.students*') ? 'border-red-600 text-white bg-gradient-to-t from-red-900/30 to-transparent' : 'border-transparent text-zinc-400 hover:text-white hover:border-red-600/50' }} font-bold text-sm tracking-widest uppercase transition-all duration-200">
                                👥 Data Siswa
                            </a>
                            {{-- TOMBOL KEMBALI KE WEB UTAMA --}}
                            <a href="{{ url('/') }}" class="inline-flex items-center px-4 h-full border-b-4 border-transparent text-zinc-400 hover:text-white hover:border-red-600/50 font-bold text-sm tracking-widest uppercase transition-all duration-200">
                                🌍 Web Utama
                            </a>
                        @elseif (auth()->user()->role === 'dosen')
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 h-full border-b-4 {{ request()->routeIs('dashboard') ? 'border-red-600 text-white bg-gradient-to-t from-red-900/30 to-transparent' : 'border-transparent text-zinc-400 hover:text-white hover:border-red-600/50' }} font-bold text-sm tracking-widest uppercase transition-all duration-200">
                                📊 Dashboard
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- USER DROPDOWN (PROFIL ADMIN) --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48" contentClasses="bg-black border border-red-600 rounded-xl shadow-[0_0_20px_rgba(220,38,38,0.5)] py-1">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 rounded-xl text-white bg-black border-2 border-red-600 hover:bg-red-900/30 hover:border-red-500 focus:outline-none transition-all duration-300 shadow-[0_0_20px_rgba(220,38,38,0.6)] group">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-red-600 rounded-lg flex items-center justify-center text-white font-black shadow-[0_0_10px_rgba(220,38,38,0.8)]">{{ substr(Auth::user()->name, 0, 1) }}</div>
                                <div class="text-sm font-black tracking-widest uppercase">{{ Auth::user()->name }}</div>
                            </div>

                            <div class="ms-3 text-red-500 group-hover:text-white transition-colors">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 bg-black text-sm border-b border-red-900/50">
                            <p class="font-black text-white uppercase tracking-widest">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-red-400 font-bold">{{ Auth::user()->email }}</p>
                        </div>
                        
                        <div class="bg-black pt-1 pb-1">
                            <x-dropdown-link :href="route('profile.edit')" class="hover:bg-red-900/20 text-zinc-300 hover:text-red-400 font-bold text-xs uppercase tracking-widest transition-colors">
                                👤 Profil Saya
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="text-red-500 hover:bg-red-900/40 hover:text-red-400 font-black text-xs uppercase tracking-widest border-t border-red-900/50 mt-1 pt-2 transition-colors">
                                    🚪 Logout
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- HAMBURGER MENU (MOBILE) --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-red-500 hover:text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-600 transition-all duration-150 border border-red-600/50">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MENU MOBILE (LAYAR HP) --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-black border-t-2 border-red-600 shadow-[0_15px_40px_rgba(220,38,38,0.4)]">
        <div class="pt-2 pb-3 space-y-1 px-4 mt-2">
            @auth
                @if (auth()->user()->role === 'mahasiswa')
                    <a href="{{ route('dashboard') }}" class="block px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-red-900/30 text-white border-l-4 border-red-600' : 'text-zinc-400 hover:text-white hover:bg-red-900/20' }} rounded-r-xl font-black text-xs uppercase tracking-widest transition-all">
                        📊 Dashboard
                    </a>
                    <a href="{{ route('student.internship-applications.index') }}" class="block px-4 py-3 {{ request()->routeIs('student.internship-applications*') ? 'bg-red-900/30 text-white border-l-4 border-red-600' : 'text-zinc-400 hover:text-white hover:bg-red-900/20' }} rounded-r-xl font-black text-xs uppercase tracking-widest transition-all">
                        📋 Daftar PKL
                    </a>
                @elseif (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-red-900/30 text-white border-l-4 border-red-600' : 'text-zinc-400 hover:text-white hover:bg-red-900/20' }} rounded-r-xl font-black text-xs uppercase tracking-widest transition-all">
                        📊 Dashboard Admin
                    </a>
                    <a href="{{ route('admin.internship-applications.index') }}" class="block px-4 py-3 {{ request()->routeIs('admin.internship-applications*') ? 'bg-red-900/30 text-white border-l-4 border-red-600' : 'text-zinc-400 hover:text-white hover:bg-red-900/20' }} rounded-r-xl font-black text-xs uppercase tracking-widest transition-all">
                        📋 Data Lamaran
                    </a>
                    <a href="{{ route('admin.students.index') }}" class="block px-4 py-3 {{ request()->routeIs('admin.students*') ? 'bg-red-900/30 text-white border-l-4 border-red-600' : 'text-zinc-400 hover:text-white hover:bg-red-900/20' }} rounded-r-xl font-black text-xs uppercase tracking-widest transition-all">
                        👥 Data Siswa
                    </a>
                    {{-- TOMBOL KEMBALI KE WEB UTAMA --}}
                    <a href="{{ url('/') }}" class="block px-4 py-3 text-zinc-400 hover:text-white hover:bg-red-900/20 rounded-r-xl font-black text-xs uppercase tracking-widest transition-all">
                        🌍 Web Utama
                    </a>
                @elseif (auth()->user()->role === 'dosen')
                    <a href="{{ route('dashboard') }}" class="block px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-red-900/30 text-white border-l-4 border-red-600' : 'text-zinc-400 hover:text-white hover:bg-red-900/20' }} rounded-r-xl font-black text-xs uppercase tracking-widest transition-all">
                        📊 Dashboard
                    </a>
                @endif
            @endauth
        </div>

        <div class="pt-4 pb-4 border-t border-red-900/50 bg-black mt-2">
            <div class="px-6 pb-3">
                <div class="font-black text-white uppercase tracking-widest text-sm">{{ Auth::user()->name }}</div>
                <div class="font-bold text-[10px] text-red-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="space-y-1 px-4">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-zinc-300 hover:text-white hover:bg-red-900/20 rounded-xl font-bold text-xs uppercase tracking-widest transition-colors">
                    👤 Profil Saya
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="block px-4 py-3 text-white bg-red-600 hover:bg-red-700 rounded-xl font-black text-xs uppercase tracking-widest transition-colors mt-2 shadow-[0_0_15px_rgba(220,38,38,0.5)]">
                        🚪 Logout
                    </a>
                </form>
            </div>
        </div>
    </div>
</nav>