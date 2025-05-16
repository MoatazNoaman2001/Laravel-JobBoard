@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">User Management</h1>
    <p class="mt-1 text-sm text-gray-600">Manage all registered users on the platform</p>
</div>

<!-- Search and Filter Section -->
<div class="bg-white shadow rounded-lg mb-8 w-full">
    <div class="px-4 py-5 sm:p-6">
        <form action="{{ route('admin.users') }}" method="GET" class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" placeholder="Search by name or email">
                </div>
            </div>
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700">User Type</label>
                <select id="type" name="type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                    <option value="">All Types</option>
                    <option value="admin" {{ request('type') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="employer" {{ request('type') == 'employer' ? 'selected' : '' }}>Employer</option>
                    <option value="candidate" {{ request('type') == 'candidate' ? 'selected' : '' }}>Candidate</option>
                </select>
            </div>
            <div>
                <button type="submit" class="bg-blue-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Filter
                </button>
                <a href="{{ route('admin.users') }}" class="ml-2 bg-gray-100 border border-transparent rounded-md py-2 px-4 inline-flex justify-center text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 border-b border-gray-200 sm:px-6 flex justify-between items-center">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Users List
        </h3>
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
            {{ $users->total() }} Users
        </span>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Type
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Registered
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $user->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-500">
                                    <span class="text-sm font-medium leading-none text-white">{{ substr($user->name, 0, 1) }}</span>
                                </span>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $user->name }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $user->email }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($user->user_type == 'admin')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                Admin
                            </span>
                        @elseif($user->user_type == 'employer')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                Employer
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Candidate
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $user->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($user->is_active)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Inactive
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('admin.users.details', $user->id) }}" class="text-blue-600 hover:text-blue-900">
                                <span class="sr-only">View</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                            </a>

                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="{{ $user->is_active ? 'text-yellow-600 hover:text-yellow-900' : 'text-green-600 hover:text-green-900' }}">
                                        <span class="sr-only">{{ $user->is_active ? 'Disable' : 'Enable' }}</span>
                                        @if($user->is_active)
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd" />
                                            </svg>
                                        @else
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </button>
                                </form>

                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <span class="sr-only">Delete</span>
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 sm:px-6">
        {{ $users->links() }}
    </div>
</div>

<!-- User Details Modal -->
<div id="userDetailsModal" class="fixed inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            User Details
                        </h3>
                        <div class="mt-4" id="userDetailsContent">
                            <!-- Content will be loaded here -->
                            <div class="text-center py-10">
                                <svg class="animate-spin h-10 w-10 text-blue-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="closeUserDetailsModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function showUserDetails(userId) {
        document.getElementById('userDetailsModal').classList.remove('hidden');

        // Fetch user details
        fetch("{{ url('admin/users') }}/" + userId + "/details")
            .then(response => response.json())
            .then(data => {
                let content = `
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Basic Information</h4>
                            <div class="mt-2 grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Name</p>
                                    <p class="mt-1 text-sm text-gray-900">${data.name}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Email</p>
                                    <p class="mt-1 text-sm text-gray-900">${data.email}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">User Type</p>
                                    <p class="mt-1 text-sm text-gray-900">${data.user_type.charAt(0).toUpperCase() + data.user_type.slice(1)}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Status</p>
                                    <p class="mt-1 text-sm text-gray-900">${data.is_active ? 'Active' : 'Inactive'}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Registered On</p>
                                    <p class="mt-1 text-sm text-gray-900">${new Date(data.created_at).toLocaleDateString()}</p>
                                </div>
                            </div>
                        </div>`;

                // Add employer-specific information if available
                if (data.user_type === 'employer' && data.employer) {
                    content += `
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Employer Information</h4>
                            <div class="mt-2 grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Company Name</p>
                                    <p class="mt-1 text-sm text-gray-900">${data.employer.company_name || 'N/A'}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Industry</p>
                                    <p class="mt-1 text-sm text-gray-900">${data.employer.industry || 'N/A'}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Company Size</p>
                                    <p class="mt-1 text-sm text-gray-900">${data.employer.company_size || 'N/A'}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Website</p>
                                    <p class="mt-1 text-sm text-gray-900">${data.employer.website || 'N/A'}</p>
                                </div>
                            </div>
                        </div>`;
                }

                // Add candidate-specific information if available
                if (data.user_type === 'candidate' && data.candidate) {
                    content += `
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Candidate Information</h4>
                            <div class="mt-2 grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Current Position</p>
                                    <p class="mt-1 text-sm text-gray-900">${data.candidate.current_position || 'N/A'}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Phone</p>
                                    <p class="mt-1 text-sm text-gray-900">${data.candidate.phone || 'N/A'}</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-sm font-medium text-gray-500">Education</p>
                                    <p class="mt-1 text-sm text-gray-900">${data.candidate.education || 'N/A'}</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-sm font-medium text-gray-500">Skills</p>
                                    <p class="mt-1 text-sm text-gray-900">${data.candidate.skills || 'N/A'}</p>
                                </div>
                            </div>
                        </div>`;
                }

                content += `</div>`;
                document.getElementById('userDetailsContent').innerHTML = content;
            })
            .catch(error => {
                document.getElementById('userDetailsContent').innerHTML = `
                    <div class="text-center py-4">
                        <p class="text-red-500">Error loading user details. Please try again.</p>
                    </div>
                `;
                console.error('Error fetching user details:', error);
            });
    }

    function closeUserDetailsModal() {
        document.getElementById('userDetailsModal').classList.add('hidden');
    }
</script>
@endsection
