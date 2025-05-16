@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Admin Header -->
    <div class="card mb-4" style="border: none; border-radius: 0.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); background-color: var(--primary); color: white;">
        <div class="card-body p-4">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div>
                    <h1 style="font-weight: 700; font-size: 1.75rem; margin-bottom: 0.5rem;">Application Management</h1>
                    <p style="opacity: 0.9; margin-bottom: 0;">Manage all job applications on the platform</p>
                </div>
                <div>
                    <span style="background-color: rgba(255, 255, 255, 0.2); padding: 0.5rem 1rem; border-radius: 2rem; font-size: 0.875rem;">
                        <i class="fas fa-file-alt"></i> Total Applications: {{ $applications->total() }}
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
                <a href="{{ route('admin.users') }}" class="btn" style="background-color: white; color: var(--gray-700); border: 1px solid var(--gray-300); border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 500;">
                    <i class="fas fa-users mr-2"></i> Users
                </a>
                <a href="{{ route('admin.jobs') }}" class="btn" style="background-color: white; color: var(--gray-700); border: 1px solid var(--gray-300); border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 500;">
                    <i class="fas fa-briefcase mr-2"></i> Jobs
                </a>
                <a href="{{ route('admin.applications') }}" class="btn" style="background-color: var(--primary); color: white; border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 500;">
                    <i class="fas fa-file-alt mr-2"></i> Applications
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card mb-4" style="border: none; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);">
        <div class="card-body p-4">
            <form action="{{ route('admin.applications') }}" method="GET">
                <div style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end;">
                    <div style="flex: 1; min-width: 200px;">
                        <label for="search" style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--gray-700); font-size: 0.875rem;">Search</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Search by job title or candidate name" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid var(--gray-300); border-radius: 0.375rem; font-size: 0.875rem;">
                    </div>
                    
                    <div style="min-width: 150px;">
                        <label for="status" style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--gray-700); font-size: 0.875rem;">Status</label>
                        <select id="status" name="status" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid var(--gray-300); border-radius: 0.375rem; font-size: 0.875rem;">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                            <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    
                    <div style="min-width: 200px;">
                        <label for="job_id" style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--gray-700); font-size: 0.875rem;">Job</label>
                        <select id="job_id" name="job_id" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid var(--gray-300); border-radius: 0.375rem; font-size: 0.875rem;">
                            <option value="">All Jobs</option>
                            @foreach($jobs as $job)
                                <option value="{{ $job->id }}" {{ request('job_id') == $job->id ? 'selected' : '' }}>{{ $job->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <button type="submit" class="btn" style="background-color: var(--primary); color: white; border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 500;">
                            <i class="fas fa-search mr-2"></i> Filter
                        </button>
                        <a href="{{ route('admin.applications') }}" class="btn" style="background-color: white; color: var(--gray-700); border: 1px solid var(--gray-300); border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 500; margin-left: 0.5rem;">
                            <i class="fas fa-redo-alt mr-2"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Applications List -->
    <div class="card" style="border: none; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);">
        <div class="card-header" style="background-color: white; border-bottom: 1px solid var(--gray-200); padding: 1rem 1.25rem;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-weight: 600; font-size: 1.25rem; margin: 0;">Applications List</h3>
                <div>
                    <span class="badge" style="background-color: #f59e0b; color: white; font-weight: 500; padding: 0.25rem 0.75rem; border-radius: 2rem; margin-right: 0.5rem;">
                        <i class="fas fa-clock"></i> {{ $applications->where('status', 'pending')->count() }} Pending
                    </span>
                    <span class="badge" style="background-color: #10b981; color: white; font-weight: 500; padding: 0.25rem 0.75rem; border-radius: 2rem;">
                        <i class="fas fa-check"></i> {{ $applications->where('status', 'accepted')->count() }} Accepted
                    </span>
                </div>
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

            @if($applications->isEmpty())
                <div class="p-4 text-center" style="color: var(--gray-500);">
                    <i class="fas fa-file-alt" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                    <p>No applications found matching your criteria.</p>
                </div>
            @else
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: var(--gray-100);">
                                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">ID</th>
                                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Job Title</th>
                                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Candidate</th>
                                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Status</th>
                                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Applied</th>
                                <th style="padding: 0.75rem 1rem; text-align: right; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($applications as $application)
                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">{{ $application->id }}</td>
                                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">{{ $application->job->title }}</td>
                                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">{{ $application->candidate->user->name }}</td>
                                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">
                                        @if($application->status == 'pending')
                                            <span style="background-color: rgba(245, 158, 11, 0.1); color: #f59e0b; font-size: 0.75rem; padding: 0.125rem 0.5rem; border-radius: 0.25rem;">Pending</span>
                                        @elseif($application->status == 'reviewed')
                                            <span style="background-color: rgba(59, 130, 246, 0.1); color: #3b82f6; font-size: 0.75rem; padding: 0.125rem 0.5rem; border-radius: 0.25rem;">Reviewed</span>
                                        @elseif($application->status == 'accepted')
                                            <span style="background-color: rgba(16, 185, 129, 0.1); color: #10b981; font-size: 0.75rem; padding: 0.125rem 0.5rem; border-radius: 0.25rem;">Accepted</span>
                                        @else
                                            <span style="background-color: rgba(239, 68, 68, 0.1); color: #ef4444; font-size: 0.75rem; padding: 0.125rem 0.5rem; border-radius: 0.25rem;">Rejected</span>
                                        @endif
                                    </td>
                                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">{{ $application->created_at->format('M d, Y') }}</td>
                                    <td style="padding: 0.75rem 1rem; text-align: right;">
                                        <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                            <a href="#" onclick="showApplicationDetails({{ $application->id }})" class="btn" style="background-color: var(--gray-100); color: var(--gray-700); font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 0.25rem;">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            
                                            <button onclick="showStatusUpdateModal({{ $application->id }}, '{{ $application->status }}')" class="btn" style="background-color: #3b82f6; color: white; font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 0.25rem;">
                                                <i class="fas fa-edit"></i> Update
                                            </button>
                                            
                                            <form action="{{ route('admin.applications.delete', $application->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this application? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn" style="background-color: #ef4444; color: white; font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 0.25rem;">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div style="padding: 1rem; display: flex; justify-content: center;">
                    {{ $applications->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Application Details Modal -->
<div id="applicationDetailsModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000; overflow: auto;">
    <div style="background-color: white; margin: 5% auto; padding: 20px; width: 90%; max-width: 800px; border-radius: 0.5rem; box-shadow: var(--box-shadow-lg);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h3 style="font-weight: 600; font-size: 1.25rem; margin: 0;">Application Details</h3>
            <button onclick="closeApplicationDetailsModal()" style="background: none; border: none; cursor: pointer; font-size: 1.25rem; color: var(--gray-500);">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="applicationDetailsContent" style="margin-bottom: 1rem;">
            <!-- Application details will be loaded here -->
            <div style="display: flex; justify-content: center; padding: 2rem;">
                <div style="display: inline-block; width: 40px; height: 40px; border: 3px solid var(--gray-300); border-top-color: var(--primary); border-radius: 50%; animation: spin 1s linear infinite;"></div>
            </div>
        </div>
        <div style="text-align: right;">
            <button onclick="closeApplicationDetailsModal()" class="btn" style="background-color: var(--gray-200); color: var(--gray-700); border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 500;">
                Close
            </button>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusUpdateModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000; overflow: auto;">
    <div style="background-color: white; margin: 10% auto; padding: 20px; width: 90%; max-width: 500px; border-radius: 0.5rem; box-shadow: var(--box-shadow-lg);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h3 style="font-weight: 600; font-size: 1.25rem; margin: 0;">Update Application Status</h3>
            <button onclick="closeStatusUpdateModal()" style="background: none; border: none; cursor: pointer; font-size: 1.25rem; color: var(--gray-500);">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="statusUpdateForm" action="" method="POST">
            @csrf
            <div style="margin-bottom: 1rem;">
                <label for="status" style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--gray-700);">Status</label>
                <select id="statusSelect" name="status" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid var(--gray-300); border-radius: 0.375rem;">
                    <option value="pending">Pending</option>
                    <option value="reviewed">Reviewed</option>
                    <option value="accepted">Accepted</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <div style="margin-bottom: 1rem;">
                <label for="notes" style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--gray-700);">Notes</label>
                <textarea id="notes" name="notes" rows="4" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid var(--gray-300); border-radius: 0.375rem; resize: vertical;"></textarea>
            </div>
            <div style="text-align: right;">
                <button type="button" onclick="closeStatusUpdateModal()" class="btn" style="background-color: var(--gray-200); color: var(--gray-700); border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 500; margin-right: 0.5rem;">
                    Cancel
                </button>
                <button type="submit" class="btn" style="background-color: var(--primary); color: white; border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 500;">
                    Update Status
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<script>
    function showApplicationDetails(applicationId) {
        document.getElementById('applicationDetailsModal').style.display = 'block';
        document.getElementById('applicationDetailsContent').innerHTML = '<div style="display: flex; justify-content: center; padding: 2rem;"><div style="display: inline-block; width: 40px; height: 40px; border: 3px solid var(--gray-300); border-top-color: var(--primary); border-radius: 50%; animation: spin 1s linear infinite;"></div></div>';
        
        // Fetch application details via AJAX
        fetch(`/admin/applications/${applicationId}/details`)
            .then(response => response.json())
            .then(data => {
                let content = `
                    <div style="padding: 1rem; background-color: var(--gray-100); border-radius: 0.375rem; margin-bottom: 1rem;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                            <div>
                                <h4 style="font-weight: 600; font-size: 1.5rem; margin: 0 0 0.5rem 0;">${data.job.title}</h4>
                                <p style="color: var(--gray-700); margin: 0 0 0.25rem 0;">
                                    <i class="fas fa-building" style="color: var(--primary);"></i> ${data.job.employer.company_name}
                                </p>
                                <p style="color: var(--gray-700); margin: 0 0 0.25rem 0;">
                                    <i class="fas fa-user" style="color: var(--primary);"></i> ${data.candidate.user.name}
                                </p>
                                <p style="color: var(--gray-700); margin: 0;">
                                    <i class="fas fa-envelope" style="color: var(--primary);"></i> ${data.candidate.user.email}
                                </p>
                            </div>
                            <div>
                                <span style="display: inline-block; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 500; ${
                                    data.status === 'pending' ? 'background-color: rgba(245, 158, 11, 0.1); color: #f59e0b;' :
                                    data.status === 'reviewed' ? 'background-color: rgba(59, 130, 246, 0.1); color: #3b82f6;' :
                                    data.status === 'accepted' ? 'background-color: rgba(16, 185, 129, 0.1); color: #10b981;' :
                                    'background-color: rgba(239, 68, 68, 0.1); color: #ef4444;'
                                }">
                                    ${data.status.charAt(0).toUpperCase() + data.status.slice(1)}
                                </span>
                            </div>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1rem;">
                            <div>
                                <p style="font-weight: 500; margin-bottom: 0.25rem;">Applied On</p>
                                <p style="margin-top: 0;">${new Date(data.created_at).toLocaleDateString()}</p>
                            </div>
                            <div>
                                <p style="font-weight: 500; margin-bottom: 0.25rem;">Last Updated</p>
                                <p style="margin-top: 0;">${new Date(data.updated_at).toLocaleDateString()}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div style="margin-top: 1.5rem;">
                        <h5 style="font-weight: 600; font-size: 1.1rem; margin-bottom: 0.75rem;">Cover Letter</h5>
                        <div style="padding: 1rem; border: 1px solid var(--gray-200); border-radius: 0.375rem; background-color: white;">
                            ${data.cover_letter || 'No cover letter provided.'}
                        </div>
                    </div>
                    
                    <div style="margin-top: 1.5rem;">
                        <h5 style="font-weight: 600; font-size: 1.1rem; margin-bottom: 0.75rem;">Candidate Skills</h5>
                        <div style="padding: 1rem; border: 1px solid var(--gray-200); border-radius: 0.375rem; background-color: white;">
                            ${data.candidate.skills || 'No skills listed.'}
                        </div>
                    </div>
                    
                    <div style="margin-top: 1.5rem;">
                        <h5 style="font-weight: 600; font-size: 1.1rem; margin-bottom: 0.75rem;">Notes</h5>
                        <div style="padding: 1rem; border: 1px solid var(--gray-200); border-radius: 0.375rem; background-color: white;">
                            ${data.notes || 'No notes added.'}
                        </div>
                    </div>
                `;
                
                document.getElementById('applicationDetailsContent').innerHTML = content;
            })
            .catch(error => {
                document.getElementById('applicationDetailsContent').innerHTML = `
                    <div style="padding: 1rem; background-color: rgba(239, 68, 68, 0.1); border-radius: 0.375rem; color: #ef4444; text-align: center;">
                        <i class="fas fa-exclamation-circle"></i> Error loading application details. Please try again.
                    </div>
                `;
                console.error('Error fetching application details:', error);
            });
    }
    
    function closeApplicationDetailsModal() {
        document.getElementById('applicationDetailsModal').style.display = 'none';
    }
    
    function showStatusUpdateModal(applicationId, currentStatus) {
        document.getElementById('statusUpdateModal').style.display = 'block';
        document.getElementById('statusUpdateForm').action = `/admin/applications/${applicationId}/update-status`;
        document.getElementById('statusSelect').value = currentStatus;
    }
    
    function closeStatusUpdateModal() {
        document.getElementById('statusUpdateModal').style.display = 'none';
    }
    
    // Close modals when clicking outside of them
    window.onclick = function(event) {
        const applicationModal = document.getElementById('applicationDetailsModal');
        const statusModal = document.getElementById('statusUpdateModal');
        
        if (event.target == applicationModal) {
            closeApplicationDetailsModal();
        }
        
        if (event.target == statusModal) {
            closeStatusUpdateModal();
        }
    }
</script>
@endsection
