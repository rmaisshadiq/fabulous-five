@extends('layouts.main')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow-sm rounded-lg border">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-xl font-semibold text-gray-900">
                                {{ __('Verify Your Account') }}
                            </h2>

                            <p class="mt-2 text-sm text-gray-600">
                                {{ __('Please provide the following information to verify your account. All fields are required.') }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('profile.verify.store') }}" class="mt-8 space-y-6" enctype="multipart/form-data">
                            @csrf

                            <!-- Resident ID Card -->
                            <div>
                                <x-input-label for="resident_id_card" :value="__('Resident ID Card')" />
                                <input id="resident_id_card" 
                                       name="resident_id_card" 
                                       type="file" 
                                       accept="image/*"
                                       class="mt-2 block w-full text-sm text-gray-500
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-md file:border-0
                                              file:text-sm file:font-medium
                                              file:bg-blue-50 file:text-blue-700
                                              hover:file:bg-blue-100" 
                                       required />
                                <x-input-error class="mt-2" :messages="$errors->get('resident_id_card')" />
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ __('Upload a clear photo of your resident ID card. Max size: 2MB.') }}
                                </p>
                            </div>

                            <!-- Work or Student ID Card -->
                            <div>
                                <x-input-label for="work_or_student_id_card" :value="__('Work or Student ID Card')" />
                                <input id="work_or_student_id_card" 
                                       name="work_or_student_id_card" 
                                       type="file" 
                                       accept="image/*"
                                       class="mt-2 block w-full text-sm text-gray-500
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-md file:border-0
                                              file:text-sm file:font-medium
                                              file:bg-blue-50 file:text-blue-700
                                              hover:file:bg-blue-100" 
                                       required />
                                <x-input-error class="mt-2" :messages="$errors->get('work_or_student_id_card')" />
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ __('Upload a clear photo of your work or student ID card. Max size: 2MB.') }}
                                </p>
                            </div>

                            <!-- Deposit Amount -->
                            <div>
                                <x-input-label for="deposit_amount" :value="__('Deposit Amount')" />
                                <div class="mt-2 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <x-text-input id="deposit_amount" 
                                                  name="deposit_amount" 
                                                  type="number" 
                                                  step="0.01" 
                                                  min="0"
                                                  class="pl-7" 
                                                  :value="old('deposit_amount')" 
                                                  required 
                                                  placeholder="0.00" />
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('deposit_amount')" />
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ __('Enter the deposit amount you wish to make.') }}
                                </p>
                            </div>

                            <!-- Social Media Link -->
                            <div>
                                <x-input-label for="social_media_link" :value="__('Social Media Link')" />
                                <x-text-input id="social_media_link" 
                                              name="social_media_link" 
                                              type="url" 
                                              class="mt-2 block w-full" 
                                              :value="old('social_media_link')" 
                                              required 
                                              placeholder="https://www.example.com/yourprofile" />
                                <x-input-error class="mt-2" :messages="$errors->get('social_media_link')" />
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ __('Provide a link to your social media profile (Facebook, Instagram, LinkedIn, etc.).') }}
                                </p>
                            </div>

                            <!-- Information Notice -->
                            <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800">
                                            {{ __('Verification Process') }}
                                        </h3>
                                        <div class="mt-2 text-sm text-blue-700">
                                            <ul class="list-disc pl-5 space-y-1">
                                                <li>{{ __('Your verification request will be reviewed by our team.') }}</li>
                                                <li>{{ __('The review process typically takes 1-3 business days.') }}</li>
                                                <li>{{ __('You will receive an email notification once the review is complete.') }}</li>
                                                <li>{{ __('Ensure all uploaded images are clear and readable.') }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Submit Verification') }}</x-primary-button>

                                <a href="{{ route('profile.edit') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-medium text-sm text-gray-600 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection