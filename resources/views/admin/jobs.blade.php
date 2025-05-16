@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Admin Header -->
    <div class="card mb-4" style="border: none; border-radius: 0.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); background-color: var(--primary); color: white;">
        <div class="card-body p-4">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div>
                    <h1 style="font-weight: 700; font-size: 1.75rem; margin-bottom: 0.5rem;">Job Management</h1>
                    <p style="opacity: 0.9; margin-bottom: 0;">Manage all job listings on the platform</p>
                </div>
                <div>
                    <span style="background-color: rgba(255, 255, 255, 0.2); padding: 0.5rem 1rem; border-radius: 2rem; font-size: 0.875rem;">
                        <i class="fas fa-briefcase"></i> Total Jobs: {{ $jobs->total() }}
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
                <a href="{{ route('admin.jobs') }}" class="btn" style="background-color: var(--primary); color: white; border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 500;">
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
            <form action="{{ route('admin.jobs') }}" method="GET">
                <div style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end;">
                    <div style="flex: 1; min-width: 200px;">
                        <label for="search" style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--gray-700); font-size: 0.875rem;">Search</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Search by title or company" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid var(--gray-300); border-radius: 0.375rem; font-size: 0.875rem;">
                    </div>

                    <div style="min-width: 150px;">
                        <label for="status" style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--gray-700); font-size: 0.875rem;">Status</label>
                        <select id="status" name="status" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid var(--gray-300); border-radius: 0.375rem; font-size: 0.875rem;">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="btn" style="background-color: var(--primary); color: white; border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 500;">
                            <i class="fas fa-search mr-2"></i> Filter
                        </button>
                        <a href="{{ route('admin.jobs') }}" class="btn" style="background-color: white; color: var(--gray-700); border: 1px solid var(--gray-300); border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 500; margin-left: 0.5rem;">
                            <i class="fas fa-redo-alt mr-2"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Jobs List -->
    <div class="card" style="border: none; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);">
        <div class="card-header" style="background-color: white; border-bottom: 1px solid var(--gray-200); padding: 1rem 1.25rem;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-weight: 600; font-size: 1.25rem; margin: 0;">Jobs List</h3>
                <div>
                    <span class="badge" style="background-color: #f59e0b; color: white; font-weight: 500; padding: 0.25rem 0.75rem; border-radius: 2rem; margin-right: 0.5rem;">
                        <i class="fas fa-clock"></i> {{ $jobs->where('status', 'pending')->count() }} Pending
                    </span>
                    <span class="badge" style="background-color: #10b981; color: white; font-weight: 500; padding: 0.25rem 0.75rem; border-radius: 2rem;">
                        <i class="fas fa-check"></i> {{ $jobs->where('status', 'approved')->count() }} Approved
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

            @if($jobs->isEmpty())
                <div class="p-4 text-center" style="color: var(--gray-500);">
                    <i class="fas fa-briefcase" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                    <p>No jobs found matching your criteria.</p>
                </div>
            @else
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: var(--gray-100);">
                                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">ID</th>
                                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Title</th>
                                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Company</th>
                                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Location</th>
                                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Status</th>
                                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Posted</th>
                                <th style="padding: 0.75rem 1rem; text-align: right; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jobs as $job)
                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">{{ $job->id }}</td>
                                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">{{ $job->title }}</td>
                                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">{{ $job->employer->company_name }}</td>
                                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">{{ $job->location }}</td>
                                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">
                                        @if($job->status == 'pending')
                                            <span style="background-color: rgba(245, 158, 11, 0.1); color: #f59e0b; font-size: 0.75rem; padding: 0.125rem 0.5rem; border-radius: 0.25rem;">Pending</span>
                                        @elseif($job->status == 'approved')
                                            <span style="background-color: rgba(16, 185, 129, 0.1); color: #10b981; font-size: 0.75rem; padding: 0.125rem 0.5rem; border-radius: 0.25rem;">Approved</span>
                                        @else
                                            <span style="background-color: rgba(239, 68, 68, 0.1); color: #ef4444; font-size: 0.75rem; padding: 0.125rem 0.5rem; border-radius: 0.25rem;">Rejected</span>
                                        @endif
                                    </td>
                                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">{{ $job->created_at->format('M d, Y') }}</td>
                                    <td style="padding: 0.75rem 1rem; text-align: right;">
                                        <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                            <a href="#" onclick="showJobDetails({{ $job->id }})" class="btn" style="background-color: var(--gray-100); color: var(--gray-700); font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 0.25rem;">
                                                <i class="fas fa-eye"></i> View
                                            </a>

                                            @if($job->status == 'pending')
                                                <form action="{{ route('admin.job.approve', $job->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn" style="background-color: #10b981; color: white; font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 0.25rem;">
                                                        <i class="fas fa-check"></i> Approve
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.job.reject', $job->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn" style="background-color: #ef4444; color: white; font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 0.25rem;">
                                                        <i class="fas fa-times"></i> Reject
                                                    </button>
                                                </form>
                                            @elseif($job->status == 'approved')
                                                <form action="{{ route('admin.job.reject', $job->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn" style="background-color: #ef4444; color: white; font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 0.25rem;">
                                                        <i class="fas fa-times"></i> Reject
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.job.approve', $job->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn" style="background-color: #10b981; color: white; font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 0.25rem;">
                                                        <i class="fas fa-check"></i> Approve
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('admin.job.delete', $job->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this job? This action cannot be undone.');">
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
                    {{ $jobs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Job Details Modal -->
<div id="jobDetailsModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000; overflow: auto;">
    <div style="background-color: white; margin: 5% auto; padding: 20px; width: 90%; max-width: 800px; border-radius: 0.5rem; box-shadow: var(--box-shadow-lg);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h3 style="font-weight: 600; font-size: 1.25rem; margin: 0;">Job Details</h3>
            <button onclick="closeJobDetailsModal()" style="background: none; border: none; cursor: pointer; font-size: 1.25rem; color: var(--gray-500);">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="jobDetailsContent" style="margin-bottom: 1rem;">
            <!-- Job details will be loaded here -->
            <div style="display: flex; justify-content: center; padding: 2rem;">
                <div style="display: inline-block; width: 40px; height: 40px; border: 3px solid var(--gray-300); border-top-color: var(--primary); border-radius: 50%; animation: spin 1s linear infinite;"></div>
            </div>
        </div>
        <div style="text-align: right;">
            <button onclick="closeJobDetailsModal()" class="btn" style="background-color: var(--gray-200); color: var(--gray-700); border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 500;">
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
    function showJobDetails(jobId) {
        document.getElementById('jobDetailsModal').style.display = 'block';
        document.getElementById('jobDetailsContent').innerHTML = '<div style="display: flex; justify-content: center; padding: 2rem;"><div style="display: inline-block; width: 40px; height: 40px; border: 3px solid var(--gray-300); border-top-color: var(--primary); border-radius: 50%; animation: spin 1s linear infinite;"></div></div>';

        // Fetch job details via AJAX
        fetch(`/admin/jobs/${jobId}/details`)
            .then(response => response.json())
            .then(data => {
                let content = `
                    <div style="padding: 1rem; background-color: var(--gray-100); border-radius: 0.375rem; margin-bottom: 1rem;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                            <div>
                                <h4 style="font-weight: 600; font-size: 1.5rem; margin: 0 0 0.5rem 0;">${data.title}</h4>
                                <p style="color: var(--gray-700); margin: 0 0 0.25rem 0;">
                                    <i class="fas fa-building" style="color: var(--primary);"></i> ${data.employer.company_name}
                                </p>
                                <p style="color: var(--gray-700); margin: 0 0 0.25rem 0;">
                                    <i class="fas fa-map-marker-alt" style="color: var(--primary);"></i> ${data.location}
                                </p>
                                <p style="color: var(--gray-700); margin: 0;">
                                    <i class="fas fa-money-bill-wave" style="color: var(--primary);"></i> ${data.salary}
                                </p>
                            </div>
                            <div>
                                <span style="display: inline-block; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 500; ${
                                    data.status === 'pending' ? 'background-color: rgba(245, 158, 11, 0.1); color: #f59e0b;' :
                                    data.status === 'approved' ? 'background-color: rgba(16, 185, 129, 0.1); color: #10b981;' :
                                    'background-color: rgba(239, 68, 68, 0.1); color: #ef4444;'
                                }">
                                    ${data.status.charAt(0).toUpperCase() + data.status.slice(1)}
                                </span>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 1rem;">
                            <div>
                                <p style="font-weight: 500; margin-bottom: 0.25rem;">Job Type</p>
                                <p style="margin-top: 0;">${data.job_type || 'Not specified'}</p>
                            </div>
                            <div>
                                <p style="font-weight: 500; margin-bottom: 0.25rem;">Experience</p>
                                <p style="margin-top: 0;">${data.experience || 'Not specified'}</p>
                            </div>
                            <div>
                                <p style="font-weight: 500; margin-bottom: 0.25rem;">Posted On</p>
                                <p style="margin-top: 0;">${new Date(data.created_at).toLocaleDateString()}</p>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem;">
                        <h5 style="font-weight: 600; font-size: 1.1rem; margin-bottom: 0.75rem;">Job Description</h5>
                        <div style="padding: 1rem; border: 1px solid var(--gray-200); border-radius: 0.375rem; background-color: white;">
                            ${data.description || 'No description provided.'}
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem;">
                        <h5 style="font-weight: 600; font-size: 1.1rem; margin-bottom: 0.75rem;">Application Statistics</h5>
                        <div style="padding: 1rem; border: 1px solid var(--gray-200); border-radius: 0.375rem; background-color: white;">
                            <p style="margin: 0;">Total Applications: ${data.applications_count || 0}</p>
                        </div>
                    </div>
                `;

                document.getElementById('jobDetailsContent').innerHTML = content;
            })
            .catch(error => {
                document.getElementById('jobDetailsContent').innerHTML = `
                    <div style="padding: 1rem; background-color: rgba(239, 68, 68, 0.1); border-radius: 0.375rem; color: #ef4444; text-align: center;">
                        <i class="fas fa-exclamation-circle"></i> Error loading job details. Please try again.
                    </div>
                `;
                console.error('Error fetching job details:', error);
            });
    }

    function closeJobDetailsModal() {
        document.getElementById('jobDetailsModal').style.display = 'none';
    }

    // Close modal when clicking outside of it
    window.onclick = function(event) {
        const modal = document.getElementById('jobDetailsModal');
        if (event.target == modal) {
            closeJobDetailsModal();
        }
    }
</script>
@endsection
