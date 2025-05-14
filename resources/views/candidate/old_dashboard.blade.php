<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Candidate Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p>{{ __('Welcome, :name!', ['name' => auth()->user()->name]) }}</p>
                    <ul class="mt-4 space-y-2">
                        <li><a href="{{ route('candidate.jobs.index') }}" class="text-blue-600 hover:underline">{{ __('Browse Jobs') }}</a></li>
                        <li><a href="{{ route('candidate.applications') }}" class="text-blue-600 hover:underline">{{ __('Manage Your Applications') }}</a></li>
                        <li><a href="{{ route('candidate.settings') }}" class="text-blue-600 hover:underline">{{ __('Update Account Settings') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>