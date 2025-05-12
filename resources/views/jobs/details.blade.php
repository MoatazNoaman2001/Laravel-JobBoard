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
                                    {{-- {{ is_array($job->location) ? ($job->location['city'] ?? 'N/A') : (json_decode($job->location, true)['city'] ?? 'N/A' }} --}}
                                    {{ json_decode($job->location, true)['city'] }}, {{ json_decode($job->location, true)['country'] }}
                                </span>
                                <span class="badge bg-{{ $job->work_type == 'on_site' ? 'info' : 'warning' }} bg-opacity-10 text-{{ $job->work_type == 'on_site' ? 'info' : 'warning' }}">
                                    {{ str_replace('_', ' ', $job->work_type) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Overview Section -->
                    <div class="mb-5">
                        <h3 class="h5 fw-bold mb-3 text-primary">Job Overview</h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 text-primary">
                                            <i class="fas fa-money-bill-wave fs-4"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0 fw-bold">Salary Range</h6>
                                            <p class="mb-0">{{ json_decode($job->salary_range, true)['min'] }} - {{ json_decode($job->salary_range, true)['max'] }} EGP</p>
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
                                            <p class="mb-0">{{ \Carbon\Carbon::parse($job->application_deadline)->format('M d, Y') }}</p>
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
                                            <p class="mb-0">{{ $job->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 text-primary">
                                            <i class="fas fa-tags fs-4"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0 fw-bold">Job Type</h6>
                                            <p class="mb-0 text-capitalize">{{ str_replace('_', ' ', $job->work_type) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Job Description -->
                    <div class="mb-5">
                        <h3 class="h5 fw-bold mb-3 text-primary">Job Description</h3>
                        <div class="ps-3">
                            {!! nl2br(e($job->responsibilities)) !!}
                        </div>
                    </div>

                    <!-- Skills Required -->
                    <div class="mb-5">
                        <h3 class="h5 fw-bold mb-3 text-primary">Skills Required</h3>
                        <div class="d-flex flex-wrap gap-2 ps-3">
                            @foreach(json_decode($job->skills) as $skill)
                                <span class="badge bg-primary bg-opacity-10 text-primary py-2 px-3">{{ $skill }}</span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Qualifications -->
                    @if($job->qualifications && !empty(array_filter(json_decode($job->qualifications, true))))
                    <div class="mb-5">
                        <h3 class="h5 fw-bold mb-3 text-primary">Qualifications</h3>
                        <ul class="ps-3">
                            @foreach(array_filter($job->qualifications) as $qualification)
                                <li>{{ $qualification }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Benefits -->
                    @if($job->benefits)
                    <div class="mb-5">
                        <h3 class="h5 fw-bold mb-3 text-primary">Benefits</h3>
                        <div class="ps-3">
                            {!! nl2br(e($job->benefits)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Location -->
                    <div class="mb-5">
                        <h3 class="h5 fw-bold mb-3 text-primary">Location</h3>
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 text-primary">
                                        <i class="fas fa-map-marker-alt fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 fw-bold">{{ $job->location['address'] ?? 'Not specified' }}</h6>
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
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between align-items-center border-top pt-4">
                        <a href="{{ route('employer.jobs') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Back to Jobs
                        </a>
                        <div>
                            @auth
                                @if(auth()->user()->isEmployer() && auth()->user()->id == $job->employer_id)
                                    <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-outline-primary me-2">
                                        <i class="fas fa-edit me-2"></i> Edit Job
                                    </a>
                                    <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this job?')">
                                            <i class="fas fa-trash me-2"></i> Delete
                                        </button>
                                    </form>
                                @else
                                    <a href="#" class="btn btn-primary px-4">
                                        <i class="fas fa-paper-plane me-2"></i> Apply Now
                                    </a>
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
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 12px;
    }
    .card-header {
        border-radius: 12px 12px 0 0 !important;
    }
    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>
@endsection