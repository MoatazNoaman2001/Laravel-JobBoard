@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Job Details Card (same as before) -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-4 border-0">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fas fa-briefcase text-primary fs-3"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-4">
                                <h1 class="h3 mb-1 fw-bold">{{ $job->title }}</h1>
                                <div class="d-flex flex-wrap align-items-center text-muted">
                                    <span class="me-3">
                                        <i class="fas fa-building me-1"></i>
                                        {{ $job->employer->company_name ?? 'Company Name' }}
                                    </span>
                                    <span class="me-3">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ json_decode($job->location, true)['city'] }}, {{ json_decode($job->location, true)['country'] }}
                                    </span>
                                    <span class="badge bg-{{ $job->work_type == 'on_site' ? 'info' : ($job->work_type == 'remote' ? 'success' : 'warning') }} text-white bg-opacity-10 text-{{ $job->work_type == 'on_site' ? 'info' : ($job->work_type == 'remote' ? 'success' : 'warning') }} text-capitalize">
                                        {{ str_replace('_', ' ', $job->work_type) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="card-body">
                        <div class="mb-5">
                            <h3 class="h5 fw-bold mb-4 text-primary pb-2 border-bottom">Job Overview</h3>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 text-primary">
                                                <i class="fas fa-money-bill-wave fs-4"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0 fw-bold">Salary Range</h6>
                                                <p class="mb-0">{{ number_format(json_decode($job->salary_range, true)['min']) }} - {{ number_format(json_decode($job->salary_range, true)['max']) }} EGP</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 text-primary">
                                                <i class="fas fa-clock fs-4"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0 fw-bold">Application Deadline</h6>
                                                <p class="mb-0 {{ \Carbon\Carbon::parse($job->application_deadline)->isPast() ? 'text-danger' : '' }}">
                                                    {{ \Carbon\Carbon::parse($job->application_deadline)->format('M d, Y') }}
                                                    @if(\Carbon\Carbon::parse($job->application_deadline)->isPast())
                                                        (Expired)
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 text-primary">
                                                <i class="fas fa-calendar-alt fs-4"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0 fw-bold">Posted On</h6>
                                                <p class="mb-0">{{ $job->created_at->format('M d, Y') }} ({{ $job->created_at->diffForHumans() }})</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 text-primary">
                                                <i class="fas fa-briefcase fs-4"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0 fw-bold">Experience Level</h6>
                                                <p class="mb-0 text-capitalize">{{ str_replace('_', ' ', $job->experience_level) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <!-- Job Description -->
                        <div class="mb-5">
                            <h3 class="h5 fw-bold mb-4 text-primary pb-2 border-bottom">Job Description</h3>
                            <div class="ps-3">
                                <div class="job-description-content">
                                    {!! nl2br(e($job->description)) !!}
                                </div>
                            </div>
                        </div>
    
                        <!-- Responsibilities -->
                        <div class="mb-5">
                            <h3 class="h5 fw-bold mb-4 text-primary pb-2 border-bottom">Key Responsibilities</h3>
                            <div class="ps-3">
                                <ul class="list-unstyled">
                                    @foreach(explode("\n", $job->responsibilities) as $responsibility)
                                        @if(trim($responsibility))
                                            <li class="mb-2 d-flex">
                                                <span class="me-2 text-primary">•</span>
                                                <span>{{ $responsibility }}</span>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
    
                        <!-- Skills Required -->
                        <div class="mb-5">
                            <h3 class="h5 fw-bold mb-4 text-primary pb-2 border-bottom">Skills Required</h3>
                            <div class="d-flex flex-wrap gap-2 ps-3" style="max-width: 100%;">
                                @foreach(json_decode($job->skills) as $skill)
                                    <span class="badge bg-primary text-white bg-opacity-10 text-primary py-2 px-3 rounded-pill">
                                        {{ $skill }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
    
                        <!-- Qualifications -->
                        @if($job->qualifications && !empty(array_filter(json_decode($job->qualifications, true))))
                        <div class="mb-5">
                            <h3 class="h5 fw-bold mb-4 text-primary pb-2 border-bottom">Qualifications</h3>
                            <ul class="ps-3 list-unstyled">
                                @foreach(array_filter(json_decode($job->qualifications, true)) as $qualification)
                                    <li class="mb-2 d-flex">
                                        <span class="me-2 text-primary">•</span>
                                        <span>{{ $qualification }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
    
                        <!-- Benefits -->
                        @if($job->benefits)
                        <div class="mb-5">
                            <h3 class="h5 fw-bold mb-4 text-primary pb-2 border-bottom">Benefits & Perks</h3>
                            <div class="ps-3">
                                <div class="row">
                                    @foreach(explode("\n", $job->benefits) as $benefit)
                                        @if(trim($benefit))
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex align-items-start">
                                                    <span class="badge bg-success bg-opacity-10 text-success rounded-circle p-2 me-3">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">{{ Str::before($benefit, ':') }}</h6>
                                                        <p class="mb-0 text-muted">{{ Str::after($benefit, ':') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
    
                        <!-- Location -->
                        <div class="mb-5">
                            <h3 class="h5 fw-bold mb-4 text-primary pb-2 border-bottom">Location</h3>
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 text-primary">
                                            <i class="fas fa-map-marker-alt fs-4"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1 fw-bold">{{ json_decode($job->location, true)['address'] ?? 'Not specified' }}</h6>
                                            <p class="mb-0">
                                                {{ json_decode($job->location, true)['city'] }}, 
                                                {{ json_decode($job->location, true)['state'] }}, 
                                                {{ json_decode($job->location, true)['country'] }}
                                                @if(isset(json_decode($job->location, true)['postal_code']))
                                                <br>Postal Code: {{ json_decode($job->location, true)['postal_code'] }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    @if(isset(json_decode($job->location, true)['address']))
                                    <div class="mt-3">
                                        <div id="job-map" style="height: 200px; border-radius: 8px;" class="border"></div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
    
                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center border-top pt-4">
                            <a href="{{ route('employer.jobs') }}" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-arrow-left me-2"></i> Back to Jobs
                            </a>
                            <div>
                                @auth
                                    @if(auth()->user()->isEmployer() && auth()->user()->id == $job->employer_id)
                                        <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-outline-primary me-2 px-4">
                                            <i class="fas fa-edit me-2"></i> Edit Job
                                        </a>
                                        <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger px-4" onclick="return confirm('Are you sure you want to delete this job?')">
                                                <i class="fas fa-trash me-2"></i> Delete
                                            </button>
                                        </form>
                                    {{-- @elseif(auth()->user()->isJobSeeker())
                                        @if(!\Carbon\Carbon::parse($job->application_deadline)->isPast())
                                            <a href="{{ route('job_applications.apply', $job->id) }}" class="btn btn-primary px-4">
                                                <i class="fas fa-paper-plane me-2"></i> Apply Now
                                            </a>
                                        @else
                                            <button class="btn btn-secondary px-4" disabled>
                                                <i class="fas fa-clock me-2"></i> Applications Closed
                                            </button>
                                        @endif --}}
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary px-4">
                                        <i class="fas fa-sign-in-alt me-2"></i> Login to Apply
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Applications Section (Visible only to job owner) -->
                @auth
                    @if(auth()->user()->isEmployer() && auth()->user()->id == $job->employer_id)
                        <div class="card border-0 shadow-sm mt-4">
                            <div class="card-header bg-white py-3 border-0">
                                <h3 class="h5 fw-bold mb-0 text-primary">
                                    <i class="fas fa-users me-2"></i> Job Applications ({{ $job->applications->count() }})
                                </h3>
                            </div>
                            <div class="card-body">
                                @if($job->applications->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Applicant</th>
                                                    <th>Applied On</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($job->applications as $application)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="{{ $application->user->profile_image ?? asset('images/default-profile.png') }}" alt="Profile" class="rounded-circle" width="40" height="40">
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <h6 class="mb-0">{{ $application->user->name }}</h6>
                                                                    <small class="text-muted">{{ $application->user->email }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{ $application->created_at->format('M d, Y') }}</td>
                                                        <td>
                                                            <span class="badge 
                                                                @if($application->status == 'submitted') bg-info
                                                                @elseif($application->status == 'under_review') bg-primary
                                                                @elseif($application->status == 'accepted') bg-success
                                                                @elseif($application->status == 'rejected') bg-danger
                                                                @endif">
                                                                {{ str_replace('_', ' ', $application->status) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('job_applications.show', $application->id) }}" class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-eye"></i> View
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <div class="mb-3">
                                            <i class="fas fa-user-times fa-3x text-muted"></i>
                                        </div>
                                        <h5 class="fw-bold">No applications yet</h5>
                                        <p class="text-muted">This job hasn't received any applications yet.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @endauth
            </div>

            <!-- Applications Section - Only visible to job owner -->
            @auth
                @if(auth()->user()->isEmployer() && auth()->user()->employer->id == $job->employer_id)
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                            <h3 class="h5 fw-bold mb-0 text-primary">
                                <i class="fas fa-users me-2"></i> Applications ({{ $job->applications_count ?? 0 }})
                            </h3>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown">
                                    <i class="fas fa-filter me-1"></i> Filter
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => '']) }}">All Applications</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    {{-- @foreach(Application::statusOptions() as $value => $label)
                                        <li>
                                            <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => $value]) }}">
                                                {{ $label }}
                                            </a>
                                        </li>
                                    @endforeach --}}
                                </ul>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            @if($job->applications_count > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Candidate</th>
                                                <th>Applied</th>
                                                <th>Status</th>
                                                <th>Resume</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($job->applications as $application)
                                                <tr class="{{ $application->isNew() ? 'table-info' : '' }}">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="{{ $application->candidate->profile_photo_url }}" 
                                                                     alt="{{ $application->candidate->name }}" 
                                                                     class="rounded-circle" width="40" height="40">
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <h6 class="mb-0">{{ $application->candidate->name }}</h6>
                                                                <small class="text-muted d-block">{{ $application->contact_email }}</small>
                                                                @if($application->contact_phone)
                                                                    <small class="text-muted">{{ $application->contact_phone }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span title="{{ $application->applied_at->format('M j, Y g:i a') }}">
                                                            {{ $application->applied_at->diffForHumans() }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {!! $application->status_badge !!}
                                                        @if($application->isNew())
                                                            <span class="badge bg-warning ms-1">New</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($application->resume_path)
                                                            <a href="{{ $application->resume_url }}" 
                                                               target="_blank" 
                                                               class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-download me-1"></i> Download
                                                            </a>
                                                        @else
                                                            <span class="text-muted">No resume</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ route('employer.applications.show', $application) }}" 
                                                               class="btn btn-sm btn-outline-primary"
                                                               title="View Application">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                                        type="button" 
                                                                        data-bs-toggle="dropdown">
                                                                    <i class="fas fa-cog"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a class="dropdown-item" href="#" 
                                                                           data-bs-toggle="modal" 
                                                                           data-bs-target="#statusModal{{ $application->id }}">
                                                                            <i class="fas fa-pencil-alt me-2"></i> Change Status
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="#"
                                                                           data-bs-toggle="modal"
                                                                           data-bs-target="#notesModal{{ $application->id }}">
                                                                            <i class="fas fa-edit me-2"></i> Add Notes
                                                                        </a>
                                                                    </li>
                                                                    <li><hr class="dropdown-divider"></li>
                                                                    <li>
                                                                        <form method="POST" action="{{ route('employer.applications.destroy', $application) }}">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="dropdown-item text-danger" 
                                                                                    onclick="return confirm('Are you sure you want to delete this application?')">
                                                                                <i class="fas fa-trash me-2"></i> Delete
                                                                            </button>
                                                                        </form>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Status Change Modal -->
                                                        <div class="modal fade" id="statusModal{{ $application->id }}" tabindex="-1">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <form method="POST" action="{{ route('employer.applications.update', $application) }}">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Update Application Status</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Current Status: {!! $application->status_badge !!}</label>
                                                                                <select name="status" class="form-select">
                                                                                    @foreach(Application::statusOptions() as $value => $label)
                                                                                        <option value="{{ $value }}" {{ $application->status == $value ? 'selected' : '' }}>
                                                                                            {{ $label }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit" class="btn btn-primary">Update Status</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Notes Modal -->
                                                        <div class="modal fade" id="notesModal{{ $application->id }}" tabindex="-1">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <form method="POST" action="{{ route('employer.applications.notes', $application) }}">
                                                                        @csrf
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Application Notes</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="mb-3">
                                                                                <textarea name="notes" class="form-control" rows="5" 
                                                                                          placeholder="Add private notes about this candidate...">{{ $application->notes }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit" class="btn btn-primary">Save Notes</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Pagination -->
                                @if($job->applications instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                    <div class="d-flex justify-content-center mt-4">
                                        {{ $job->applications->appends(request()->query())->links() }}
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fas fa-user-times fa-4x text-muted opacity-25"></i>
                                    </div>
                                    <h5 class="fw-bold">No applications yet</h5>
                                    <p class="text-muted mb-4">This job hasn't received any applications yet.</p>
                                    <a href="{{ route('jobs.edit', $job) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-edit me-2"></i> Edit Job Posting
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }
    .badge.bg-primary {
        background-color: #0d6efd !important;
    }
    .badge.bg-success {
        background-color: #198754 !important;
    }
    .badge.bg-danger {
        background-color: #dc3545 !important;
    }
    .badge.bg-warning {
        background-color: #ffc107 !important;
        color: #000;
    }
    .badge.bg-info {
        background-color: #0dcaf0 !important;
    }
    .dropdown-menu {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border: none;
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Initialize modals
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.addEventListener('shown.bs.modal', function () {
                const textarea = this.querySelector('textarea');
                if (textarea) {
                    textarea.focus();
                }
            });
        });
    });
</script>
@endpush
@endsection