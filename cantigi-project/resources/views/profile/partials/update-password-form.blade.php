<!-- Update Password Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-700 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        {{ __('Update Password') }}
                    </h2>
                    <p class="mt-1 text-orange-100">
                        {{ __('Ensure your account is using a long, random password to stay secure.') }}
                    </p>
                </div>

                <div class="p-6">
                    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                        @csrf
                        @method('put')

                        <div class="space-y-4">
                            <div class="space-y-2">
                                <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-sm font-medium text-gray-700" />
                                <div class="relative">
                                    <x-text-input 
                                        id="update_password_current_password" 
                                        name="current_password" 
                                        type="password" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200" 
                                        autocomplete="current-password" 
                                    />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="text-red-500 text-sm" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <x-input-label for="update_password_password" :value="__('New Password')" class="text-sm font-medium text-gray-700" />
                                    <div class="relative">
                                        <x-text-input 
                                            id="update_password_password" 
                                            name="password" 
                                            type="password" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200" 
                                            autocomplete="new-password" 
                                        />
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->updatePassword->get('password')" class="text-red-500 text-sm" />
                                </div>

                                <div class="space-y-2">
                                    <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-sm font-medium text-gray-700" />
                                    <div class="relative">
                                        <x-text-input 
                                            id="update_password_password_confirmation" 
                                            name="password_confirmation" 
                                            type="password" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200" 
                                            autocomplete="new-password" 
                                        />
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="text-red-500 text-sm" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div class="flex items-center space-x-4">
                                <x-primary-button class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 focus:ring-4 focus:ring-orange-200">
                                    {{ __('Update Password') }}
                                </x-primary-button>

                                @if (session('status') === 'password-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 transform translate-x-2"
                                        x-transition:enter-end="opacity-100 transform translate-x-0"
                                        x-transition:leave="transition ease-in duration-300"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"
                                        x-init="setTimeout(() => show = false, 3000)"
                                        class="inline-flex items-center px-3 py-2 bg-green-100 text-green-800 rounded-lg text-sm font-medium"
                                    >
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        {{ __('Saved.') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>