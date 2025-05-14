<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Candidate Dashboard') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-blue-100 via-white to-blue-50 dark:from-gray-800 dark:via-gray-900 dark:to-gray-800 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                    {{ __('Welcome, :name!', ['name' => auth()->user()->name]) }}
                </h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    {{ __('Your journey to the perfect job starts here! Explore opportunities, manage your applications, and update your profile.') }}
                </p>
            </div>

            <!-- Action Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Browse Jobs Card -->
                <a href="{{ route('candidate.jobs.index') }}" class="group bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center space-x-4">
                        <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full group-hover:bg-blue-200 dark:group-hover:bg-blue-800 transition-colors duration-300">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('Browse Jobs') }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Find your dream job from thousands of opportunities.') }}</p>
                        </div>
                    </div>
                </a>

                <!-- Manage Applications Card -->
                <a href="{{ route('candidate.applications') }}" class="group bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center space-x-4">
                        <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full group-hover:bg-green-200 dark:group-hover:bg-green-800 transition-colors duration-300">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('My Applications') }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Track and manage your job applications.') }}</p>
                        </div>
                    </div>
                </a>

                <!-- Update Settings Card -->
                <a href="{{ route('candidate.settings') }}" class="group bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center space-x-4">
                        <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-full group-hover:bg-purple-200 dark:group-hover:bg-purple-800 transition-colors duration-300">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('Account Settings') }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Update your profile and preferences.') }}</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>