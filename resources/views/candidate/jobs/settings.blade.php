<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Account Settings') }}
        </h2>
    </x-slot>

    <div class="h-screen w-screen overflow-hidden bg-gradient-to-b from-gray-50 to-blue-100 py-0 px-0 flex items-center justify-center mx-auto rounded-xl shadow-lg">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('candidate.settings.update') }}">
                        @csrf
                        <div class="mb-3">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" value="{{ old('name', auth()->user()->name) }}" class="block mt-1 w-full" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="mb-3">
                            <x-input-label for="email" :value="__('Email Address')" />
                            <x-text-input id="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="block mt-1 w-full" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <x-primary-button>
                            {{ __('Update Settings') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>