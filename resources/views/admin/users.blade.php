@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Admin Header -->
    <div class="card mb-4" style="border: none; border-radius: 0.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); background-color: var(--primary); color: white;">
        <div class="card-body p-4">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div>
                    <h1 style="font-weight: 700; font-size: 1.75rem; margin-bottom: 0.5rem;">User Management</h1>
                    <p style="opacity: 0.9; margin-bottom: 0;">Manage all registered users on the platform</p>
                </div>
                <div>
                    <span style="background-color: rgba(255, 255, 255, 0.2); padding: 0.5rem 1rem; border-radius: 2rem; font-size: 0.875rem;">
                        <i class="fas fa-users"></i> Total Users: {{ $users->total() }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Navigation -->
    <div class="card mb-4" style="border: none; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);">
        <div class="card-body p-3">
            <div style="display: flex; gap: 0.5rem; overflow-x: auto;">
                <a href="{{ route('admin.dashboard') }}" class="btn" style="background-color: white; color: var(--gray-700); border: 1px solid var(--gray-300); border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 500;">
                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.users') }}" class="btn" style="background-color: var(--primary); color: white; border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 500;">
                    <i class="fas fa-users mr-2"></i> Users
                </a>
                <a href="{{ route('admin.jobs') }}" class="btn" style="background-color: white; color: var(--gray-700); border: 1px solid var(--gray-300); border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 500;">
                    <i class="fas fa-briefcase mr-2"></i> Jobs
                </a>
                <a href="{{ route('admin.applications') }}" class="btn" style="background-color: white; color: var(--gray-700); border: 1px solid var(--gray-300); border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 500;">
                    <i class="fas fa-file-alt mr-2"></i> Applications
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card mb-4" style="border: none; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);">
        <div class="card-body p-4">
            <form action="{{ route('admin.users') }}" method="GET">
                <div style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end;">
                    <div style="flex: 1; min-width: 200px;">
                        <label for="search" style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--gray-700); font-size: 0.875rem;">Search</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Search by name or email" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid var(--gray-300); border-radius: 0.375rem; font-size: 0.875rem;">
                    </div>

                    <div style="min-width: 150px;">
                        <label for="type" style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--gray-700); font-size: 0.875rem;">User Type</label>
                        <select id="type" name="type" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid var(--gray-300); border-radius: 0.375rem; font-size: 0.875rem;">
                            <option value="">All Types</option>
                            <option value="admin" {{ request('type') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="employer" {{ request('type') == 'employer' ? 'selected' : '' }}>Employer</option>
                            <option value="candidate" {{ request('type') == 'candidate' ? 'selected' : '' }}>Candidate</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="btn" style="background-color: var(--primary); color: white; border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 500;">
                            <i class="fas fa-search mr-2"></i> Filter
                        </button>
                        <a href="{{ route('admin.users') }}" class="btn" style="background-color: white; color: var(--gray-700); border: 1px solid var(--gray-300); border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 500; margin-left: 0.5rem;">
                            <i class="fas fa-redo-alt mr-2"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users List -->
    <div class="card" style="border: none; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);">
        <div class="card-header" style="background-color: white; border-bottom: 1px solid var(--gray-200); padding: 1rem 1.25rem;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-weight: 600; font-size: 1.25rem; margin: 0;">Users List</h3>
            </div>
        </div>

        <div class="card-body p-0">
            @if(session('success'))
                <div style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #10b981; padding: 1rem; margin: 1rem; border-radius: 0.375rem;">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background-color: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #ef4444; padding: 1rem; margin: 1rem; border-radius: 0.375rem;">
                    <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                </div>
            @endif

            @if($users->isEmpty())
                <div class="p-4 text-center" style="color: var(--gray-500);">
                    <i class="fas fa-users" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                    <p>No users found matching your criteria.</p>
                </div>
            @else
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: var(--gray-100);">
                                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">ID</th>
                                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Name</th>
                                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Email</th>
                                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Type</th>
                                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Registered</th>
                                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Status</th>
                                <th style="padding: 0.75rem 1rem; text-align: right; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">{{ $user->id }}</td>
                                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">{{ $user->name }}</td>
                                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">{{ $user->email }}</td>
                                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">
                                        @if($user->user_type == 'admin')
                                            <span style="background-color: #8b5cf6; color: white; font-size: 0.75rem; padding: 0.125rem 0.5rem; border-radius: 0.25rem;">Admin</span>
                                        @elseif($user->user_type == 'employer')
                                            <span style="background-color: #3b82f6; color: white; font-size: 0.75rem; padding: 0.125rem 0.5rem; border-radius: 0.25rem;">Employer</span>
                                        @else
                                            <span style="background-color: #10b981; color: white; font-size: 0.75rem; padding: 0.125rem 0.5rem; border-radius: 0.25rem;">Candidate</span>
                                        @endif
                                    </td>
                                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">{{ $user->created_at->format('M d, Y') }}</td>
                                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">
                                        @if($user->is_active)
                                            <span style="background-color: rgba(16, 185, 129, 0.1); color: #10b981; font-size: 0.75rem; padding: 0.125rem 0.5rem; border-radius: 0.25rem;">Active</span>
                                        @else
                                            <span style="background-color: rgba(239, 68, 68, 0.1); color: #ef4444; font-size: 0.75rem; padding: 0.125rem 0.5rem; border-radius: 0.25rem;">Inactive</span>
                                        @endif
                                    </td>
                                    <td style="padding: 0.75rem 1rem; text-align: right;">
                                        <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                            <a href="#" onclick="showUserDetails({{ $user->id }})" class="btn" style="background-color: var(--gray-100); color: var(--gray-700); font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 0.25rem;">
                                                <i class="fas fa-eye"></i> View
                                            </a>

                                            @if($user->user_type != 'admin' || auth()->id() != $user->id)
                                                @if($user->is_active)
                                                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn" style="background-color: #f59e0b; color: white; font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 0.25rem;">
                                                            <i class="fas fa-ban"></i> Disable
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn" style="background-color: #10b981; color: white; font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 0.25rem;">
                                                            <i class="fas fa-check"></i> Enable
                                                        </button>
                                                    </form>
                                                @endif

                                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn" style="background-color: #ef4444; color: white; font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 0.25rem;">
                                                        <i class="fas fa-trash"></i> Delete
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

                <!-- Pagination -->
                <div style="padding: 1rem; display: flex; justify-content: center;">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- User Details Modal -->
<div id="userDetailsModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000; overflow: auto;">
    <div style="background-color: white; margin: 10% auto; padding: 20px; width: 80%; max-width: 600px; border-radius: 0.5rem; box-shadow: var(--box-shadow-lg);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h3 style="font-weight: 600; font-size: 1.25rem; margin: 0;">User Details</h3>
            <button onclick="closeUserDetailsModal()" style="background: none; border: none; cursor: pointer; font-size: 1.25rem; color: var(--gray-500);">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="userDetailsContent" style="margin-bottom: 1rem;">
            <!-- User details will be loaded here -->
            <div style="display: flex; justify-content: center; padding: 2rem;">
                <div style="display: inline-block; width: 40px; height: 40px; border: 3px solid var(--gray-300); border-top-color: var(--primary); border-radius: 50%; animation: spin 1s linear infinite;"></div>
            </div>
        </div>
        <div style="text-align: right;">
            <button onclick="closeUserDetailsModal()" class="btn" style="background-color: var(--gray-200); color: var(--gray-700); border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 500;">
                Close
            </button>
        </div>
    </div>
</div>

<style>
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<script>
    function showUserDetails(userId) {
        document.getElementById('userDetailsModal').style.display = 'block';
        document.getElementById('userDetailsContent').innerHTML = '<div style="display: flex; justify-content: center; padding: 2rem;"><div style="display: inline-block; width: 40px; height: 40px; border: 3px solid var(--gray-300); border-top-color: var(--primary); border-radius: 50%; animation: spin 1s linear infinite;"></div></div>';

        // Fetch user details via AJAX
        fetch(`/admin/users/${userId}/details`)
            .then(response => response.json())
            .then(data => {
                let content = `
                    <div style="padding: 1rem; background-color: var(--gray-100); border-radius: 0.375rem; margin-bottom: 1rem;">
                        <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                            <div style="width: 60px; height: 60px; background-color: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-right: 1rem;">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <h4 style="font-weight: 600; font-size: 1.25rem; margin: 0;">${data.name}</h4>
                                <p style="color: var(--gray-500); margin: 0;">${data.email}</p>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                            <div>
                                <p style="font-weight: 500; margin-bottom: 0.25rem;">User Type</p>
                                <p style="margin-top: 0;">${data.user_type.charAt(0).toUpperCase() + data.user_type.slice(1)}</p>
                            </div>
                            <div>
                                <p style="font-weight: 500; margin-bottom: 0.25rem;">Status</p>
                                <p style="margin-top: 0;">${data.is_active ? 'Active' : 'Inactive'}</p>
                            </div>
                            <div>
                                <p style="font-weight: 500; margin-bottom: 0.25rem;">Registered On</p>
                                <p style="margin-top: 0;">${new Date(data.created_at).toLocaleDateString()}</p>
                            </div>
                            <div>
                                <p style="font-weight: 500; margin-bottom: 0.25rem;">Last Updated</p>
                                <p style="margin-top: 0;">${new Date(data.updated_at).toLocaleDateString()}</p>
                            </div>
                        </div>
                    </div>
                `;

                // Add specific details based on user type
                if (data.user_type === 'employer' && data.employer) {
                    content += `
                        <div style="margin-top: 1rem;">
                            <h4 style="font-weight: 600; font-size: 1.1rem; margin-bottom: 0.5rem;">Employer Details</h4>
                            <div style="padding: 1rem; border: 1px solid var(--gray-200); border-radius: 0.375rem;">
                                <div style="margin-bottom: 0.5rem;">
                                    <p style="font-weight: 500; margin-bottom: 0.25rem;">Company Name</p>
                                    <p style="margin-top: 0;">${data.employer.company_name || 'Not provided'}</p>
                                </div>
                                <div style="margin-bottom: 0.5rem;">
                                    <p style="font-weight: 500; margin-bottom: 0.25rem;">Industry</p>
                                    <p style="margin-top: 0;">${data.employer.industry || 'Not provided'}</p>
                                </div>
                                <div>
                                    <p style="font-weight: 500; margin-bottom: 0.25rem;">Company Size</p>
                                    <p style="margin-top: 0;">${data.employer.company_size || 'Not provided'}</p>
                                </div>
                            </div>
                        </div>
                    `;
                } else if (data.user_type === 'candidate' && data.candidate) {
                    content += `
                        <div style="margin-top: 1rem;">
                            <h4 style="font-weight: 600; font-size: 1.1rem; margin-bottom: 0.5rem;">Candidate Details</h4>
                            <div style="padding: 1rem; border: 1px solid var(--gray-200); border-radius: 0.375rem;">
                                <div style="margin-bottom: 0.5rem;">
                                    <p style="font-weight: 500; margin-bottom: 0.25rem;">Current Position</p>
                                    <p style="margin-top: 0;">${data.candidate.current_position || 'Not provided'}</p>
                                </div>
                                <div style="margin-bottom: 0.5rem;">
                                    <p style="font-weight: 500; margin-bottom: 0.25rem;">Skills</p>
                                    <p style="margin-top: 0;">${data.candidate.skills || 'Not provided'}</p>
                                </div>
                                <div>
                                    <p style="font-weight: 500; margin-bottom: 0.25rem;">Education</p>
                                    <p style="margin-top: 0;">${data.candidate.education || 'Not provided'}</p>
                                </div>
                            </div>
                        </div>
                    `;
                }

                document.getElementById('userDetailsContent').innerHTML = content;
            })
            .catch(error => {
                document.getElementById('userDetailsContent').innerHTML = `
                    <div style="padding: 1rem; background-color: rgba(239, 68, 68, 0.1); border-radius: 0.375rem; color: #ef4444; text-align: center;">
                        <i class="fas fa-exclamation-circle"></i> Error loading user details. Please try again.
                    </div>
                `;
                console.error('Error fetching user details:', error);
            });
    }

    function closeUserDetailsModal() {
        document.getElementById('userDetailsModal').style.display = 'none';
    }

    // Close modal when clicking outside of it
    window.onclick = function(event) {
        const modal = document.getElementById('userDetailsModal');
        if (event.target == modal) {
            closeUserDetailsModal();
        }
    }
</script>
@endsection
