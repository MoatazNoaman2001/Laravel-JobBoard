@extends('layouts.app') {{-- تأكد إنك تستخدم layout فيه @yield('content') --}}

@section('content')
    <div class="pt-0 py-12">
        <div class="h-screen w-screen overflow-hidden bg-gradient-to-b from-gray-50 to-blue-100 py-0 px-0 flex items-center justify-center mx-auto rounded-xl shadow-lg">
            <div class="w-full max-w-6xl mx-auto">
                
                <h1 class="text-3xl font-bold mb-8 text-left">{{ __('Account Settings') }}</h1>

                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-md shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-md shadow-sm">
                        <strong>{{ __('Error!') }}</strong> {{ __('Please check the entered data.') }}
                    </div>
                @endif

                <!-- Personal Information Form -->
                <div class="p-12 border rounded-lg shadow-xl bg-white" dir="ltr">
                    <h2 class="text-2xl font-semibold mb-6 text-left">{{ __('Personal Data') }}</h2>
                    <form action="{{ route('candidate.settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                            <!-- Name -->
                            <div class="mb-8">
                                <label for="name" class="block text-lg font-medium text-gray-700">{{ __('Name') }}</label>
                                <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" class="mt-1 block w-full p-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div class="mb-8">
                                <label for="email" class="block text-lg font-medium text-gray-700">{{ __('Email') }}</label>
                                <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" class="mt-1 block w-full p-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mb-8">
                                <label for="password" class="block text-lg font-medium text-gray-700">{{ __('New Password (optional)') }}</label>
                                <input type="password" name="password" id="password" class="mt-1 block w-full p-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-8">
                                <label for="password_confirmation" class="block text-lg font-medium text-gray-700">{{ __('Confirm New Password') }}</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full p-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Update Button -->
                        <div class="mt-12">
                            <button type="submit" class="w-full p-5 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-500" style="background-color: rgb(59, 130, 246, 0.7);">
                                {{ __('Update Data') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection