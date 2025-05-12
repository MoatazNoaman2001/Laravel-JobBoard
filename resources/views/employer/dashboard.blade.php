@extends('layouts.app')

@section('title', 'Employer Dashboard')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Dashboard</h2>
                <a href="{{ route('job.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Post New Job
                </a>
            </div>

            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Jobs Posted</h5>
                            <p class="display-4 mb-0">{{ $jobs->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jobs List -->
            <h4 class="mb-3">Your Job Postings</h4>
            
            @if($jobs->isEmpty())
                <div class="alert alert-info">
                    You haven't posted any jobs yet. Get started by posting your first job!
                </div>
            @else
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    @foreach($jobs as $job)
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h5 class="card-title">{{ $job->title }}</h5>
                                            <p class="text-muted mb-1">
                                                <i class="bi bi-geo-alt"></i> {{ $job->location }}
                                            </p>
                                        </div>
                                        <span class="badge bg-secondary">{{ $job->work_type }}</span>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <p class="card-text text-truncate">{{ $job->description }}</p>
                                    </div>
                                    
                                    <div class="row mt-3">
                                        <div class="col">
                                            <small class="text-muted">
                                                <i class="bi bi-clock"></i> Posted: 
                                                {{ $job->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        <div class="col text-end">
                                            <small class="text-muted">
                                                <i class="bi bi-people"></i> Applications: 0
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            Closes: {{ $job->application_deadline->format('M d, Y') }}
                                        </small>
                                        <a href="{{ route('job_postings.show', $job->id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            View Applications
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection