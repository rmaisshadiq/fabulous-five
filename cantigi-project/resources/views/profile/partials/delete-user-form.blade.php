<!-- Delete Account Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-300 overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-700 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        {{ __('Delete Account') }}
                    </h2>
                    <p class="mt-1 text-red-100">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                    </p>
                </div>

                <div class="p-6">
                    <div class="bg-red-50 border border-gray-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <div>
                                <h3 class="text-sm font-medium text-red-800">Warning</h3>
                                <p class="mt-1 text-sm text-red-700">
                                    This action cannot be undone. This will permanently delete your account and remove all associated data from our servers.
                                </p>
                            </div>
                        </div>
                    </div>

                    <x-danger-button
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                        class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 focus:ring-4 focus:ring-red-200 flex items-center"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        {{ __('Delete Account') }}
                    </x-danger-button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <div class="bg-white rounded-xl shadow-2xl">
            <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
                @csrf
                @method('delete')

                <div class="flex items-center justify-center w-12 h-12 bg-red-100 rounded-full mx-auto mb-4">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>

                <h2 class="text-xl font-bold text-gray-900 text-center mb-2">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p class="text-sm text-gray-600 text-center mb-6">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>

                <div class="mb-6">
                    <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                    <div class="relative">
                        <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200"
                            placeholder="{{ __('Enter your password to confirm') }}"
                        />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-red-500 text-sm" />
                </div>

                <div class="flex justify-end space-x-3">
                    <x-secondary-button 
                        x-on:click="$dispatch('close')"
                        class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-all duration-200"
                    >
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-danger-button class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 focus:ring-4 focus:ring-red-200 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        {{ __('Delete Account') }}
                    </x-danger-button>
                </div>
            </form>
        </div>
    </x-modal>
</div>