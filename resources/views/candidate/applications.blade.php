@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('My Applications') }}
    </h2>
@endsection

@section('content')
    <div class="h-screen w-screen overflow-hidden bg-gradient-to-b from-gray-50 to-blue-100 py-0 px-0 flex items-center justify-center mx-auto rounded-xl shadow-lg">
        <div class="w-4/5 h-5/6 mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-20">
                <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    <span class="block">Job Applications</span>
                    <span class="block text-blue-600 mt-2">Your Application Record</span>
                </h1>
                <p class="mt-3 max-w-2xl mx-auto text-gray-500 sm:mt-4">
                    Here you can track all the job applications you have submitted and their status.
                </p>
            </div>

            <!-- Alerts -->
            <div class="max-w-4xl mx-auto space-y-4 mb-8">
                <!-- Success Message -->
                @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)" 
                     class="rounded-md bg-green-50 p-4 border border-green-200 shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Error Message -->
                @if (session('error'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)" 
                     class="rounded-md bg-red-50 p-4 border border-red-200 shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Applications Content -->
            <div class="max-w-4xl mx-auto h-full">
                @if ($applications->isEmpty())
                <!-- Empty State -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden p-8 text-center flex flex-col items-center justify-center">
                    <div class="mx-auto h-24 w-24 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No Applications</h3>
                    <p class="mt-1 text-sm text-gray-500">You have not applied for any jobs yet.</p>
                    <div class="mt-6">
                        <a href="{{ route('candidate.jobs.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                            Browse Available Jobs
                            <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
                @else
                <!-- Applications Table -->
                <div class="bg-white shadow-xl rounded-xl overflow-hidden h-full flex flex-col">
                    <div class="overflow-x-auto flex-1">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submission Date</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($applications as $application)
                                <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-md bg-blue-100 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $application->job->title ?? 'Job Unavailable' }}</div>
                                                <div class="text-sm text-gray-500">{{ $application->job->company->name ?? 'Not Specified' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($application->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                               'bg-red-100 text-red-800') }}">
                                            @if($application->status === 'pending')
                                                Pending
                                            @elseif($application->status === 'approved')
                                                Approved
                                            @else
                                                Rejected
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-500">
                                        {{ $application->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-sm font-medium">
                                        @if ($application->status === 'pending')
                                        <div class="flex space-x-2">
                                            <form action="{{ route('candidate.applications.cancel', $application) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900 transition duration-150 ease-in-out"
                                                        onclick="return confirm('Are you sure you want to cancel this application?')">
                                                    Cancel
                                                </button>
                                            </form>
                                            <a href="{{ route('jobs.show', $application->job) }}" class="text-blue-600 hover:text-blue-900 transition duration-150 ease-in-out">
                                                View
                                            </a>
                                        </div>
                                        @else
                                        <a href="{{ route('jobs.show', $application->job) }}" class="text-blue-600 hover:text-blue-900 transition duration-150 ease-in-out">
                                            View Details
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="bg-gray-50 px-6 py-3 flex items-center justify-between border-t border-gray-200">
                        {{ $applications->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    @endpush
@endsection