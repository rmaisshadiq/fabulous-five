@extends('layouts.main')

@section('title', 'Verifikasi Identitas')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-center items-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="bg-white py-8 px-4 shadow-2xl rounded-2xl sm:px-10 border border-gray-100">
            <div class="text-center mb-8">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 mb-4">
                    <svg class="h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 2a3 3 0 00-3 3v1a1 1 0 002 0V5a1 1 0 011-1h2a1 1 0 011 1v1a1 1 0 002 0V5a3 3 0 00-3-3H7z" />
                        <path fill-rule="evenodd" d="M2 7a2 2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V7zm3 3a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Verifikasi Identitas Akun</h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Harap berikan informasi berikut untuk memverifikasi akun Anda. Semua kolom wajib diisi.') }}
                </p>
            </div>

            <form method="post" action="{{ route('profile.verify.store') }}" class="mt-8 space-y-6" enctype="multipart/form-data">
                @csrf

                <!-- Kartu Tanda Penduduk (KTP) -->
                <div>
                    <x-input-label for="resident_id_card" :value="__('Kartu Tanda Penduduk (KTP)')" />
                    <input id="resident_id_card" 
                           name="resident_id_card" 
                           type="file" 
                           accept="image/*"
                           class="mt-2 block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-lg file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-blue-50 file:text-blue-700
                                  hover:file:bg-blue-100" 
                           required />
                    <x-input-error class="mt-2" :messages="$errors->get('resident_id_card')" />
                    <p class="mt-1 text-xs text-gray-500">
                        {{ __('Unggah foto KTP Anda yang jelas. Ukuran maksimal: 2MB.') }}
                    </p>
                </div>

                <!-- Kartu Pegawai atau Pelajar -->
                <div>
                    <x-input-label for="work_or_student_id_card" :value="__('Kartu Pegawai atau Pelajar')" />
                    <input id="work_or_student_id_card" 
                           name="work_or_student_id_card" 
                           type="file" 
                           accept="image/*"
                           class="mt-2 block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-lg file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-blue-50 file:text-blue-700
                                  hover:file:bg-blue-100" 
                           required />
                    <x-input-error class="mt-2" :messages="$errors->get('work_or_student_id_card')" />
                    <p class="mt-1 text-xs text-gray-500">
                        {{ __('Unggah foto kartu pegawai atau pelajar Anda yang jelas. Ukuran maksimal: 2MB.') }}
                    </p>
                </div>

                <!-- Tautan Media Sosial -->
                <div>
                    <x-input-label for="social_media_link" :value="__('Tautan Media Sosial')" />
                    <x-text-input id="social_media_link" 
                                  name="social_media_link" 
                                  type="url" 
                                  class="mt-2 block w-full" 
                                  :value="old('social_media_link')" 
                                  required 
                                  placeholder="https://www.instagram.com/akunanda" />
                    <x-input-error class="mt-2" :messages="$errors->get('social_media_link')" />
                    <p class="mt-1 text-xs text-gray-500">
                        {{ __('Berikan tautan ke profil media sosial Anda (Facebook, Instagram, LinkedIn, dll.).') }}
                    </p>
                </div>

                <!-- Catatan Informasi -->
                <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">
                                {{ __('Proses Verifikasi') }}
                            </h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>{{ __('Permintaan verifikasi Anda akan ditinjau oleh tim kami.') }}</li>
                                    <li>{{ __('Proses peninjauan biasanya memakan waktu 1-3 hari kerja.') }}</li>
                                    <li>{{ __('Anda akan menerima notifikasi email setelah proses peninjauan selesai.') }}</li>
                                    <li>{{ __('Pastikan semua gambar yang diunggah jelas dan dapat dibaca.') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t">
                    <x-primary-button class="w-full justify-center bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 rounded-lg transition-all duration-300 transform hover:scale-105">
                        {{ __('Kirim Verifikasi') }}
                    </x-primary-button>

                    <a href="{{ route('profile.edit') }}" 
                       class="w-full text-center inline-flex items-center justify-center px-4 py-3 bg-gray-200 border border-transparent rounded-lg font-medium text-sm text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition ease-in-out duration-150">
                        {{ __('Batal') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
