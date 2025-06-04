@extends('layouts.main')

@section('title', 'Profile')

@section('content')
    <section>
        {{-- herosection --}}
        @include('profile.partials.update-profile-information-form')

        {{-- company overview --}}
        @include('profile.partials.update-password-form')

        {{-- visi misi --}}
        @include('profile.partials.delete-user-form')

    </section>
@endsection
