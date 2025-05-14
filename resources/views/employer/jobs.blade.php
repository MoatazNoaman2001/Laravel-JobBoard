@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- <p>{{auth()->user()}}</p> --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Job Listings</h1>
        <a href="{{ route('jobs.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus me-2"></i> Post New Job
        </a>
    </div>

    @if($jobs->isEmpty())
        <div class="alert alert-info text-center py-4">
            <i class="fas fa-info-circle fa-2x mb-3"></i>
            <h4>You haven't posted any jobs yet</h4>
            <p class="mb-0">Get started by posting your first job opportunity</p>
        </div>
    @else
        <div class="row g-4">
            @foreach($jobs as $job)
                <div class="">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="card-header bg-white border-0 pb-0">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <img src="{{$job->logo}}" alt="">
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-0 fw-bold">{{ $job->title }}</h5>
                                    <div class="text-muted small">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ $job->location['city'] ?? '' }}, {{ $job->location['country'] ?? '' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body pt-3">
                            <div class="mb-3">
                                <h6 class="fw-bold text-primary">Responsibilities</h6>
                                <p class="text-muted">{{ Str::limit($job->responsibilities, 120) }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="fw-bold text-primary">Skills Required</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach(json_decode($job->skills) as $skill)
                                        <span class="badge bg-primary bg-opacity-10 text-primary">{{ $skill }}</span>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="fw-bold text-primary">Salary Range</h6>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-success bg-opacity-10 text-success">
                                        {{ json_decode($job->salary_range, true)['min'] }} - {{ json_decode($job->salary_range, true)['max'] }} EGP                                    </span>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-{{ $job->work_type == 'on_site' ? 'info' : 'warning' }} bg-opacity-10 text-{{ $job->work_type == 'on_site' ? 'info' : 'warning' }}">
                                        <i class="fas fa-{{ $job->work_type == 'on_site' ? 'building' : 'laptop' }} me-1"></i>
                                        {{ str_replace('_', ' ', $job->work_type) }}
                                    </span>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted">Deadline: {{ $job->application_deadline }}</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-white border-0 pt-0">
                            <div class="d-flex justify-content-between">
                                <form method="GET" action="{{ route('jobs.index', ['id' => $job->id]) }}">
                                    @csrf
                                    <button class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i> View Details
                                    </button>
                                </form>
                                <div>
                                    <form method="GET" action="{{ route('jobs.edit', $job->id) }}" class="d-inline">
                                        @csrf
                                        <Button class="btn btn-outline-success btn-sm me-1">
                                            Edit
                                        </Button>
                                    </form>
                                    <form method="POST" action="{{ route('jobs.destroy', $job->id) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <Button class="btn btn-outline-danger btn-sm">
                                            Delete
                                        </Button>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        
    @endif
</div>

<style>
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }
    .transition-all {
        transition: all 0.3s ease;
    }
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
</style>
@endsection