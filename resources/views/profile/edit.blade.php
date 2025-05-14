@extends('layouts.app')

@section('title', 'Profile')

@section('header')
    {{ __('Profile') }}
@endsection

@section('content')

<div class="h-screen w-screen overflow-hidden bg-gradient-to-b from-gray-50 to-blue-100 py-0 px-0 flex items-center justify-center mx-auto rounded-xl shadow-lg">

    <div class="py-12">
    
   
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection