<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-green-200 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-2xl mx-auto mb-4 flex items-center justify-center shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-8 h-8 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Create Account</h1>
                    <p class="text-gray-600 text-sm">Buat akun dulu agar dapat sewa kendaraan</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <div class="relative">
                            <x-text-input id="name"
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 ease-in-out"
                                type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                                placeholder="Masukan Nama Lengkap Kamu" />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-1 text-sm text-red-600" />
                    </div>

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                        <div class="relative">
                            <x-text-input id="email"
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 ease-in-out"
                                type="email" name="email" :value="old('email')" required autocomplete="username"
                                placeholder="Masukan Alamat Email kamu" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-600" />
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="relative">
                            <x-text-input id="password"
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 ease-in-out"
                                type="password" name="password" required autocomplete="new-password"
                                placeholder="Create a strong password" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-600" />
                        <p class="text-xs text-gray-500">Password harus 8 character</p>
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi
                            Password</label>
                        <div class="relative">
                            <x-text-input id="password_confirmation"
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 ease-in-out"
                                type="password" name="password_confirmation" required autocomplete="new-password"
                                placeholder="Confirm your password" />
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')"
                            class="mt-1 text-sm text-red-600" />
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <x-primary-button
                            class="w-full bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-semibold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 flex items-center justify-center space-x-2">
                            <span>{{ __('Create Account') }}</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </x-primary-button>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-600">
                            Sudah Punya Akun ?
                            <a class="font-medium text-indigo-600 hover:text-indigo-500 transition duration-200 ease-in-out"
                                href="{{ route('login') }}">
                                {{ __('Sign in here') }}
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center">
                <p class="text-xs text-gray-500">
                    By creating an account, you agree to our
                    <a href="#" class="text-indigo-600 hover:text-indigo-500">Terms of Service</a>
                    and
                    <a href="#" class="text-indigo-600 hover:text-indigo-500">Privacy Policy</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>