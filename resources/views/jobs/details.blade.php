@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
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
                                <span class="badge bg-{{ $job->work_type == 'on_site' ? 'info' : ($job->work_type == 'remote' ? 'success' : 'warning') }} bg-opacity-10 text-{{ $job->work_type == 'on_site' ? 'info' : ($job->work_type == 'remote' ? 'success' : 'warning') }} text-capitalize">
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
                        <div class="d-flex flex-wrap gap-2 ps-3">
                            @foreach(json_decode($job->skills) as $skill)
                                <span class="badge bg-primary bg-opacity-10 text-primary py-2 px-3 rounded-pill">
                                    <i class="fas fa-check-circle me-1"></i> {{ $skill }}
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
    </div>
</div>

<!-- Map Script (if location is available) -->
@if(isset(json_decode($job->location, true)['address']))
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map here using Leaflet or Google Maps API
        // Example with Leaflet:
        /*
        const map = L.map('job-map').setView([latitude, longitude], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        L.marker([latitude, longitude]).addTo(map)
            .bindPopup('Job Location')
            .openPopup();
        */
    });
</script>
@endpush
@endif

<style>
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
    .card-header {
        border-radius: 12px 12px 0 0 !important;
    }
    .bg-light {
        background-color: #f8f9fa !important;
    }
    .job-description-content {
        line-height: 1.8;
    }
    .job-description-content p {
        margin-bottom: 1rem;
    }
    .table {
        border-radius: 8px;
        overflow: hidden;
    }
    .table thead th {
        background-color: #f8f9fa;
        border-bottom-width: 1px;
    }
    .badge {
        font-weight: 500;
    }
    .border-bottom {
        border-bottom: 2px solid rgba(13, 110, 253, 0.2) !important;
    }
</style>
@endsection