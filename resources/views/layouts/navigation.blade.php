<nav x-data="{ open: false }" class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <div class="text-3xl">🎓</div>
                        <span class="hidden sm:inline text-white font-bold text-xl">SIPKL</span>
                    </a>
                </div>

                <div class="hidden space-x-2 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border-b-2 {{ request()->routeIs('dashboard') ? 'border-white text-white' : 'border-transparent text-blue-100 hover:text-white' }} font-medium transition duration-200">
                        📊 Dashboard
                    </a>
                    @auth
                        @if (auth()->user()->role === 'mahasiswa')
                            <a href="{{ route('student.internship-applications.index') }}" class="inline-flex items-center px-4 py-2 border-b-2 {{ request()->routeIs('student.internship-applications*') ? 'border-white text-white' : 'border-transparent text-blue-100 hover:text-white' }} font-medium transition duration-200">
                                📋 Daftar PKL
                            </a>
                        @elseif (auth()->user()->role === 'admin')
                            {{-- PERBAIKAN 1: Link Desktop sudah benar ke Dashboard --}}
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 border-b-2 {{ request()->routeIs('admin.dashboard') ? 'border-white text-white' : 'border-transparent text-blue-100 hover:text-white' }} font-medium transition duration-200">
                                ✅ Approval PKL
                            </a>
                        @elseif (auth()->user()->role === 'dosen')
                            <a href="{{ route('advisor.student-activity.index') }}" class="inline-flex items-center px-4 py-2 border-b-2 {{ request()->routeIs('advisor.student-activity*') ? 'border-white text-white' : 'border-transparent text-blue-100 hover:text-white' }} font-medium transition duration-200">
                                👥 Keaktivan Siswa
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 rounded-lg text-white bg-blue-700 hover:bg-blue-500 focus:outline-none transition ease-in-out duration-150 shadow-md">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-blue-600 font-bold">{{ substr(Auth::user()->name, 0, 1) }}</div>
                                <div class="text-sm">{{ Auth::user()->name }}</div>
                            </div>

                            <div class="ms-2">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 text-gray-600 text-sm border-b border-gray-200">
                            <p class="font-semibold">{{ Auth::user()->name }}</p>
                            <p class="text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-blue-50">
                            👤 Profil Saya
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                             class="text-red-600 hover:bg-red-50 hover:text-red-800">
                                🚪 Logout
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-blue-200 hover:text-white hover:bg-blue-700 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-blue-700">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-white hover:bg-blue-600 rounded-lg">
                📊 Dashboard
            </a>
            @auth
                @if (auth()->user()->role === 'mahasiswa')
                    <a href="{{ route('student.internship-applications.index') }}" class="block px-4 py-2 text-blue-100 hover:text-white hover:bg-blue-600 rounded-lg">
                        📋 Daftar PKL
                    </a>
                @elseif (auth()->user()->role === 'admin')
                    {{-- PERBAIKAN 2: Link Mobile SUDAH DIPERBAIKI ke Dashboard --}}
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-blue-100 hover:text-white hover:bg-blue-600 rounded-lg">
                        ✅ Approval PKL
                    </a>
                @elseif (auth()->user()->role === 'dosen')
                    <a href="{{ route('advisor.student-activity.index') }}" class="block px-4 py-2 text-blue-100 hover:text-white hover:bg-blue-600 rounded-lg">
                        👥 Keaktivan Siswa
                    </a>
                @endif
            @endauth
        </div>

        <div class="pt-4 pb-1 border-t border-blue-600">
            <div class="px-4 pb-3">
                <div class="font-medium text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-blue-200">{{ Auth::user()->email }}</div>
            </div>

            <div class="space-y-1">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-blue-100 hover:text-white hover:bg-blue-600 rounded-lg">
                    👤 Profil
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="block px-4 py-2 text-red-300 hover:text-red-100 hover:bg-red-600 rounded-lg">
                        🚪 Logout
                    </a>
                </form>
            </div>
        </div>
    </div>
</nav>