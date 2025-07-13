<div class="min-h-screen bg-white py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Profile Settings</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Manage your account settings and preferences</p>
        </div>

        @if (session('status') === 'verification-successful')
            <div
                x-data="{ show: true }"
                x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90"
                x-init="setTimeout(() => show = false, 5000)"
                class="mb-6 p-4 rounded-md bg-green-50 border border-green-200"
                role="alert"
            >
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                         <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            {{ __('Email telah berhasil diverifikasi! Selamat datang.') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="space-y-8">
            @if($customer->needsVerification())
            <section class="bg-white rounded-xl shadow-sm overflow-hidden border">
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-700 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Account Verification') }}
                    </h2>
                    <p class="mt-1 text-gray-100">
                        {{ __('Your account requires verification to access all features. Please complete the verification process.') }}
                    </p>
                </div>

                <div class="p-6">
                    <div class="flex items-start space-x-3">
                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-gray-900">
                                {{ __('Verification Required') }}
                            </h3>
                            <p class="mt-2 text-gray-600">
                                {{ __('To continue using our services, please verify your account by providing the required documents and information.') }}
                            </p>
                            <div class="mt-4">
                                <a href="{{ route('profile.verify') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-sm font-medium transition-colors duration-200">
                                    {{ __('Start Verification') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            @elseif($customer->isPending())
            <section class="bg-white rounded-xl shadow-sm overflow-hidden border">
                <div class="bg-gradient-to-r from-blue-500 to-blue-700 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('Verification Pending') }}
                    </h2>
                    <p class="mt-1 text-gray-100">
                        {{ __('Your verification documents have been submitted and are currently under review.') }}
                    </p>
                </div>

                <div class="p-6">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-gray-900">
                                {{ __('Under Review') }}
                            </h3>
                            <p class="mt-2 text-gray-600">
                                {{ __('Thank you for submitting your verification documents. Our team is currently reviewing your information. You will be notified via email once the verification process is complete.') }}
                            </p>
                            <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-sm text-blue-800 font-medium">
                                        {{ __('Estimated review time: 1-3 business days') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            @endif            <!-- Profile Information Section -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border">
                <div class="bg-gradient-to-r from-green-500 to-green-700 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        @if($customer->isVerified())
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('Profile Information - Verified') }}
                        @else
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ __('Profile Information') }}
                        @endif
                    </h2>
                    <p class="mt-1 text-gray-100">
                        {{ __("Update your account's profile information and email address.") }}
                    </p>

                </div>
                <div class="p-6">
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <!-- Profile Image Section -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Profile Image') }}</h3>
                            <div class="flex items-center space-x-6">
                                <div class="shrink-0">
                                    <img 
                                        id="profile-image-preview"
                                        class="h-24 w-24 rounded-full object-cover border-4 border-gray-200 shadow-lg" 
                                        src="{{ $user->profile_image_url }}" 
                                        alt="{{ $user->name }}"
                                    >
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center space-x-4">
                                        <label for="profile_image" class="cursor-pointer">
                                            <span class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ __('Change Photo') }}
                                            </span>
                                            <input 
                                                id="profile_image" 
                                                name="profile_image" 
                                                type="file" 
                                                class="hidden" 
                                                accept="image/*"
                                                onchange="previewImage(event)"
                                            >
                                        </label>
                                        @if($user->profile_image)
                                            <button 
                                                type="button" 
                                                onclick="removeProfileImage()"
                                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-red-600 hover:text-red-800 transition-colors duration-200"
                                            >
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                {{ __('Remove') }}
                                            </button>
                                            <input type="hidden" id="remove_image" name="remove_image" value="0">
                                        @endif
                                    </div>
                                    <p class="mt-2 text-xs text-gray-500">
                                        {{ __('JPG, PNG or GIF. Max size 2MB.') }}
                                    </p>
                                    <x-input-error class="text-red-500 text-sm mt-1" :messages="$errors->get('profile_image')" />
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-200">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <x-input-label for="name" :value="__('Name')" class="text-sm font-medium" />
                                <div class="relative">
                                    <x-text-input 
                                        id="name" 
                                        name="name" 
                                        type="text" 
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent  transition-all duration-200" 
                                        :value="old('name', $user->name)" 
                                        required 
                                        autofocus 
                                        autocomplete="name" 
                                    />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error class="text-red-500 text-sm" :messages="$errors->get('name')" />
                            </div>

                            <div class="space-y-2">
                                <x-input-label for="email" :value="__('Email')" class="text-sm font-medium" />
                                <div class="relative">
                                    <x-text-input 
                                        id="email" 
                                        name="email" 
                                        type="email" 
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" 
                                        :value="old('email', $user->email)" 
                                        required 
                                        autocomplete="username" 
                                    />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error class="text-red-500 text-sm" :messages="$errors->get('email')" />

                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div class="mt-3 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                            <div>
                                                <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                                    {{ __('Your email address is unverified.') }}
                                                </p>
                                                <button 
                                                    form="send-verification" 
                                                    class="mt-2 inline-flex items-center text-sm text-yellow-700 dark:text-yellow-300 hover:text-yellow-900 dark:hover:text-yellow-100 font-medium underline transition-colors duration-200"
                                                >
                                                    {{ __('Click here to re-send the verification email.') }}
                                                </button>
                                            </div>
                                        </div>

                                        @if (session('status') === 'verification-link-sent')
                                            <div class="mt-3 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-md">
                                                <p class="text-sm text-green-800 dark:text-green-200 flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    {{ __('A new verification link has been sent to your email address.') }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="space-y-2 pt-6 border-t border-gray-200">
                                <x-input-label for="phone_number" :value="__('Phone Number')" class="text-sm font-medium" />
                                <div class="relative">
                                    <x-text-input 
                                        id="phone_number" 
                                        name="phone_number" 
                                        type="tel" 
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                                        :value="old('phone_number', $user->phone_number)" 
                                        autocomplete="tel" 
                                    />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5h-1.5A11.5 11.5 0 013.5 6.5v-1.5A1.5 1.5 0 015 3.5h-.5a1.5 1.5 0 01-1.5-1.5z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error class="text-red-500 text-sm" :messages="$errors->get('phone_number')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex items-center space-x-4">
                                <x-primary-button class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-00 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800">
                                    {{ __('Save Changes') }}
                                </x-primary-button>

                                @if (session('status') === 'profile-updated')
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
                                        class="inline-flex items-center px-3 py-2 bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200 rounded-lg text-sm font-medium"
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

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profile-image-preview').src = e.target.result;
        };
        reader.readAsDataURL(file);
        
        // Reset remove image flag if user selects new image
        const removeInput = document.getElementById('remove_image');
        if (removeInput) {
            removeInput.value = '0';
        }
    }
}

function removeProfileImage() {
    // Set default avatar
    document.getElementById('profile-image-preview').src = '{{ asset("images/user_profiles/default-avatar.png") }}';
    
    // Clear file input
    document.getElementById('profile_image').value = '';
    
    // Set remove flag
    document.getElementById('remove_image').value = '1';
}
</script>