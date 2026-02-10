<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="phone" :value="__('No Telepon (WA)')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" placeholder="08..." />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        {{-- KHUSUS MAHASISWA --}}
        @if($user->isMahasiswa())
            <div class="p-4 bg-blue-50 rounded-lg border border-blue-100 space-y-4">
                <h3 class="text-sm font-bold text-blue-800 uppercase">Data Akademik Mahasiswa</h3>
                
                <div>
                    <x-input-label for="nim" :value="__('NIM')" />
                    <x-text-input id="nim" name="nim" type="text" class="mt-1 block w-full" :value="old('nim', $user->nim)" />
                    <x-input-error class="mt-2" :messages="$errors->get('nim')" />
                </div>

                <div>
                    <x-input-label for="major" :value="__('Jurusan / Prodi')" />
                    <x-text-input id="major" name="major" type="text" class="mt-1 block w-full" :value="old('major', $user->major)" />
                    <x-input-error class="mt-2" :messages="$errors->get('major')" />
                </div>

                <div>
                    <x-input-label for="semester" :value="__('Semester Saat Ini')" />
                    <x-text-input id="semester" name="semester" type="number" class="mt-1 block w-full" :value="old('semester', $user->semester)" />
                    <x-input-error class="mt-2" :messages="$errors->get('semester')" />
                </div>
            </div>
        @endif

        {{-- KHUSUS DOSEN --}}
        @if($user->isDosen())
            <div class="p-4 bg-green-50 rounded-lg border border-green-100 space-y-4">
                <h3 class="text-sm font-bold text-green-800 uppercase">Data Dosen</h3>
                
                <div>
                    <x-input-label for="nidn" :value="__('NIDN')" />
                    <x-text-input id="nidn" name="nidn" type="text" class="mt-1 block w-full" :value="old('nidn', $user->nidn)" />
                    <x-input-error class="mt-2" :messages="$errors->get('nidn')" />
                </div>
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>